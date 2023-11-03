<?php

namespace App\Exceptions;

use App\Jobs\LogServerExceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use Exception;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

/**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        // Log exception to console and database
        LogServerExceptions::dispatch($exception, $request);

        $message = $exception->getMessage();

        // Authorization exceptions
        if ($exception instanceof AuthenticationException)
            return exceptionResponse("NOT_AUTHORIZED", "not_authenticated", $message);

        // Authorization exceptions
        if(
            $exception instanceof AuthorizationException ||
            $exception instanceof AccessDeniedHttpException
        )  return exceptionResponse("FORBIDDEN", "not_authorized", $message);

        // Not Found
        if(
            $exception instanceof MethodNotAllowedHttpException ||
            $exception instanceof NotFoundHttpException
        )  return exceptionResponse("NOT_FOUND", "page_not_found", $message);

        // Validation exceptions
        if($exception instanceof ValidationException){
            $errors = $exception->errors();
            return exceptionResponse("BAD_REQUEST", "bad_request", $message, $errors);
        }

        // Bad Request Exception
        if($exception instanceof BadRequestHttpException){
            return badExceptionResponse("BAD_REQUEST","bad_request", $message);
        }

        // Unhandled exceptions
        if ($exception)
            return exceptionResponse("SERVER_ERROR", "server_error", $message);

        return parent::render($request, $exception);
    }
}
