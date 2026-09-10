<?php

use App\Models\Domain;

if (! function_exists('frontend_domain_url')) {

    function frontend_domain_url(string $path = '/'): string
    {
        $path = '/' . ltrim($path, '/');

        /*
        |--------------------------------------------------------------------------
        | Current Website Domain
        |--------------------------------------------------------------------------
        */

        if (app()->bound('currentWebsite')) {

            $website = app('currentWebsite');

            /*
            |--------------------------------------------------------------------------
            | Current request is already using a connected domain
            |--------------------------------------------------------------------------
            */

            $currentHost = strtolower(request()->getHost());

            $currentDomain = Domain::where('website_id', $website->id)
                ->where('domain', $currentHost)
                ->whereIn('status', ['verified', 'active'])
                ->first();

            if ($currentDomain) {

                $port = request()->getPort();

                /*
                | Keep :8000 for local .test domains
                */

                if (str_ends_with($currentDomain->domain, '.test')) {
                    return request()->getScheme()
                        . '://'
                        . $currentDomain->domain
                        . ':'
                        . $port
                        . $path;
                }

                /*
                | Production custom domain
                */

                return request()->getScheme()
                    . '://'
                    . $currentDomain->domain
                    . $path;
            }

            /*
            |--------------------------------------------------------------------------
            | Primary connected domain
            |--------------------------------------------------------------------------
            */

            $domain = Domain::where('website_id', $website->id)
                ->where('is_primary', true)
                ->whereIn('status', ['verified', 'active'])
                ->first();

            if ($domain) {

                if (str_ends_with($domain->domain, '.test')) {

                    return request()->getScheme()
                        . '://'
                        . $domain->domain
                        . ':8000'
                        . $path;
                }

                return request()->getScheme()
                    . '://'
                    . $domain->domain
                    . $path;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        return url($path);
    }
}


if (! function_exists('frontend_home_url')) {

    function frontend_home_url(): string
    {
        return frontend_domain_url('/');
    }
}


if (! function_exists('frontend_category_url')) {

    function frontend_category_url(string $categorySlug): string
    {
        return frontend_domain_url(
            '/category/' . $categorySlug
        );
    }
}
if (! function_exists('frontend_news_url')) {

    function frontend_news_url(
        string $newsSlug,
        $website = null
    ): string {

        /*
        |----------------------------------------------------------------------
        | Custom domain
        |----------------------------------------------------------------------
        */

        if (app()->bound('currentWebsite')) {

            $currentWebsite = app('currentWebsite');

            return frontend_domain_url(
                '/news/' . $newsSlug
            );
        }


        /*
        |----------------------------------------------------------------------
        | Normal /site/{slug} URL
        |----------------------------------------------------------------------
        */

        if ($website) {

            return url(
                '/site/' . $website->slug . '/news/' . $newsSlug
            );
        }


        /*
        |----------------------------------------------------------------------
        | Fallback
        |----------------------------------------------------------------------
        */

        return url('/news/' . $newsSlug);
    }
}

if (! function_exists('frontend_search_url')) {

    function frontend_search_url(?string $query = null): string
    {
        $url = frontend_domain_url('/search');

        if ($query !== null && $query !== '') {
            $url .= '?q=' . urlencode($query);
        }

        return $url;
    }
}


if (! function_exists('frontend_language_url')) {

    function frontend_language_url(string $locale): string
    {
        return frontend_domain_url(
            '/language/' . $locale
        );
    }
}

