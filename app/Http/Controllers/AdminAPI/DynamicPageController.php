<?php

namespace App\Http\Controllers\AdminAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DynamicPage;
use App\DynamicPageMeta;
use App\Http\Resources\AdminAPI\DynamicPage as DynamicPageResource;
use App\Http\Controllers\AdminAPI\DynamicPageFileController;

class DynamicPageController extends Controller
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
    public function index()
    {
        $dynamic_pages = DynamicPage::select('*')
        ->get();
        return DynamicPageResource::collection($dynamic_pages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id) {
            $existing_dynamic_page = DynamicPage::find($request->id);
        } else {
            $existing_dynamic_page = DynamicPage::select('*')
            ->where([
                ['parent_slug', '=', $request->parentSlug],
                ['slug', '=', $request->slug]
            ])
            ->first();
        }

        if($existing_dynamic_page) {
            $dynamic_page_metas = [];
            foreach($request->meta as $key => $value) {
                $existing_dynamic_page_meta = DynamicPageMeta::select('*')
                ->where([
                    ['dynamic_page_id', '=', $existing_dynamic_page->id],
                    ['key', '=', $key]
                ])
                ->first();
                if($existing_dynamic_page_meta) {
                    $existing_dynamic_page_meta->value = $value;
                    $existing_dynamic_page_meta->save(); 
                } else {
                    array_push($dynamic_page_metas, new DynamicPageMeta(['key' => $key, 'value' => $value])); 
                }
            }
            $existing_dynamic_page->slug = $request->slug;
            $existing_dynamic_page->parent_slug = $request->parentSlug;
            $existing_dynamic_page->save();
            $existing_dynamic_page->meta()->saveMany($dynamic_page_metas); 

            //save file
            if($request->file) {
                $file_request = new Request([
                    'pageId' => $existing_dynamic_page->id,
                    'file' => $request->file,
                    'key' => 'mainSliderBackground'
                ]);
                $file = new DynamicPageFileController();
                $file->store($file_request);
            }
        } else {
            $dynamic_page = new DynamicPage();
            $dynamic_page->slug = $request->slug;
            $dynamic_page->parent_slug = $request->parentSlug;

            $dynamic_page_metas = [];
            foreach($request->meta as $key => $value) {
                array_push($dynamic_page_metas, new DynamicPageMeta(['key' => $key, 'value' => $value]));
            }

            $dynamic_page->save();
            $dynamic_page->meta()->saveMany($dynamic_page_metas);
            //save file
            if($request->file) {
                $file_request = new Request([
                    'pageId' => $dynamic_page->id,
                    'file' => $request->file,
                    'key' => 'mainSliderBackground'
                ]);
                $file = new DynamicPageFileController();
                $file->store($file_request);
            }
        }

        //Update site map
        SiteMapDynamicPageController::generateSitemap();
    }
}
