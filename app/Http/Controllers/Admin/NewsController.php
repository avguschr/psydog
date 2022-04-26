<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name' => 'required|string|min:2|max:125',
            'body' => 'required|string|min:2|max:1000',
            'image' => 'nullable|image|max:10240'
        ]);

        $filename = $request->file('image')->hashName();
        $path = $request->file('image')->move('img/news', $filename);

        $validatedData['image'] = $path->getPathname();

        $news = News::create($validatedData);
        return response()->json(['data' => ['news' => $news], 'message' => 'Создано!'], 201);
    }

    public function update(Request $request, $id)
    {
        $news = $this->checkRecord($id, News::class, 'Новость');
        $validatedData = $this->validate($request, [
            'name' => 'nullable|string|min:2|max:125',
            'body' => 'nullable|string|min:2|max:1000',
            'image' => 'nullable|image|max:10240'
        ]);

        $this->updateImage($request, $news, 'news', $validatedData);

        $news->update($validatedData);
        return response()->json(['data' => ['news' => $news], 'message' => 'Обновлено!']);
    }

    public function delete($id)
    {
        $news = $this->checkRecord($id, News::class, 'Новость');
        $news->delete();
        return response()->json(['message' => "Новость $news->name удалена!"]);
    }
}
