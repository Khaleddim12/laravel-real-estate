<?php

/**
 * Returns a message suitable for response, can be an error or success message.
 *
 * @param string $keyword Key word that represents sentance in the switch statment.
 *
 * @return String message
 */
if (!function_exists("getMessage")) {
    function getMessage($keyword, $options = [])
    {
        $model = $options["model"] ?? "";
        $value = $options["value"] ?? "";
        $extraValue = $options["extraValue"] ?? "";
        $column = $options["column"] ?? "";
        $user = $options["user"] ?? "";

        switch ($keyword) {
            case "bad_request":
                return "Bad Request, please check the inputs";
            case "created":
                return "the ".($model ?? "record")." is created";
            case "deleted":
                return "the ".($model ?? "record")." is deleted";
            case "edited":
                return "the ".($model ?? "record")." is edited";
            case "forbidden":
                return "Forbidden";
            case "invalid_creds":
                return "Invalid credentials";
            case "logged_out":
                return "User logged out";
            case "not_authenticated":
                return "You Are Not Authenticated";
            case "not_exist":
                return "{$column} with value = {$value} does not exist";
            case "not_authorized":
                return "You Are Not Authorized";
            case "not_unique":
                return "{$column} with value = {$value} Already exists";
            case "registered":
                return ($model ?? "User")." Is Registered";
            case "server_error":
                return "Internal Server Error";
            default:
                return false;

        }
    }
}

?>
