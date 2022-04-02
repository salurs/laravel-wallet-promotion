<?php

namespace App\Exceptions;

use App\Helper\ResponseBuilder;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        $this->renderable(function (AuthenticationException $e) {
            return ResponseBuilder::error(message:$e->getMessage(), code:401);
        });
        //Not Found Error
        $this->renderable(function (NotFoundHttpException $e) {
            return ResponseBuilder::error(message:$e->getMessage(), code:404);
        });
        //Route Not Found Error
        $this->renderable(function (RouteNotFoundException $e) {
            return ResponseBuilder::error(message:$e->getMessage());
        });
        //MethodNotAllowedHttpException
        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return ResponseBuilder::error(message:$e->getMessage(), code:405);
        });
        //BadMethodCallException
        $this->renderable(function (\BadMethodCallException $e) {
            return ResponseBuilder::error(message:$e->getMessage());
        });
        //Database Error
        $this->renderable(function (QueryException $e) {
            return ResponseBuilder::error(message:$e->getMessage());
        });
        //Host Error
        $this->renderable(function (ConnectionException $e) {
            return ResponseBuilder::error(message:$e->getMessage());
        });
        //Runtime Error
        $this->renderable(function (\RuntimeException $e) {
            return ResponseBuilder::error(message:$e->getMessage());
        });
        //Errors
        $this->renderable(function (\Exception $e) {
            return ResponseBuilder::error(message:$e->getMessage());
        });
        //Errors
        $this->renderable(function (\Error $e) {
            return ResponseBuilder::error(message:$e->getMessage());
        });
    }
}
