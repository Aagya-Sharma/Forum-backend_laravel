<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    //function to create forums
    public function create(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'author' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::find($request->user_id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $forum = new Forum();
        $forum->title = $request->title;
        $forum->description = $request->description;
        $forum->author = $request->author;
        $user->forums()->save($forum);

        return response()->json(['message' => 'Forum created successfully']);
    }

    //function to get forum detail
    public function show($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        return response()->json($forum);
    }

    //function to update forum
    public function update(Request $request, $id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        // Define validation rules for the request
        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'description' => 'string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update only the fields that are present in the request
        if ($request->has('title')) {
            $forum->title = $request->input('title');
        }
        if ($request->has('description')) {
            $forum->description = $request->input('description');
        }

        $forum->save();

        return response()->json(['message' => 'Forum updated successfully']);
    }

    //function to delete particular forum
    public function destroy($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        $forum->delete();

        return response()->json(['message' => 'Forum deleted successfully']);
    }

}
