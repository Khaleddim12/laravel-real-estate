<?php

/**
 *
 * @return string public url
 */
if (!function_exists("uploadsUrl")) {
    function uploadsUrl()
    {
        return env('APP_URL').'/uploads';
    }
}

?>
