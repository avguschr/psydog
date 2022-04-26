<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function findAll(Request $request)
    {
        $per_page = $request->per_page ?: 10;
        $news = News::paginate($per_page);
        return response()->json(['data' => ['items' => $news->items(), 'current_page' => $news->currentPage(), 'per_page' => $per_page], 'message' => 'Получено!']);
    }

    public function findOne($id)
    {
        $news = $this->checkRecord($id, News::class, 'Новость');
        return response()->json(['data' => $news, 'message' => 'Получено!']);
    }
}

