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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->slug === 'socket.io') {
            return;
        }
        $dynamic_pages = DynamicPage::select('*')
        ->where([
            ['slug', '=', $request->slug],
            ['parent_slug', '=', $request->parentSlug]
        ])
        ->first();
        return new DynamicPageResource($dynamic_pages);
    }
}
