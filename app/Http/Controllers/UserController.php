<?php

namespace App\Http\Controllers;

use App\Files;
use App\Jobs\TreatmentFile;
use Faker\Provider\File;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function UploadFile()
    {
        return view('uploadFile');
    }

    public function Treatment(Request $request)
    {
        $field = $request->get('field');
        $count = $request->get('count');
        $fileName = $request->file('fileName')->hashName();
        $request->file('fileName')->store('/', 'public');
        if ($request->get('queue') == 0) {
            FileController::TreatmentWithOutQueue($fileName, $field, $count);
        } else {
            $file = Files::create([
                'fileName' => $fileName,
                'field' => $field,
                'count' => $count,
            ]);
            TreatmentFile::dispatch($file);
            return redirect(route('allFiles'));
        }
    }

    public function files()
    {
        $files = Files::all();
        return view('files', compact('files'));
    }

    public function top($id)
    {
        $file = Files::find($id);
        $array = json_decode($file->array);
        $countArray = count($array);
        $newFile = 'http://app.local/storage/' . $file->newFile;
        FileController::printFile($file->count, $countArray, $array, $newFile);
    }
}
