<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


if (!function_exists('lang')) {
    /**
     * Translate the given message.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return string|array|null
     */
    function lang($key, $replace = [], $locale = null)
    {
        return app('translator')->get("common.$key", $replace, 'zh_TW');
    }
}

if (!function_exists('setSessionMessageFromStatusCode')) {
    /**
     * Set a status message in the session.
     *
     * @param string $type The type of status message (e.g., 'success', 'error').
     * @param string $key The key of the status message.
     * @param string $method The method of the session method includ put flash forget flush.
     * @return void
     * @throws InvalidArgumentException If an invalid method is provided.
     */
    function setSessionMessageFromStatusCode($type, $key, $method = 'flash')
    {
        // Validate method
        $validMethods = ['put', 'flash', 'forget', 'flush'];
        if (!in_array($method, $validMethods)) {
            throw new InvalidArgumentException("Invalid method: $method. Valid methods are: " . implode(', ', $validMethods));
        }

        // Validate type and key
        if (empty($type) || !is_string($type)) {
            Log::error("Invalid type provided. Type must be a non-empty string.");
            throw new InvalidArgumentException("Invalid type provided. Type must be a non-empty string.");
        }
        if (empty($key) || !is_string($key)) {
            Log::error("Invalid key provided. Key must be a non-empty string.");
            throw new InvalidArgumentException("Invalid key provided. Key must be a non-empty string.");
        }

        // Get the message from the configuration
        $message = config("status_code.$type.$key");
        if (!$message) {
            Log::error("Undefined status code: $type.$key");
            return;
        }

        // Execute the appropriate session method
        switch ($method) {
            case 'put':
                Session::put($type, $message);
                break;
            case 'flash':
                Session::flash($type, $message);
                break;
            case 'forget':
                Session::forget($type);
                break;
            case 'flush':
                Session::flush();
                break;
        }
    }
}

if (!function_exists('formatSizeUnits')) {
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

