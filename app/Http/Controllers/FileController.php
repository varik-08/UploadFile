<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static public function TreatmentWithOutQueue($fileName, $field, $count)
    {
        $file = fopen('storage/' . $fileName, "r");
        $i = 0;
        while (!feof($file)) {
            $content = fgetcsv($file, null, ";");
            $array[$i++] = $content;
        }

        unset($array[count($array) - 1]);
        $countArray = count($array);
        if (isset($field)) {
            for ($i = 0; $i < count($array[0]); $i++) {
                if ($field == $array[0][$i]) {
                    $index = $i;
                }
            }
            if (isset($index)) {

                for ($i = 1; $i < $countArray; $i++) {
                    for ($j = $i + 1; $j < $countArray; $j++) {
                        if ($array[$i][$index] > $array[$j][$index]) {
                            $temp = $array[$j];
                            $array[$j] = $array[$i];
                            $array[$i] = $temp;
                        }
                    }
                }
            }
        }

        $newFile = 'storage/' . uniqid() . '.csv';

        if (!file_exists($newFile)) {
            $fp = fopen($newFile, "w");
            for ($i = 0; $i < $countArray; $i++) {
                fputcsv($fp, $array[$i], ';', '"');
            }
            fclose($fp);
        }

        FileController::printFile($count, $countArray, $array, $newFile);
    }

    static public function TreatmentWithQueue($file)
    {
        $fileName = $file->fileName;
        $field = $file->field;
        $count = $file->count;

        $filePath = fopen(__DIR__ . "/../../../public/storage/" . $fileName, "r");
        $i = 0;
        while (!feof($filePath)) {
            $content = fgetcsv($filePath, null, ";");
            $array[$i++] = $content;
        }

        unset($array[count($array) - 1]);
        $countArray = count($array);
        if (isset($field)) {
            for ($i = 0; $i < count($array[0]); $i++) {
                if ($field == $array[0][$i]) {
                    $index = $i;
                }
            }
            if (isset($index)) {

                for ($i = 1; $i < $countArray; $i++) {
                    for ($j = $i + 1; $j < $countArray; $j++) {
                        if ($array[$i][$index] > $array[$j][$index]) {
                            $temp = $array[$j];
                            $array[$j] = $array[$i];
                            $array[$i] = $temp;
                        }
                    }
                }
            }
        }

        $newFileName = uniqid() . '.csv';
        $newFile = __DIR__ . "/../../../public/storage/" . $newFileName;

        if (!file_exists($newFile)) {
            $fp = fopen($newFile, "w");
            for ($i = 0; $i < $countArray; $i++) {
                fputcsv($fp, $array[$i], ';', '"');
            }
            fclose($fp);
        }

        Files::find($file->id)->update([
            'status' => '1',
            'array' => json_encode($array),
            'newFile' => $newFileName,
        ]);
    }

    static public function printFile($count = null, $countArray, $array, $newFile)
    {
        if (isset($count)) {
            if ($count >= $countArray) {
                $count = $countArray - 1;
            }

            for ($i = 0; $i < $count + 1; $i++) {
                foreach ($array[$i] as $cell) {
                    echo $cell . ' ';
                }
                echo '<br>';
            }
        } else {
            for ($i = 0; $i < $countArray; $i++) {
                foreach ($array[$i] as $cell) {
                    echo $cell . ' ';
                }
                echo '<br>';
            }
        }
        echo '<a href="' . $newFile . '" download>Скачать файл</a>';
    }
}
