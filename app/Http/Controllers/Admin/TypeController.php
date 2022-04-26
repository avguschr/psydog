<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|min:2|max:125'
        ]);
        $type = Type::create($validatedData);
        return response()->json(['data' => ['type' => $type], 'message' => 'Создано!'], 201);
    }

    public function update(Request $request, $id)
    {
        $type = $this->checkRecord($id, Type::class, 'Тип');
        $validatedData = $this->validate($request, [
            'name' => 'nullable|string|min:2|max:125'
        ]);
        $type->update($validatedData);
        return response()->json(['data' => ['type' => $type], 'message' => 'Обновлено!']);
    }

    public function delete($id)
    {
        $type = $this->checkRecord($id, Type::class, 'Тип');
        $type->delete();
        return response()->json(['message' => "Тип услуги $type->name удален!"]);
    }
}
