<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DynamicPage;
use App\Http\Resources\DynamicPage as DynamicPageResource;

class DynamicPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dynamic_pages = DynamicPage::select('*')
        ->where([
            ['page', '=', $request->category],
            ['slug', '=', $request->slug]
        ])
        ->first();
        return new DynamicPageResource($dynamic_pages);
    }
}
