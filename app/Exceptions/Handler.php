<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Endpoint is not found'], status: 404);
            }
        });
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => $e], status: 405);
            }
        });

        // $this->renderable(function (Throwable $e, $request) {
        //     if ($request->is('api/*')) {
        //         $debug = config('app.debug');
        //         $message = '';
        //         $status_code = 500;
        //         // cek jika eksepsinya dikarenakan model tidak ditemukan
        //         if ($e instanceof ModelNotFoundException) {
        //             // return response()->json(['message' => 'Resource is not found'], status: 404);
        //             $message = 'Resource is not found';
        //             $status_code = 404;
        //         }
        //         // cek jika eksepsinya dikarenakan method tidak diizinkan
        //         elseif ($e instanceof NotFoundHttpException) {
        //             // return response()->json(['message' => 'Endpoint is not found'], status: 404);
        //             $message = 'Endpoint is not found';
        //             $status_code = 404;
        //         }
        //         // cek jika eksepsinya dikarenakan resource tidak ditemukan
        //         elseif ($e instanceof MethodNotAllowedHttpException) {
        //             $message = 'Method is not allowed';
        //             $status_code = 405;
        //             // return response()->json(['message' => 'Method is not allowed'], status: 404);
        //         }
        //         // cek jika eksepsinya dikarenakan kegagalan validasi
        //         else if ($e instanceof ValidationException) {
        //             $validationErrors = $e->validator->errors()->getMessages();
        //             $validationErrors = array_map(function ($error) {
        //                 return array_map(function ($message) {
        //                     return $message;
        //                 }, $error);
        //             }, $validationErrors);
        //             // return response()->json(['message' => $validationErrors], status: 405);
        //             $message = $validationErrors;
        //             $status_code = 405;
        //             // return response()->json(['message' => $message], status: $status_code);
        //         }
        //         // cek jika eksepsinya dikarenakan kegagalan query
        //         else if ($e instanceof QueryException) {
        //             if ($debug) {
        //                 $message = $e->getMessage();
        //             } else {
        //                 $message = 'Query failed to execute';
        //             }
        //             $status_code = 500;
        //         }
        //         // $rendered = parent::renderable($request, $e);
        //         $rendered = parent::render($request, $e);
        //         $status_code = $rendered->getStatusCode();
        //         if (empty($message)) {
        //             $message = $e->getMessage();
        //         }
        //         $errors = [];
        //         if ($debug) {
        //             $errors['exception'] = get_class($e);
        //             $errors['trace'] = explode("\n", $e->getTraceAsString());
        //         }
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => $message,
        //             'data' => null,
        //             // 'errors' => $errors,
        //         ], $status_code);
        //         // return response()->json(['message' => 'Object Not found'], status: 404);
        //     }
        // });
    }
}
