<?php

namespace Meek\Routing\Exceptions;

use Meek\Routing\HttpException;

class NotFound extends HttpException
{
    public function __construct()
    {
        parent::__construct('Not Found', 404);
    }
}
