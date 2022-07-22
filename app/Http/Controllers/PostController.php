<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        DB::beginTransaction();
        $saved = true;

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $saved = $saved && $post->save();

        if($saved) {
            $tags = explode(',', $request->tags);
            foreach($tags as $key => $varTag) {
                $tag = new Tag;
                $tag->post_id = $post->id;
                $tag->content = $varTag;
                $saved = $saved && $tag->save();
                if(!$saved) {
                    $saved = false;
                }
            }
        }

        if($saved) {
            DB::commit();
            return redirect()->route('post.article')->with("success", "Postingan Telah Ditambahkan");
        }else{
            DB::rollBack();
            return redirect()->route('post.article')->with("error", "Gagal Menambah Postingan");

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
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
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.article')->with("success", "Postingan Berhasil dihapus");
    }

    public function article() {
        $posts = Post::orderBy('created_at', 'DESC')->get();

        return view('post.article', compact('posts'));
    }

    public function comment($id) {
        $post = Post::find($id);

        return view('post.comment', compact('post'));
    }

    public function postComment(Request $request) {
        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->content = $request->content;
        $comment->user_id = Auth::user()->id;
        $comment->save();
        return redirect()->route('post.article')->with("success", "Komentar Berhasil ditambahkan");
    }
}
