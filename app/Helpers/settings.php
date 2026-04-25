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



if (!function_exists('blogImage')) {
    /**
     * Get the full URL for a blog image (cover or content image)
     * 
     * @param string|null $imagePath The image path from the blog
     * @param string $type Type of image (cover, content, og)
     * @return string
     */
    function blogImage($imagePath, $type = 'cover')
    {
        // Default image based on type
        $defaults = [
            'cover' => asset('blog-img1.jpg'),
            'content' => asset('blog-img1.jpg'),
            'og' => asset('blog-img1.jpg'),
        ];
        
        $defaultImage = $defaults[$type] ?? $defaults['cover'];
        
        // If no image path, return default
        if (empty($imagePath)) {
            return $defaultImage;
        }
        
        // If it's already an absolute URL, return as is
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }
        
        // Get the main app URL from config (same as companyLogo uses)
        $mainAppUrl = config('api.main_app.url', env('MAIN_APP_URL', 'http://127.0.0.1:8000'));
        $mainAppUrl = rtrim($mainAppUrl, '/');
        
        // Clean the image path
        $imagePath = ltrim($imagePath, '/');
        
        // Build the full URL (same logic as companyLogo)
        if (str_starts_with($imagePath, 'storage/')) {
            $fullUrl = $mainAppUrl . '/' . $imagePath;
        } elseif (str_starts_with($imagePath, 'blog/')) {
            $fullUrl = $mainAppUrl . '/storage/' . $imagePath;
        } else {
            $fullUrl = $mainAppUrl . '/storage/' . $imagePath;
        }
        
        // \Log::info($fullUrl);
        return $fullUrl;
    }
}

if (!function_exists('processBlogContent')) {
    function processBlogContent($content)
    {
        if (empty($content)) {
            return '';
        }
        
        // Get the backend URL (where images are actually stored)
        $backendUrl = rtrim(config('api.main_app.url', env('MAIN_APP_URL', 'http://127.0.0.1:8000')), '/');
        
        // Convert /storage/... to full URL
        $content = preg_replace_callback(
            '/(src=["\'])(\/storage\/[^"\']+)(["\'])/i',
            function($matches) use ($backendUrl) {
                return $matches[1] . $backendUrl . $matches[2] . $matches[3];
            },
            $content
        );
        
        return $content;
    }
}


if (!function_exists('blogAuthorAvatar')) {
    /**
     * Get the full URL for a blog author avatar
     * 
     * @param int|string|array|object|null $author The author data
     * @param string|null $avatarPath The avatar path if author is not passed as array
     * @return string
     */
    function blogAuthorAvatar($author, $avatarPath = null)
    {
        // Handle different input types
        $avatar = null;
        
        if (is_array($author) && isset($author['avatar'])) {
            $avatar = $author['avatar'];
        } elseif (is_object($author) && isset($author->avatar)) {
            $avatar = $author->avatar;
        } elseif (is_string($avatarPath)) {
            $avatar = $avatarPath;
        }
        
        // Default avatar
        $defaultAvatar = asset('blog-bg.jpg');
        
        // If no avatar, return default
        if (!$avatar) {
            return $defaultAvatar;
        }
        
        // If it's already an absolute URL, return as is
        if (filter_var($avatar, FILTER_VALIDATE_URL)) {
            return $avatar;
        }
        
        // Get the main app URL from config
        $mainAppUrl = config('api.main_app.url', env('MAIN_APP_URL', 'http://127.0.0.1:8000'));
        $mainAppUrl = rtrim($mainAppUrl, '/');
        
        // Clean the avatar path
        $avatar = ltrim($avatar, '/');
        
        // Build the full URL
        if (str_starts_with($avatar, 'storage/')) {
            $fullUrl = $mainAppUrl . '/' . $avatar;
        } elseif (str_starts_with($avatar, 'avatars/') || str_starts_with($avatar, 'profiles/')) {
            $fullUrl = $mainAppUrl . '/storage/' . $avatar;
        } else {
            $fullUrl = $mainAppUrl . '/storage/' . $avatar;
        }
        
        return $fullUrl;
    }
}

if (!function_exists('defaultBlogImage')) {
    function defaultBlogImage()
    {
        return asset('blog-bg.jpg');
    }
}

if (!function_exists('defaultAvatar')) {
    function defaultAvatar()
    {
        return asset('user-2.jpg');
    }
}
