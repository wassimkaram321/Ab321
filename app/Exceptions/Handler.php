<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{


    protected $dontReport = [
        //
    ];

   
    protected $dontFlash = [
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
        //
    }
    public function render($request, Throwable $e)
    {
        $code =  $e->getCode();
        $msg  =  $e->getMessage();

        if ($e instanceof UnauthorizedException) {
            $code =  403;
        } else if ($e instanceof ValidationException) {
            $msg = $e->validator->errors()->first();
            $code = 400;
        } else if ($e instanceof NotFoundHttpException) {
            $code = 404;
            $msg = 'Route not found';
        } else if ($e instanceof AuthenticationException) {
            $code = 403;
            $msg = 'UnAuthenticated';
        }
        else if($e instanceOf ModelNotFoundException){
            $code = 500;
            $msg = 'Model not found';
        }
        // else if($e instanceOf QueryException){
        //     $code = 500;
        //     $msg = 'Invalid Query';
        // }

        if (!$code ||  $code > 599 ||   $code <= 0 || gettype($code) !== "integer") {
            $code = 500;
        }

        return response()->json([
            'data' => [],
            'message' => $msg,
        ], $code);

    }
}
