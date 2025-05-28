<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Список исключений, которые не нужно логировать.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Добавьте сюда исключения, которые не нужно логировать
        // \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Список входных данных, которые не следует сохранять в логах или сессиях.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Отчёт о исключениях.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        // Здесь можно добавить дополнительное логирование или отправку ошибок
        // Например, логировать все исключения вручную:
        // \Log::error($exception);

        parent::report($exception);
    }

    /**
     * Обработка исключений и отображение ответов.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        // Можно добавить свою обработку ошибок для API или веба

        return parent::render($request, $exception);
    }
}