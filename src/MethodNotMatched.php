<?php declare(strict_types=1);

namespace Meek\Route;

use RuntimeException;
use LogicException;

/**
 *
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license
 */
class MethodNotMatched extends RuntimeException
{
    /**
     * @var string [description]
     */
    private $requestMethod;

    /**
     * @var string[] [description]
     */
    private $allowedMethods;

    /**
     * [__construct description]
     *
     * @param string $requestMethod [description]
     * @param string[] $allowedMethods [description]
     */
    public function __construct(string $requestMethod, array $allowedMethods)
    {
        $this->requestMethod = strtoupper($requestMethod);
        $this->allowedMethods = array_map('strtoupper', $allowedMethods);

        if (in_array($this->requestMethod, $this->allowedMethods)) {
            throw new LogicException('The request method is the method that failed the match and should not be in the allowed methods');
        }

        parent::__construct(sprintf('The "%s" request method could not be matched', $this->requestMethod), 405);
    }

    /**
     * [getRequestMethod description]
     *
     * @return string [description]
     */
    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * [getAllowedMethods description]
     *
     * @return string[] [description]
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}
