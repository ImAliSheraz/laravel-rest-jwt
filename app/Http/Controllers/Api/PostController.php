<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $value = $request['value'] ? $request['value'] : 0;
        if ($request['method'] == 'GET') {
            $posts = Post::all();
            return response(['message' => 'Post fetched Successfully'], 200);
        }

        if ($request['method'] == 'POST') {
            $posts = Post::factory()->count($value)->create();
            return response(['message' => 'Post created Successfully'], 200);
        }
        if ($request['method'] == 'DELETE') {
            DB::table('posts')->whereIn('id', DB::table('posts')->orderBy(DB::raw("RAND()"))->take($value)->pluck('id'))->delete();
            return response(['message' => 'Post Deleted'], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $posts = Post::create($request->all());
        // $posts = Post::factory()->count(5000)->create();
        return new PostResource($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        DB::table('posts')->whereIn('id', DB::table('posts')->orderBy(DB::raw("RAND()"))->take(10000)->pluck('id'))->delete();
        return response(null, 204);
    }
}
