<?php

$basePath = __DIR__ . '/resources/views/frontend/themes';

if (!is_dir($basePath)) {
    exit("ERROR: Theme directory not found.\n");
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($basePath)
);

$updatedFiles = 0;
$totalReplacements = 0;

foreach ($files as $file) {

    if (!$file->isFile()) {
        continue;
    }

    if (!str_ends_with(strtolower($file->getFilename()), '.blade.php')) {
        continue;
    }

    $path = $file->getPathname();
    $content = file_get_contents($path);

    if ($content === false) {
        continue;
    }

    $original = $content;
    $count = 0;

    // HOME
    $content = preg_replace_callback(
        '/route\(\s*[\'"]frontend\.website[\'"]\s*,\s*\[\s*[\'"]slug[\'"]\s*=>\s*\$website->slug\s*\]\s*\)/s',
        function () use (&$count) {
            $count++;
            return 'frontend_home_url()';
        },
        $content
    );

    // CATEGORY
    $content = preg_replace_callback(
        '/route\(\s*[\'"]frontend\.category[\'"]\s*,\s*\[\s*[\'"]websiteSlug[\'"]\s*=>\s*\$website->slug\s*,\s*[\'"]categorySlug[\'"]\s*=>\s*(\$[A-Za-z_][A-Za-z0-9_]*)->slug\s*\]\s*\)/s',
        function ($matches) use (&$count) {
            $count++;
            return 'frontend_category_url(' . $matches[1] . '->slug)';
        },
        $content
    );

    // NEWS
    $content = preg_replace_callback(
        '/route\(\s*[\'"]frontend\.news[\'"]\s*,\s*\[\s*[\'"]websiteSlug[\'"]\s*=>\s*\$website->slug\s*,\s*[\'"]newsSlug[\'"]\s*=>\s*(\$[A-Za-z_][A-Za-z0-9_]*)->slug\s*\]\s*\)/s',
        function ($matches) use (&$count) {
            $count++;
            return 'frontend_news_url(' . $matches[1] . '->slug)';
        },
        $content
    );

    // SEARCH
    $content = preg_replace_callback(
        '/route\(\s*[\'"]frontend\.search[\'"]\s*,\s*\[\s*[\'"]slug[\'"]\s*=>\s*\$website->slug\s*\]\s*\)/s',
        function () use (&$count) {
            $count++;
            return 'frontend_search_url()';
        },
        $content
    );

    // LANGUAGE
    $content = preg_replace_callback(
        '/route\(\s*[\'"]language\.switch[\'"]\s*,\s*\[\s*[\'"]websiteSlug[\'"]\s*=>\s*\$website->slug\s*,\s*[\'"]locale[\'"]\s*=>\s*(\$[A-Za-z_][A-Za-z0-9_]*)\s*\]\s*\)/s',
        function ($matches) use (&$count) {
            $count++;
            return 'frontend_language_url(' . $matches[1] . ')';
        },
        $content
    );

    if ($content !== $original) {

        file_put_contents($path, $content);

        $updatedFiles++;
        $totalReplacements += $count;

        echo "UPDATED: "
            . str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $path)
            . " ({$count} links)"
            . PHP_EOL;
    }
}

echo PHP_EOL;
echo "========================================" . PHP_EOL;
echo " Theme Domain Link Update Completed" . PHP_EOL;
echo "========================================" . PHP_EOL;
echo "Files updated: {$updatedFiles}" . PHP_EOL;
echo "Total links updated: {$totalReplacements}" . PHP_EOL;
echo PHP_EOL;

