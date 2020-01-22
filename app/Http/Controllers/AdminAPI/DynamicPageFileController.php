<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\DynamicPage;
Use App\DynamicPageFile;
use App\Http\Resources\AdminAPI\DynamicPageFile as DynamicPageFileResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminAPI\SiteMapDynamicPageController;

class DynamicPageFileController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dynamicPageFile = DynamicPageFile::select('*')
        ->where([
            ['page_id', '=', $request->pageId],
            ['key', '=', $request->key],
        ])
        ->first();
        // If  page file update
        if($dynamicPageFile) {
            return $this->update($request);
        }

        $dynamicPageFile = new DynamicPageFile;
        $dynamicPageFile->page_id = $request->pageId;
        
        $dynamicPageFile->url = Storage::disk('s3')->putFile('dynamic-pages-files/'.$request->key.'/'. date('Y').'/'.date('m'), $request->file, 'public');
        //fix no slash bug
        $dynamicPageFile->url = '/' . $dynamicPageFile->url;
        $dynamicPageFile->key = $request->key;

        $dynamicPageFile->save();

        return new DynamicPageFileResource($dynamicPageFile);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function show($page_id, $key)
    {
        $dynamicPageFile = DynamicPageFile::select('*')
        ->where([
            ['page_id', '=',$page_id ],
            ['key', '=', $key],
        ])
        ->first();
        if($dynamicPageFile) {
            return new DynamicPageFileResource($dynamicPageFile);
        }
        return response()->json([
            'data' => ['url' => '' ]           
            ], 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function getFile(Request $request)
    {
        $dynamicPageFile = DynamicPageFile::select('*')
        ->where([
            ['page_id', '=', $request->pageId],
            ['key', '=', $request->key],
        ])
        ->first();
        if($dynamicPageFile) {
            return new DynamicPageFileResource($dynamicPageFile);
        }
        return response()->json([
            'data' => ['url' => '' ]           
            ], 200);
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
        
        $dynamicPageFile = DynamicPageFile::select('*')
        ->where([
            ['page_id', '=', $request->pageId],
            ['key', '=', $request->key],
        ])
        ->first();
        
        $dynamicPageFile->url = Storage::disk('s3')->putFile('dynamic-pages-files/'.$request->key.'/'. date('Y').'/'.date('m'), $request->file, 'public');
        //fix no slash bug
        $dynamicPageFile->url = '/' . $dynamicPageFile->url;    
        $dynamicPageFile->save();

        return new DynamicPageFileResource($dynamicPageFile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
