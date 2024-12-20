<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function include($relationships): bool
    {
        $param = request()->input('include');
        if (!isset($param)) {
            return false;
        }
        return in_array(strtolower($relationships), explode(',', strtolower($param)));
    }
}
