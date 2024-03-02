<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof ValidationException)
            return response()->json([
                'message' => $e->validator->errors()->first() ?: __('error.incorrect_data'),
                'errors' => $e->validator->errors()
            ], 422);

        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'message' => __('error.incorrect_method'),
                'errors' => ['method' => [__('error.incorrect_method')]]
            ], 405);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => __('error.not_found'),
                'errors' => ['object' => [__('error.not_found')]]
            ], 404);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => __('error.incorrect_link'),
                'errors' => ['route' => [__('error.incorrect_link')]]
            ], 404);
        }

        return parent::render($request, $e);
    }
}
