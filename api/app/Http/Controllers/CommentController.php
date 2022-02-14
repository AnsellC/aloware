<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
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
}
