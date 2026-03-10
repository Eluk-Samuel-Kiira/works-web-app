<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    /**
     * Get the main app URL from config
     */
    public static function getMainAppUrl()
    {
        return config('api.main_app.url');
    }
    
    /**
     * Get the web app URL from config
     */
    public static function getWebAppUrl()
    {
        return config('api.web_app.url');
    }
    
    /**
     * Get the main app API base URL
     */
    public static function getMainAppApi()
    {
        return config('api.main_app.api_base');
    }
    
    /**
     * Get the web app API base URL
     */
    public static function getWebAppApi()
    {
        return config('api.web_app.api_base');
    }
    
    /**
     * Make API call to main app
     */
    public static function callMainApp($endpoint, $method = 'GET', $data = [])
    {
        $url = self::getMainAppApi() . '/' . ltrim($endpoint, '/');
        
        return Http::withOptions([
            'verify' => false, // Remove this in production with proper SSL
        ])->$method($url, $data);
    }
    
    /**
     * Make API call to web app
     */
    public static function callWebApp($endpoint, $method = 'GET', $data = [])
    {
        $url = self::getWebAppApi() . '/' . ltrim($endpoint, '/');
        
        return Http::withOptions([
            'verify' => false, // Remove this in production with proper SSL
        ])->$method($url, $data);
    }
}