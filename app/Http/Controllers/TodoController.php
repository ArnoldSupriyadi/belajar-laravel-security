<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $this->authorize("create", Todo::class);

        return response()->json([
            "message" => "success"
        ]);
    }

    public function testView()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $user = User::where("email", "eko@localhost")->firstOrFail();
        Auth::login($user);

        $todos = Todo::query()->get();

        $this->view("todos", ["todos" => $todos])
            ->assertSeeText("Edit")
            ->assertSeeText("Delete")
            ->assertDontSeeText("No Edit")
            ->assertDontSeeText("No Delete");
    }
}