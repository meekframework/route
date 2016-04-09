<?php

namespace Meek\Routing\Exceptions;

use Meek\Routing\HttpException;

class MethodNotAllowed extends HttpException
{
    public function __construct()
    {
        parent::__construct('Method Not Allowed', 405);
    }
}
