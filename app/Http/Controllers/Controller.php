<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Settings;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function resSuccess($data,$success)
    {
        $array = [
            'result'    => $data,
        ];

        if($success)
        {
            $array = [
                'result'    => $data,
                'message'   => $success
            ];

            $array = array_merge($array,['message' => $success]);
        }

        return response()->json($array,200);            
    }

    public function resError($msg,$status)
    {
        return response()->json(['errors' => ['error' => [$msg]],'message' => 'Error'],$status);    
    }
}
