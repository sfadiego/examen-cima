<?php

namespace App\Enums;

enum HttpEnum: int
{
    case BadRequest = 400;
    case NotFound = 404;
    case Success = 200;
    case Created = 201;
}
