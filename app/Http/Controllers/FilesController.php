<?php

namespace App\Http\Controllers;

use App\Http\Helpers\HelperGlobal;
use App\Http\Helpers\HelperResponses;
use App\ModelFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilesController extends Controller
{
    public function get_all_files(Request $request)
    {
        $files = ModelFile::orderBy('created_at', 'DESC')->get();
        return HelperResponses::getSuccessResponse($files);
    }

    public function upload_image(Request $request)
    {
        $rules = array
        (
            'file' => 'required|image',
        );

        $messages = array
        (
            'file.required' => "Необходимо загрузить файл",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }


        $file = HelperGlobal::saveFileModel($request, 'file', 'image');

        return HelperResponses::getSuccessResponse($file);
    }

    public function upload_video(Request $request)
    {
        $rules = array
        (
            'file' => 'required|mimes:mp4,mov,ogg,qt',
        );

        $messages = array
        (
            'file.required' => "Необходимо загрузить видео файл",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $file = HelperGlobal::saveFileModel($request, 'file', 'video');

        $preview_file_id = $request->get('preview_file_id');
        if ($preview_file_id != null)
        {
            $file->preview_file_id = $preview_file_id;
            $file->save();
        }

        $file = ModelFile::find($file->id);

        return HelperResponses::getSuccessResponse($file);
    }
}
