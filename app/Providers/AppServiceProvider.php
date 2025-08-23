<?php

namespace App\Providers;

use App\Enums\HttpEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

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
        Response::macro(
            'success',
            function (
                array|bool|Model|Collection|JsonResource|JsonResponse|null $data,
                ?string $message = null,
                HttpEnum $status = HttpEnum::Success
            ): JsonResponse {
                return Response::json([
                    'status' => 'OK',
                    'message' => $message,
                    'data' => $data,
                ], $status->value);
            }
        );

        Response::macro(
            'error',
            function (
                ?string $message = null,
                ?array $data = null,
                HttpEnum $status = HttpEnum::BadRequest
            ): JsonResponse {
                return Response::json([
                    'status' => 'error',
                    'message' => $message,
                    'data' => $data,
                ], $status->value);
            }
        );
    }
}
