<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Validation\Concerns\ValidatesAttributes;

abstract class Controller
{
    use ValidatesAttributes, Authorizable;
}
