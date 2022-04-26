<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{

    public function checkRecord($id, $table, $name, $end = null): Model
    {
        if ($model = $table::whereId($id)->first()) {
            return $model;
        }
        throw new NotFoundHttpException("$name не найден" . $end);
    }

    public function updateImage(Request $request, $model, $dir, &$validatedData)
    {
        if ($request->hasFile('image')) {
            if ($model->image) File::delete($model->image);
            $filename = $request->file('image')->hashName();
            $path = $request->file('image')->move("img/$dir", $filename);
            $validatedData['image'] = $path->getPathname();
        }
    }
}
