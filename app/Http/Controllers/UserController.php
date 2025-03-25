<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, string $username): JsonResponse
    {
        $users = User::query()
            ->when(
                $username,
                function(Builder $builder) use ($username){
                    $builder->where('name', 'like', "%{$username}%");
                }
            )->get();
        return response()->json(['users' => $users]);
    }

    public function show(Request $request, string $username): JsonResponse
    {
        $user = User::where('name', $username)->get();
        return response()->json(['user' => $user]);
    }
}
