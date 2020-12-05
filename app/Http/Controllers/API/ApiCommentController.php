<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class ApiCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->only('store', 'update', 'destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return Comment::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->score = $request->score;
        $comment->id_course = $request->id_course;
        $comment->id_user = auth()->user()->id;
        $comment->save();
        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::where('id_course', '=', $id)
        ->join('users', 'comments.id_user', '=', 'users.id')
        ->select('comments.*', 'users.email')
        ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::destroy($id);
    }
}
