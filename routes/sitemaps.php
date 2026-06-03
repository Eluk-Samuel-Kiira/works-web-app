<?php


// Sitemaps for search engines
Route::get('/sitemap.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        Log::warning('Sitemap proxy failed: HTTP ' . $response->status());
        abort(404);

    } catch (\Exception $e) {
        Log::error('Sitemap proxy error: ' . $e->getMessage());
        abort(404);
    }
});

Route::get('/blog-sitemap.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/blog-sitemap.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        Log::warning('Sitemap proxy failed: HTTP ' . $response->status());
        abort(404);

    } catch (\Exception $e) {
        Log::error('Sitemap proxy error: ' . $e->getMessage());
        abort(404);
    }
});

// ⭐ Uganda sitemap (already running smoothly)
Route::get('/sitemap_ug.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap_ug.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        Log::warning('Uganda sitemap proxy failed: HTTP ' . $response->status());
        abort(404);

    } catch (\Exception $e) {
        Log::error('Uganda sitemap proxy error: ' . $e->getMessage());
        abort(404);
    }
});

// ⭐ Kenya sitemap
Route::get('/sitemap_ke.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap_ke.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        Log::warning('Kenya sitemap proxy failed: HTTP ' . $response->status());
        abort(404);

    } catch (\Exception $e) {
        Log::error('Kenya sitemap proxy error: ' . $e->getMessage());
        abort(404);
    }
});

// ⭐ Nigeria sitemap
Route::get('/sitemap_ng.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap_ng.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        Log::warning('Nigeria sitemap proxy failed: HTTP ' . $response->status());
        abort(404);

    } catch (\Exception $e) {
        Log::error('Nigeria sitemap proxy error: ' . $e->getMessage());
        abort(404);
    }
});

// ⭐ Optional: Add Tanzania and Rwanda if you expand later
Route::get('/sitemap_tz.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap_tz.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        abort(404);

    } catch (\Exception $e) {
        abort(404);
    }
});

Route::get('/sitemap_rw.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap_rw.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        abort(404);

    } catch (\Exception $e) {
        abort(404);
    }
});

// ⭐ Sitemap index that lists all available sitemaps
Route::get('/sitemap_index.xml', function () { 
    try {
        $response = Http::timeout(10)->get(config('api.main_app.url') . '/sitemap_index.xml');

        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }

        // Fallback: Generate sitemap index dynamically
        $webUrl = rtrim(config('api.web_app.url', env('WEB_APP_URL', 'https://stardenaworks.com')), '/');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= "  <sitemap>\n";
        $xml .= "    <loc>{$webUrl}/sitemap.xml</loc>\n";
        $xml .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $xml .= "  </sitemap>\n";
        $xml .= "  <sitemap>\n";
        $xml .= "    <loc>{$webUrl}/sitemap_ug.xml</loc>\n";
        $xml .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $xml .= "  </sitemap>\n";
        $xml .= "  <sitemap>\n";
        $xml .= "    <loc>{$webUrl}/sitemap_ke.xml</loc>\n";
        $xml .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $xml .= "  </sitemap>\n";
        $xml .= "  <sitemap>\n";
        $xml .= "    <loc>{$webUrl}/sitemap_ng.xml</loc>\n";
        $xml .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $xml .= "  </sitemap>\n";
        $xml .= "  <sitemap>\n";
        $xml .= "    <loc>{$webUrl}/blog-sitemap.xml</loc>\n";
        $xml .= "    <lastmod>" . now()->toAtomString() . "</lastmod>\n";
        $xml .= "  </sitemap>\n";
        $xml .= '</sitemapindex>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600');

    } catch (\Exception $e) {
        Log::error('Sitemap index proxy error: ' . $e->getMessage());
        abort(404);
    }
});