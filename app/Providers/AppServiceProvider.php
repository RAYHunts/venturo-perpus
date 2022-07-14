<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = [], $message = '', $settings = []) {
            return Response::make([
                'status_code' => 200,
                'data' => $data,
                'message' => $message,
                'settings' => $settings
            ], 200);
        });

        Response::macro('failed', function ($error = [], $httpCode = 422, $settings = []) {
            if(is_array($error)) {
                $arrError = $error;
            } else {
                $arrError = [];
                $tmpError = (array) $error;
                foreach($tmpError as $val) {
                    foreach((array) $val as $v) {
                        if($v !== ':message') {
                            $arrError[] = $v;
                        }
                    } 
                }
            }

            return Response::make([
                'status_code' => $httpCode,
                'errors' => $arrError,
                'settings' => $settings
            ], $httpCode);
        });
    }
}
