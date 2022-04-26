<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|min:2|max:125',
            'surname' => 'required|string|min:2max:125',
            'patronymic' => 'required|string|min:2max:125',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:125',
            'image' => 'nullable|image|max:10240',
            'role' => 'required|integer|in:1,2,3'
        ]);

        $filename = $request->file('image')->hashName();
        $path = $request->file('image')->move('img/user', $filename);

        $validatedData['image'] = $path->getPathname();

        $user = User::create($validatedData);
        return response()->json(['data' => ['user' => $user], 'message' => 'Created!'], 201);
    }

    public function update(Request $request, $id)
    {
        $user = $this->checkRecord($id, User::class, 'Пользователь');
        $validatedData = $this->validate($request, [
            'name' => 'nullable|string|min:2|max:125',
            'surname' => 'nullable|string|min:2max:125',
            'patronymic' => 'nullable|string|min:2max:125',
            'email' => "nullable|email|unique:users,email,$id,id",
            'image' => 'nullable|image|max:10240',
//            'password' => 'nullable|string|min:6|max:125',
            'role' => 'nullable|integer|in:1,2,3'
        ]);

        $this->updateImage($request, $user, 'user', $validatedData);

        $user->update($validatedData);
        return response()->json(['data' => ['user' => $user], 'message' => 'Updated!']);
    }

    public function findOne($id)
    {
        $user = $this->checkRecord($id, User::class, 'Пользователь');
        return response()->json(['data' => $user, 'message' => 'Received!']);
    }

    public function findAll(Request $request)
    {
        $per_page = $request->per_page ?: 10;
        $users = User::paginate($per_page);
        return response()->json(['data' => ['items' => $users->items(), 'current_page' => $users->currentPage(), 'per_page' => $per_page], 'message' => 'Received!']);
    }

    public function delete($id)
    {
        $user = $this->checkRecord($id, User::class, 'Пользователь');
        $user->delete();
        return response()->json(['message' => "Пользователь $user->name удален!"]);
    }
}
