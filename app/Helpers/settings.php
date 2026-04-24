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
     * Get the full URL for a blog cover image
     * 
     * @param int|string|array|object|null $blog The blog data
     * @param string|null $imagePath The image path if blog is not passed as array
     * @return string
     */
    function blogImage($blog, $imagePath = null)
    {
        // Handle different input types
        $image = null;
        
        if (is_array($blog) && isset($blog['cover_image'])) {
            $image = $blog['cover_image'];
        } elseif (is_object($blog) && isset($blog->cover_image)) {
            $image = $blog->cover_image;
        } elseif (is_string($imagePath)) {
            $image = $imagePath;
        }
        
        // Default image path
        $defaultImage = asset('default-blog-image.jpg');
        
        // If no image, return default
        if (!$image) {
            return $defaultImage;
        }
        
        // If it's already an absolute URL, return as is
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }
        
        // Get the main app URL from config
        $mainAppUrl = config('api.main_app.url', env('MAIN_APP_URL', 'http://127.0.0.1:8000'));
        $mainAppUrl = rtrim($mainAppUrl, '/');
        
        // Clean the image path
        $image = ltrim($image, '/');
        
        // Build the full URL
        if (str_starts_with($image, 'storage/')) {
            $fullUrl = $mainAppUrl . '/' . $image;
        } elseif (str_starts_with($image, 'blogs/') || str_starts_with($image, 'blog-images/') || str_starts_with($image, 'cover/')) {
            $fullUrl = $mainAppUrl . '/storage/' . $image;
        } else {
            $fullUrl = $mainAppUrl . '/storage/' . $image;
        }
        
        return $fullUrl;
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
        $defaultAvatar = asset('default-avatar.png');
        
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
