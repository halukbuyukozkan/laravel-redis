<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Redis'te 'users' anahtarına sahip bir önbellek varsa, onu döndür
        $cachedUsers = Redis::get('users');

        if ($cachedUsers && $cachedUsers != '[]') {
            return response()->json(['users' => json_decode($cachedUsers)]);
        }

        // Eğer Redis'te önbellek yoksa, verileri veritabanından al
        $users = User::all();

        // Redis önbelleğe al
        Redis::setex('users', 10,$users->toJson());

        return response()->json(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users = User::factory(1000)->create();
        return $users;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
