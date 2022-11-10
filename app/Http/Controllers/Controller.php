<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function format($code, $info, $data)
    {
        $return =  (object) array(
            'code' => $code,
            'info' => $info,
            'data' => $data
        );
        if ($data == null) {
            unset($return->data);
        }
        return $return;
    }
}