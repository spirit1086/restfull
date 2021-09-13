# Laravel RESTfull (auth Bearer)

#Installation

Install the package through (https://getcomposer.org/ "Composer")

Run the Composer require command from the Terminal:
```
composer require spirit1086/restfull
```

Open your config/app.php and add a new line to the providers array.
```
\Spirit1086\Restfull\Modules\ModulesServiceProvider::class
```

Open your app/Http/Kernel.php add this middleware
```
protected $middlewareGroups = [
 'api' => [
            ...
            \Spirit1086\Restfull\Middleware\JsonMiddleware
    ],
 ]       
 protected $routeMiddleware = [
         ...
        'token.expires'=>\Spirit1086\Restfull\Middleware\CheckTokenExpires::class
 ];
```

Open your app/Exceptions/Handler.php and put this code
```
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
```

Open your config/auth.php and put this code:
```

'providers' => [
        'api_users' => [
            'driver' => 'eloquent',
            'model' => \Spirit1086\Restfull\Modules\Auth\Models\User::class,
        ]
    ],
```

And change api provider:
```
'guards' => [
        'api' => [
            'driver' => 'token',
            'provider' => 'api_users',
            'hash' => false,
        ],
    ]
```

Now you're ready to start using the RESTfull with Bearer auth in your application.
