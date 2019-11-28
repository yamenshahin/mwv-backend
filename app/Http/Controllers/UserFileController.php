<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use App\UserFile;
use App\Http\Resources\UserFile as UserFileResource;
use Illuminate\Support\Facades\Storage;

class UserFileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userFiles = UserFile::select('*')
        ->where('user_id', '=', auth()->user()->id)
        ->get();
        
        return UserFileResource::collection($userFiles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userFile = UserFile::select('*')
        ->where([
            ['user_id', '=', auth()->user()->id],
            ['key', '=', $request->key],
        ])
        ->first();
        // If  user file update
        if($userFile) {
            return $this->update($request, $request->key);
        }

        $userFile = new UserFile;
        $userFile->user()->associate(auth()->user()->id);
        
        $userFile->url = Storage::disk('s3')->putFile('user-files/'.$request->key.'/'. date('Y').'/'.date('m'), $request->file, 'public');
        //fix no slash bug
        $userFile->url = '/' . $userFile->url;
        $userFile->key = $request->key;

        $userFile->save();

        return new UserFileResource($userFile);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $userFile = UserFile::select('*')
        ->where([
            ['user_id', '=', auth()->user()->id],
            ['key', '=', $key],
        ])
        ->first();
        if($userFile) {
            return new UserFileResource($userFile);
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
        $userFile = UserFile::select('*')
        ->where([
            ['user_id', '=', auth()->user()->id],
            ['key', '=', $request->key],
        ])
        ->first();
        if($userFile) {
            return new UserFileResource($userFile);
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
    public function update(Request $request, $key)
    {
        
        $userFile = UserFile::select('*')
        ->where([
            ['user_id', '=', auth()->user()->id],
            ['key', '=', $key],
        ])
        ->first();
        
        $userFile->url = Storage::disk('s3')->putFile('user-files/'.$key.'/'. date('Y').'/'.date('m'), $request->file, 'public');
        //fix no slash bug
        $userFile->url = '/' . $userFile->url;    
        $userFile->save();

        return new UserFileResource($userFile);
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
