<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash; // Import the Hash facade
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //function to create user
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'string', 'email', Rule::unique('users', 'email')],
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json(['message' => 'User created successfully']);
    }

    //function to update user
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Define validation rules
        $rules = [
            'name' => 'string',
            'email' => ['string', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'string|min:6',
        ];

        // Filter the request data to include only fields that have values
        $requestData = array_filter($request->only(['name', 'email', 'password']));

        // Validate the request data
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update user data
        if (array_key_exists('name', $requestData)) {
            $user->name = $requestData['name'];
        }
        if (array_key_exists('email', $requestData)) {
            $user->email = $requestData['email'];
        }
        if (array_key_exists('password', $requestData)) {
            $user->password = Hash::make($requestData['password']);
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    //function to delete user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
