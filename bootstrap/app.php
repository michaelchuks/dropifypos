<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\OnlyAcceptJsonMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "loggedAdmin" => \App\Http\Middleware\LoggedAdmin::class,
            "acceptJson" => \App\Http\Middleware\OnlyAcceptJsonMiddleware::class
        ]);
        
          $middleware->api(prepend: [
       OnlyAcceptJsonMiddleware::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function(Throwable $exception){
             if($exception instanceof ValidationException){
                $firstError = (object) $exception->errors();
                return response()->json([
                    'status' => 'error',
                     'message' => reset($firstError)[0],
                    ],401);
            }
        });
           
           
      
    })->create();
