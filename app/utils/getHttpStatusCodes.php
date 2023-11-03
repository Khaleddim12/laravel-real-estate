<?php


/**
 *
 *
 * @return
 */
if (!function_exists("getHttpStatusCodes")) {
    function getHttpStatusCodes($status)
    {
        switch($status){
            case "ok":
                return [
                    "OK" => 200,
                    "CREATED" => 201,
                    "ACCEPTED" => 202,
                    "NO_CONTENT" => 204
                ];
            case "bad":
                return [
                    "BAD_REQUEST" => 400,
                    "NOT_AUTHORIZED" => 401,
                    "FORBIDDEN" => 403,
                    "NOT_FOUND" => 404,
                    "SERVICE_UNAVAILABLE" => 503,
                    "SERVER_ERROR" => 500
                ];
            default: return;
        }
    }
}

?>
