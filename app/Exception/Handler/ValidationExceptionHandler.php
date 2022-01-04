<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use QeeZer\HyperfApiResponder\ResponseEntityFactory;
use Throwable;

class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();
        /** @var ValidationException $throwable */
        $body = $throwable->validator->errors()->first();
        return $response
            ->withStatus($throwable->status)
            ->withBody(new SwooleStream(Json::encode(ResponseEntityFactory::responseEntity(
                $throwable->validator->errors(),
                null,
                $body,
                $throwable->status
            ))))->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
