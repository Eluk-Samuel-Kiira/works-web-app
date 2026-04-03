<?php




if (!function_exists('getWhiteLogo')) {
    function getWhiteLogo()
    {
        // Any dynmic logo from db
        
        // Final fallback: return default logo
        return asset('assets/images/logos/Works-light.png');
    }
}

if (!function_exists('getDarkLogo')) {
    function getDarkLogo()
    {
        // Any dynmic logo from db
        
        // Final fallback: return default logo
        return asset('assets/images/logos/Works-darks.png');
    }
}


if (!function_exists('getFavicon')) {
    function getFavicon()
    {
        
        // from db or 
        // fallback
        $faviconUrl = asset('assets/images/logos/favicon.png');
        return $faviconUrl;
    }
}


if (!function_exists('web_asset')) {
    function web_asset($path)
    {
        $baseUrl = config('api.web_app.url'); // http://127.0.0.1:8001
        return $baseUrl . '/' . ltrim($path, '/');
    }
}



if (!function_exists('companyLogo')) {
    /**
     * Get the full URL for a company logo
     * 
     * @param int|string|array|object|null $company The company data
     * @param string|null $logoPath The logo path if company is not passed as array
     * @return string
     */
    function companyLogo($company, $logoPath = null)
    {
        // Handle different input types
        $logo = null;
        
        if (is_array($company) && isset($company['logo'])) {
            $logo = $company['logo'];
        } elseif (is_object($company) && isset($company->logo)) {
            $logo = $company->logo;
        } elseif (is_string($logoPath)) {
            $logo = $logoPath;
        }
        
        // Default logo path
        $defaultLogo = asset('default-logo.png');
        
        // If no logo, return default
        if (!$logo) {
            return $defaultLogo;
        }
        
        // If it's already an absolute URL, return as is
        if (filter_var($logo, FILTER_VALIDATE_URL)) {
            return $logo;
        }
        
        // Get the main app URL from config
        $mainAppUrl = config('api.main_app.url', env('MAIN_APP_URL', 'http://127.0.0.1:8000'));
        $mainAppUrl = rtrim($mainAppUrl, '/');
        
        // Clean the logo path
        $logo = ltrim($logo, '/');
        
        // Build the full URL
        if (str_starts_with($logo, 'storage/')) {
            $fullUrl = $mainAppUrl . '/' . $logo;
        } elseif (str_starts_with($logo, 'logos/')) {
            $fullUrl = $mainAppUrl . '/storage/' . $logo;
        } else {
            $fullUrl = $mainAppUrl . '/storage/' . $logo;
        }
        
        // Check if the URL is accessible (optional - you can skip for performance)
        // Return the URL even if it might be broken, the onerror will handle it
        
        return $fullUrl;
    }
}

if (!function_exists('defaultLogo')) {
    function defaultLogo()
    {
        return asset('default-logo.png');
    }
}
