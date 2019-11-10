<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = Page::select('*')->where('page', '=', $request->page)
        ->get();
        
        $page_associative_array['page'] = $request->page;

        foreach ($results as $result) {
            $page_associative_array[$result->key] = $result->value;
        }

        return $page_associative_array;
    }
}
