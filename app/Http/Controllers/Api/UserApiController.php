<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends Controller
{
    
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'isSuccess' => true,
                'message' => 'User ditemukan',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'isSuccess' => false,
                'message' => 'User tidak ditemukan',
                'data' => null,
            ], 404);
        }
    }
}
