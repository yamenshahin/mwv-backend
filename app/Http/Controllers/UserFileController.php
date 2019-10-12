<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use App\UserFile;
use App\Http\Resources\UserFile as UserFileResource;

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
        $userFile = new UserFile;
        $userFile->user()->associate(auth()->user()->id);
        
        $path = $request->file->store(
            'public/user-files'. $request->key. '/' . date('Y').'/'.date('m')
        );
        $userFile->url = str_replace('public', '', $path);
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

        return new UserFileResource($userFile);
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
        $path = $request->file->store(
            'public/user-files'. $request->key. '/' . date('Y').'/'.date('m')
        );
        $userFile->url = str_replace('public', '', $path);

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
