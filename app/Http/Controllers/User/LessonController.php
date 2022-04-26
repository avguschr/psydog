<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        //
    }

    public function findAll(Request $request)
    {
        $lessons = Lesson::where([['start', '>=', Carbon::now()], ['start', '<=', Carbon::now()->addDays(6)]])->get();
        return response()->json(['data' => ['lessons' => $lessons], 'message' => 'Получено!']);
    }
}
