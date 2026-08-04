<?php

use App\Http\Middleware\CheckSubscriptionMiddleware;
use App\Http\Middleware\DeviceLimitMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append:[
            AuthenticateSession::class
        ]);
        $middleware->alias([
            'subscribed' => CheckSubscriptionMiddleware::class,
            'device_limited' => DeviceLimitMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function(ModelNotFoundException $model, Request $request){
                $resource = $request->segment(1);

            if ($resource && Route::has("$resource.index"))  {
                return response()->redirectToRoute("$resource.index");
            }
            return response()->redirectToRoute('home.index');
        });

        $exceptions->report(function (QueryException $e) {
            try {
                $user = Auth::user();
                activity()
                    ->useLog('database_error') // Kategorikan log khusus
                    ->event('query_failed')
                    ->causedBy($user)
                    ->withProperties([
                        'sql' => $e->getSql(),
                        'bindings' => $e->getBindings(),
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ])
                    ->log('Database query error: ' . $e->getMessage());

            } catch (\Exception $spatieException) {
                // Fallback: Jika database down/Spatie gagal nge-log, paksa tulis ke file log local biasa
                Log::emergency('Spatie failed to log Database Exception! Fallback to file log.', [
                    'spatie_error' => $spatieException->getMessage(),
                    'original_sql_error' => $e->getMessage(),
                    'sql' => $e->getSql(),
                ]);
            }
        });

        $exceptions->render(function (QueryException $e) {
                return back()->with('error', 'Something went wrong on our end. Contact support if the issue persists.');
            });
    })->create();
