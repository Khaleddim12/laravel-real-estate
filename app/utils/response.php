<?php

/**
 * Returns ok response
 *
 * @return string Illuminate\Http\Response
 */
if (!function_exists("okResponse")) {
    function okResponse($object, string $status = "OK")
    {
        $HTTP_STATUS = getHttpStatusCodes("ok");
        $statusCode = 200;
        $responseData = [];

        if(array_key_exists($status, $HTTP_STATUS))
            $statusCode = $HTTP_STATUS[$status];

        if(array_key_exists("message", $object))
            $responseData["message"] = $object["message"];

        if(array_key_exists("data", $object))
            $responseData["data"] = $object["data"];

        if(array_key_exists("meta_data", $object))
            $responseData["meta_data"] = $object["meta_data"];

        if(array_key_exists("accessToken", $object))
            $responseData["accessToken"] = $object["accessToken"];

        return response($responseData, $statusCode);
    }
}

/**
 * Returns exception response
 *
 * @return string Illuminate\Http\Response
 */
if (!function_exists("exceptionResponse")) {
    function exceptionResponse(string $status = "SERVER_ERROR", string $keyword, string $actualMessage,array $errors = null)
    {
        $HTTP_STATUS = getHttpStatusCodes("bad");
        $statusCode = 500;
        $response = [];

        if(array_key_exists($status, $HTTP_STATUS))
            $statusCode = $HTTP_STATUS[$status];

        $message = getMessage($keyword);

        if($errors)
            $response["errors"] = $errors;

        $response["message"] = $message ? $message : "Internal Server Error";

        if(env('APP_DEBUG'))
            $response["actualMessage"] = $actualMessage;

        return response($response, $statusCode);
    }
}

/**
 * Returns bad exception response
 *
 * @return string Illuminate\Http\Response
 */
if (!function_exists("badExceptionResponse")) {
    function badExceptionResponse(string $status = "SERVER_ERROR", string $keyword, string $message, array $errors = null)
    {
        $HTTP_STATUS = getHttpStatusCodes("bad");
        $statusCode = 500;
        $response = [];

        if(array_key_exists($status, $HTTP_STATUS))
            $statusCode = $HTTP_STATUS[$status];

        if($errors)
            $response["errors"] = $errors;

        $response["message"] = $message;

        return response($response, $statusCode);
    }
}

/**
 * Returns exception response
 *
 * @return string Illuminate\Http\Response
 */
if (!function_exists("filterResponse")) {
    function filterResponse($data) {
        $response["data"] = $data->items();
        $response["current_page"] = $data->currentPage();
        $response["total"] = $data->total();
        $response["per_page"] = $data->perPage();
        $response["last_page"] = $data->lastPage();

        return $response;
    }
}

?>
