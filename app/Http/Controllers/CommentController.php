<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, recipe $recipe)
    {
        $rules = [
            'comment' => 'required|string|max:280',
        ];
        $messages = [
            'comment.required' => 'El comentario no puede estar vacio.',
            'comment.max' => 'El comentario no puede tener mas de 280 caracteres.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Comment::create([
            'comment' => $request->comment,
            'fk_user' => Auth::id(),
            'fk_recipe' => $recipe->id,
        ]);

        return redirect()->back()->with('success', 'Comentario agregado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        Session::flash('mensaje', 'Comentario eliminado.');
        return redirect()->back();
    }
}
