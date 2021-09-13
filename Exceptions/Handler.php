<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->wantsJson())
        {
            $api_response = $this->apiResponse($exception,$request);
            return response()->json($api_response, $api_response['code']);
        }

        return parent::render($request, $exception);
    }


    private function apiResponse($exception,$request)
    {
        if ($exception instanceof \Illuminate\Http\Exception\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
            $statusCode = $statusCode == 302 ? 401 : $statusCode;
        } else {
            $statusCode = 401;

            if ($exception instanceof \OAuthException ) {
                $statusCode  =$exception->getCode();
            }
        }

        Log::info('handler code: '.$statusCode);
        switch ($statusCode) {
            case 401:
                $response = ['message'=>'Unauthorized','code'=>401];
                break;
            case 403:
                $response = ['message'=>'Forbidden','code'=>401];
                break;
            case 404:
                $response = ['message'=>'Not Found','code'=>404];
                break;
            case 405:
                $response = ['message'=>'Method Not Allowed','code'=>405];
                break;
            case 422:
                $response = ['message'=>$exception->original['message'],
                    'errors'=>$exception->original['errors'],
                    'code'=>422
                ];
                break;
            case 429:
                $response = ['message'=>'Too Many Requests','code'=>429,'sleep'=>60];
                break;
            default:
                if($statusCode == 500)
                {
                    $response = ['message'=>'Whoops, looks like something went wrong','code'=>500];
                }
                else
                {
                    $response = ['message'=>'Token invalid','code'=>$statusCode];
                }
                break;
        }

        return $response;
    }
}
