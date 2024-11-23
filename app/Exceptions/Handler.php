<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Kiểm tra yêu cầu từ giao diện web có phải là AJAX (gọi từ fetch, axios, v.v.)
        // Kiểm tra loại ngoại lệ là ValidationException
        if($request->wantsJson()){
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'errors' => $exception->errors(),
                ], 400); // Trả về mã lỗi 400
            }    
        }

        return parent::render($request, $exception);
    }
}
