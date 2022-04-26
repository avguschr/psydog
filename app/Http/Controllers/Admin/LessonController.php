<?php

namespace App\Http\Controllers\Admin;

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

    public function create(Request $request)
    {
        $validatedData = $this->validate($request, [
            'start' => 'required|date|date_format:Y-m-d H:i',
            'end' => 'required|date|date_format:Y-m-d H:i|after_or_equal:start',
            'max' => 'required|integer',
            'service_id' => 'required|integer|exists:services,id',
            'tutor_id' => 'required|integer|exists:users,id'
        ]);
        $lesson = Lesson::create($validatedData)->load('tutor');
        return response()->json(['data' => ['lesson' => $lesson], 'message' => 'Создано!'], 201);
    }

    public function update(Request $request, $id)
    {
        $lesson = $this->checkRecord($id, Lesson::class, 'Занятие', 'о');
        $validatedData = $this->validate($request, [
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start',
            'max' => 'nullable|integer',
            'service_id' => 'nullable|integer|exists:services,id',
            'tutor_id' => 'nullable|integer|exists:users,id'
        ]);

        $lesson->update($validatedData);
        return response()->json(['data' => ['lesson' => $lesson], 'message' => 'Обновлено!']);
    }

    public function delete($id)
    {
        $lesson = $this->checkRecord($id, Lesson::class, 'Занятие');
        $lesson->delete();
        return response()->json(['message' => "Занятие удалено!"]);
    }
}
