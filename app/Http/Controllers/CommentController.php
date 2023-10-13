<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Comment;
class CommentController extends Controller
{
     // Create a new comment
    public function store(Request $request, $forumId)
    {
         $forum = Forum::find($forumId);
 
         if (!$forum) {
             return response()->json(['message' => 'Forum not found'], 404);
         }
 
         // Define validation rules for the request
         $validator = Validator::make($request->all(), [
             'content' => 'required|string',
         ]);
 
         // Check if validation fails
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 400);
         }
 
         $comment = new Comment(['content' => $request->input('content')]);
         $forum->comments()->save($comment);
 
         return response()->json(['message' => 'Comment created successfully']);
    }

      // Retrieve all comments for a forum
    public function index($forumId)
    {
        $forum = Forum::find($forumId);
        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        $comments = $forum->comments;

        return response()->json($comments);
    }

    //update comment for a forum
    public function update(Request $request, $forumId, $commentId)
    {
        $forum = Forum::find($forumId);
        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['message' => 'Comment updated successfully']);
    }

    //delete comment
    public function destroy($forumId, $commentId)
    {
        $forum = Forum::find($forumId);
        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

}
