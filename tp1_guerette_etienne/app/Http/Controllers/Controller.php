<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

define("PAGINATION", 20);

#[OA\Info(title: "API avec Albums", version: "1.0")]
abstract class Controller
{
    //
}
