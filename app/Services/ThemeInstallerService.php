<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;
use ZipArchive;

class ThemeInstallerService
{
    /**
     * Install a complete NewsHub theme ZIP.
     */
    public function install(
        UploadedFile $zipFile,
        string $themeName
    ): string {

        if (!$zipFile->isValid()) {
            throw new RuntimeException(
                'Theme ZIP upload failed.'
            );
        }

        if (
            strtolower(
                $zipFile->getClientOriginalExtension()
            ) !== 'zip'
        ) {
            throw new RuntimeException(
                'Only ZIP files are allowed.'
            );
        }

        $slug = Str::slug($themeName);

        if (!$slug) {
            throw new RuntimeException(
                'Invalid theme name.'
            );
        }

        $themesRoot = resource_path(
            'views/frontend/themes'
        );

        $themeFolder =
            $themesRoot .
            DIRECTORY_SEPARATOR .
            $slug;

        if (File::exists($themeFolder)) {
            throw new RuntimeException(
                'A theme folder with this name already exists.'
            );
        }

        $tempFolder = storage_path(
            'app/theme-installer/' .
            Str::uuid()
        );

        File::makeDirectory(
            $tempFolder,
            0755,
            true
        );

        try {

            $zip = new ZipArchive();

            $result = $zip->open(
                $zipFile->getRealPath()
            );

            if ($result !== true) {
                throw new RuntimeException(
                    'Unable to open the Theme ZIP file.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Security Check
            |--------------------------------------------------------------------------
            */

            for (
                $i = 0;
                $i < $zip->numFiles;
                $i++
            ) {

                $fileName =
                    $zip->getNameIndex($i);

                if (!$fileName) {
                    continue;
                }

                $normalized =
                    str_replace(
                        '\\',
                        '/',
                        $fileName
                    );

                if (
                    Str::startsWith(
                        $normalized,
                        '/'
                    ) ||
                    Str::contains(
                        $normalized,
                        '../'
                    ) ||
                    Str::contains(
                        $normalized,
                        '..\\'
                    )
                ) {

                    $zip->close();

                    throw new RuntimeException(
                        'The ZIP contains an unsafe file path.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Extract
            |--------------------------------------------------------------------------
            */

            if (
                !$zip->extractTo(
                    $tempFolder
                )
            ) {

                $zip->close();

                throw new RuntimeException(
                    'Unable to extract the Theme ZIP file.'
                );
            }

            $zip->close();

            /*
            |--------------------------------------------------------------------------
            | Find Theme Root
            |--------------------------------------------------------------------------
            */

            $themeSource =
                $this->findThemeRoot(
                    $tempFolder
                );

            if (!$themeSource) {
                throw new RuntimeException(
                    'Invalid NewsHub theme ZIP.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Required Theme File
            |--------------------------------------------------------------------------
            */

            $homeFile =
                $themeSource .
                DIRECTORY_SEPARATOR .
                'home.blade.php';

            if (!File::exists($homeFile)) {

                throw new RuntimeException(
                    'Invalid theme. home.blade.php is required.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Theme Metadata
            |--------------------------------------------------------------------------
            */

            $themeJson =
                $themeSource .
                DIRECTORY_SEPARATOR .
                'theme.json';

            if (File::exists($themeJson)) {

                $metadata =
                    json_decode(
                        File::get($themeJson),
                        true
                    );

                if (
                    !is_array($metadata)
                ) {

                    throw new RuntimeException(
                        'Invalid theme.json file.'
                    );
                }

                if (
                    isset($metadata['name']) &&
                    !is_string(
                        $metadata['name']
                    )
                ) {

                    throw new RuntimeException(
                        'Invalid theme.json: name must be a string.'
                    );
                }

                if (
                    isset($metadata['version']) &&
                    !is_string(
                        $metadata['version']
                    )
                ) {

                    throw new RuntimeException(
                        'Invalid theme.json: version must be a string.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Optional Theme Structure
            |--------------------------------------------------------------------------
            |
            | A complete theme can contain:
            |
            | home.blade.php
            | news/show.blade.php
            | category/show.blade.php
            | search/index.blade.php
            | layouts/
            | partials/
            | assets/
            | theme.json
            |
            |--------------------------------------------------------------------------
            */

            $this->validateThemeFiles(
                $themeSource
            );

            /*
            |--------------------------------------------------------------------------
            | Install
            |--------------------------------------------------------------------------
            */

            File::makeDirectory(
                $themeFolder,
                0755,
                true
            );

            File::copyDirectory(
                $themeSource,
                $themeFolder
            );

            return $slug;

        } catch (\Throwable $e) {

            if (
                File::exists(
                    $themeFolder
                )
            ) {
                File::deleteDirectory(
                    $themeFolder
                );
            }

            throw $e;

        } finally {

            if (
                File::exists(
                    $tempFolder
                )
            ) {
                File::deleteDirectory(
                    $tempFolder
                );
            }
        }
    }

    /**
     * Find the actual theme root inside ZIP.
     */
    private function findThemeRoot(
        string $tempFolder
    ): ?string {

        /*
        |--------------------------------------------------------------------------
        | ZIP directly contains home.blade.php
        |--------------------------------------------------------------------------
        */

        if (
            File::exists(
                $tempFolder .
                DIRECTORY_SEPARATOR .
                'home.blade.php'
            )
        ) {
            return $tempFolder;
        }

        /*
        |--------------------------------------------------------------------------
        | ZIP contains one theme directory
        |--------------------------------------------------------------------------
        */

        $directories =
            File::directories(
                $tempFolder
            );

        foreach (
            $directories as $directory
        ) {

            if (
                File::exists(
                    $directory .
                    DIRECTORY_SEPARATOR .
                    'home.blade.php'
                )
            ) {
                return $directory;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Search recursively
        |--------------------------------------------------------------------------
        */

        $files =
            File::allFiles(
                $tempFolder
            );

        foreach (
            $files as $file
        ) {

            if (
                strtolower(
                    $file->getFilename()
                ) === 'home.blade.php'
            ) {

                return dirname(
                    $file->getPathname()
                );
            }
        }

        return null;
    }

    /**
     * Validate optional NewsHub theme structure.
     */
    private function validateThemeFiles(
        string $themeSource
    ): void {

        $optionalFiles = [

            'news/show.blade.php',

            'category/show.blade.php',

            'search/index.blade.php',

        ];

        /*
        |--------------------------------------------------------------------------
        | These are optional.
        |--------------------------------------------------------------------------
        |
        | Missing files will use NewsHub fallback templates.
        |--------------------------------------------------------------------------
        */

        foreach (
            $optionalFiles as $file
        ) {

            $path =
                $themeSource .
                DIRECTORY_SEPARATOR .
                str_replace(
                    '/',
                    DIRECTORY_SEPARATOR,
                    $file
                );

            if (
                File::exists($path) &&
                !File::isFile($path)
            ) {

                throw new RuntimeException(
                    'Invalid theme file: ' . $file
                );
            }
        }
    }
}