<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CompanyDetailController extends Controller
{
    public function companyDetail($slug)
    {
        return view('frontend.company-detail');
    }
}
