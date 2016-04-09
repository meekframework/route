<?php declare(strict_types=1);

namespace Meek\Route;

use RuntimeException;

/**
 *
 *
 * @author Nathan Bishop <nbish11@hotmail.com> (https://nathanbishop.name)
 * @copyright 2016 Nathan Bishop
 * @license The MIT license
 */
class TargetNotMatched extends RuntimeException
{
    /**
     * @var string [description]
     */
    private $requestTarget;

    /**
     * [__construct description]
     *
     * @param string $requestTarget [description]
     */
    public function __construct(string $requestTarget)
    {
        $this->requestTarget = $requestTarget;

        parent::__construct(sprintf('The request target "%s" could not be matched', $requestTarget), 404);
    }

    /**
     * [getRequestTarget description]
     *
     * @return string [description]
     */
    public function getRequestTarget(): string
    {
        return $this->requestTarget;
    }
}
