<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;


class CommentController extends Controller
{
    public function create(CommentRequest $request)
    {
        $depth = 1;

        // check if parent_id is depth=3 already
        if ($request->parent_id) {
            $parent = Comment::find($request->parent_id);
            if ($parent->depth > 3) {
                return response()->json([
                    'message' => 'Comment depth is too deep.',
                ], 422);
            }

            $depth = $parent->depth + 1;
        }

        // validate and store comment
        $comment = Comment::create([...$request->validated(), 'depth' => $depth]);


        return response()->json(['message' => 'Comment created successfully', 'data' => $comment], 201);
    }

    public function index()
    {
        // Fetch all comments. Since there is no post to associate these comments with, we do not eager load anything. 
        // The nesting mechanism will be handled by the frontend.

        return CommentResource::collection(Comment::all());
    }
}
