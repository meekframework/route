<?php declare(strict_types=1);

namespace Meek\Route;

use RuntimeException;
use InvalidArgumentException;

/**
 * Exception class for HTTP client errors.
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license.
 */
class HttpClientError extends RuntimeException
{
    /**
     * @var integer The status code.
     */
    private $statusCode;

    /**
     * @var string The reason phrase.
     */
    private $reasonPhrase;

    /**
     * @var string[] The headers.
     */
    private $headers;

    /**
     * Creates a new HTTP client exception.
     *
     * @param integer $statusCode A client error status code.
     * @param string[] $headers Headers to be sent along with the response.
     * @throws InvalidArgumentException If a client error status code was not provided.
     */
    public function __construct(int $statusCode, array $headers = [])
    {
        if ($statusCode < 400 || $statusCode > 499) {
            throw new InvalidArgumentException('A client error status code ("4xx") was not provided');
        }

        $this->statusCode = $statusCode;
        $this->reasonPhrase = $this->getReasonPhraseFromStatusCode($statusCode);
        $this->headers = $headers;

        parent::__construct($this->reasonPhrase, $this->statusCode);
    }

    /**
     * Retrieve the status code.
     *
     * @return integer The status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Retrieve the reason phrase.
     *
     * @return string The reason phrase.
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * Retrieve the headers that should be sent along with the HTTP exception response.
     *
     * @return string[] All headers in a PSR7 compatible format.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Retrieve the reason phrase normally associated with the status code.
     *
     * @param integer $statusCode The HTTP client error status code.
     * @return string The normal reason phrase for the status code.
     */
    private function getReasonPhraseFromStatusCode(int $statusCode): string
    {
        $reasonPhrases = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            421 => 'Misdirected Request',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            451 => 'Unavailable For Legal Reasons'
        ];

        return $reasonPhrases[$statusCode];
    }
}
