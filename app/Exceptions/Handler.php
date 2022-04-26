<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\BoundMethod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $message = $exception->getMessage();
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['status' => 404, 'message' => $exception->getMessage() ?: 'Страница не найдена.', 'code' => $message], 404);
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['status' => 404, 'message' => 'Неправильный метод запроса.', 'code' => $message], 405);
        } else if ($exception instanceof TokenBlacklistedException) {
            return response()->json(['status' => 401, 'message' => 'Неавторизован.', 'code' => $message], 401);
        } //        return response()->json(['status' => 500, 'message' => 'Ошибка сервера.'], 500);
        else if ($exception->getMessage() != 'The given data was invalid.') {
            return response()->json(['status' => 500, 'message' => 'Ошибка сервера', 'code' => $message], 500);
        }
        return parent::render($request, $exception);
    }
}
