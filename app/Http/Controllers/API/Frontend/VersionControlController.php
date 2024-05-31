<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VersionControlController extends Controller
{
    public function index()
    {
        $msg = [
            'version' => '1.0.0',
            'is_force' => 0,
            'benefit' => [
                'update-version-control'
            ],
            'created_at' => date('Y-m-d H:i:s')
        ];
        return response()->json([
            'status' => 'success',
            'msg' => $msg
        ]);
    }
}
