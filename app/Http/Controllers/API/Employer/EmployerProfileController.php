<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployerProfileController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'id' => $request->user()
        ]);
    }
}
