<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:250'
        ]);

        if ($validator->fails()){
            return redirect()->route('post.article')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        $saved = true;

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $saved = $saved && $post->save();

        /**
         * Save Tags from post
         */
        if($saved) {
            $tags = explode('#', $request->tags);

            foreach($tags as $key => $varTag) {
                if($varTag == "") {
                    continue;
                }
                $varTag =  str_replace(',', '', $varTag);
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
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
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
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:250'
        ]);

        if ($validator->fails()){
            return redirect()->route('post.article')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        $saved = true;

        $post->content = $request->content;
        $saved = $saved && $post->save();


        if($saved) {
            DB::commit();
            return redirect()->route('post.article')->with("success", "Postingan Telah Diubah");
        }else{
            DB::rollBack();
            return redirect()->route('post.article')->with("error", "Gagal Mengubah Postingan");
        }
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

    /**
     * main meni of article
     * return array data of posts table by newest
     * GET Method
     */
    public function article() {
        $posts = Post::orderBy('created_at', 'DESC')->get();

        return view('post.article', compact('posts'));
    }

    /**
     * showing reply form for commenting a post by ID
     * sending data post by ID
     * GET Method
     */

    public function comment($id) {
        $post = Post::find($id);

        return view('post.comment', compact('post'));
    }


    /**
     * POST METHOD
     * save a comment by Post ID
     */
    public function postComment(Request $request) {
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:250'
        ]);

        if ($validator->fails()){
            return redirect()->route('post.article')->withErrors($validator)->withInput();
        }

        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->content = $request->content;
        $comment->user_id = Auth::user()->id;
        $comment->save();
        return redirect()->route('post.article')->with("success", "Komentar Berhasil ditambahkan");
    }
}
