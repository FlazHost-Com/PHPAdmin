<?php

declare(strict_types=1);

namespace PHPAdmin\Core\Exceptions;

/**
 * Base application exception.
 */
class AppException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/**
 * 404 Not Found exception.
 */
class NotFoundAppException extends AppException
{
    public function __construct(string $message = 'Not Found', ?\Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}

/**
 * 409 Conflict exception.
 */
class ConflictAppException extends AppException
{
    public function __construct(string $message = 'Conflict', ?\Throwable $previous = null)
    {
        parent::__construct($message, 409, $previous);
    }
}

/**
 * 422 Unprocessable Entity (validation) exception.
 */
class ValidationAppException extends AppException
{
    /**
     * @param array<string, string> $errors Field-level validation errors.
     */
    public function __construct(
        string $message = 'Validation failed',
        private readonly array $errors = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 422, $previous);
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}

/**
 * 401 Unauthorized exception.
 */
class UnauthorizedAppException extends AppException
{
    public function __construct(string $message = 'Unauthorized', ?\Throwable $previous = null)
    {
        parent::__construct($message, 401, $previous);
    }
}

/**
 * 403 Forbidden exception.
 */
class ForbiddenAppException extends AppException
{
    public function __construct(string $message = 'Forbidden', ?\Throwable $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}
