<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure;

use Throwable;

class ConnectorException extends \Exception
{
    /**
     * Overrides the default Exception constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param Throwable|null $previous The previous throwable used for exception chaining.
     */
    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Provides a string representation of the exception.
     *
     * @return string The formatted exception string.
     */
    public function __toString(): string
    {
        return sprintf(
            '[%d] %s in %s on line %d',
            $this->getCode(),
            $this->getMessage(),
            $this->getFile(),
            $this->getLine()
        );
    }
}