<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SiteSetting;
use App\Models\Admin\SEO;

class SEOController extends Controller
{
    public function siteSetting()
    {
        $site_setting = SiteSetting::select('site_title', 'site_tag', 'seo_keyword', 'seo_description')->firstOrFail();
        return response()->json([
            'status' => 'success',
            'site_setting' => $site_setting
        ], 200);
    }

    public function pageSEO($page)
    {
        $pageSEO = SEO::wherePageName($page)->select('page_name', 'seo_keyword', 'seo_description', 'feature_image')->firstOrFail();
        return response()->json([
            'status' => 'success',
            'seo_feature_image_path' => '/seo/feature_image/',
            'pageSEO' => $pageSEO
        ], 200);
    }
}
