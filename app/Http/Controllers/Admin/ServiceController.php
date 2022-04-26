<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|min:2|max:125',
            'description' => 'required|string|min:2|max:1000',
            'cost' => 'required|integer',
            'image' => 'required|image|max:10240',
            'type_id' => 'required|integer|exists:types,id'
        ]);

        $filename = $request->file('image')->hashName();
        $path = $request->file('image')->move('img/service', $filename);

        $validatedData['image'] = $path->getPathname();
        $service = Service::create($validatedData)->load('type');
        return response()->json(['data' => ['service' => $service], 'message' => 'Создано!'], 201);
    }

    public function update(Request $request, $id)
    {
        $service = $this->checkRecord($id, Service::class, 'Услуга', 'а');
        $validatedData = $this->validate($request, [
            'name' => 'nullable|string|min:2|max:125',
            'description' => 'nullable|string|min:2|max:1000',
            'cost' => 'nullable|integer',
            'image' => 'nullable|image|max:10240',
            'type_id' => 'nullable|integer|exists:types,id'
        ]);

        $this->updateImage($request, $service, 'service', $validatedData);

        $service->load('type')->update($validatedData);
        return response()->json(['data' => ['service' => $service], 'message' => 'Обновлено!']);
    }

    public function delete($id)
    {
        $service = $this->checkRecord($id, Service::class, 'Услуга');
        $service->delete();
        return response()->json(['message' => "Услуга $service->name удалена!"]);
    }
}
