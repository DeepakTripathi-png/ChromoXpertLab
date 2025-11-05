<?php

namespace App\Traits;

use App\Models\Master\Master_admin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait HelperTrait 
{
    /**
     * Get creator name (legacy, update to User model when fully migrated)
     */
    public static function getCreatedByName($masterAdminId)
    {
        return Master_admin::where('status', 'active')->where('id', $masterAdminId)->first()?->user_name ?? 'N/A';
    }

    /**
     * Format full datetime in IST
     */
    public static function getCreatedAtDateTime($date)
    {
        return Carbon::createFromTimestamp(strtotime($date))->setTimezone('Asia/Kolkata')->format('d-m-Y h:i A');
    }

    /**
     * Format date only in IST
     */
    public static function getCreatedAtDate($date)
    {
        return Carbon::createFromTimestamp(strtotime($date))->setTimezone('Asia/Kolkata')->format('d-m-Y');
    }

    /**
     * Get current date in IST
     */
    public static function getCurrentDate()
    {
        return Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d');
    }

    /**
     * Get timezone by IP (simple implementation using free service or fallback)
     * No package needed; uses http://ip-api.com (free, no key required)
     */
    public function getTimezoneByIp(string $ip): ?string
    {
        // Fallback for localhost
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'Asia/Kolkata';
        }

        try {
            // Free API call (no auth needed, rate-limited but fine for dev)
            $url = "http://ip-api.com/json/{$ip}?fields=timezone";
            $response = @file_get_contents($url);  // Suppress warnings

            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['timezone']) && $data['timezone']) {
                    return $data['timezone'];
                }
            }
        } catch (\Exception $e) {
            // Silent fail on errors (e.g., network issues)
        }

        // Default fallback
        return 'Asia/Kolkata';
    }

    // Add other helper methods if needed (e.g., for User model post-migration)
}