<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    final public function validateDate($date, $format = "Y-m-d H:i:s"): bool
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    final public function createDate($date, $format = "Y-m-d H:i:s"): bool|string
    {
        return date($format, strtotime($date));
    }
}
