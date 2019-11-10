<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin-api');
    }
    
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            if($key !== 'page') {
                $page = Page::select('*')->where('key', '=', $key)->first();
                if($page) {
                    $page->key = $key;
                    $page->value = $value;
                } else {
                    $page = new Page;
                    $page->page = $request->page;
                    $page->key = $key;
                    $page->value = $value;
                }

                $page->save();
            }
        }
        return ['message' => 'Updated the page info'];
    }    
}
