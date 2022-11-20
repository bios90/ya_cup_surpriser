<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 2021-02-23
 * Time: 04:03
 */

namespace App\Http\Helpers;


use FFMpeg;
use App\ModelFile;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;

class HelperGlobal
{
    static function getStorageRootForUrl()
    {
        $storage_url = "/storage/files/";
        return $storage_url;
    }

    static function getStorageRoot()
    {
        $storage_url = Storage::disk('public')->path('/files/');
        return $storage_url;
    }

    static function makeValidation(Request $request, $rules, $messages)
    {
        $validator = Validator::make
        (
            $request->all(),
            $rules,
            $messages
        );

        if ($validator->fails())
        {
            $error = $validator->errors()->all();
            return $error;
        }

        return null;
    }

    static function saveFile(UploadedFile $file)
    {

        $file_name = bin2hex(random_bytes(20)) . '.' . $file->extension();
        $file->move(HelperGlobal::getStorageRoot(), $file_name);
        return $file_name;
    }

    static function saveFileModel(Request $request, $file_param_name = 'file', $file_type = 'file')
    {
        $file = $request->file($file_param_name);
        $file_mime_type = $file->getMimeType();
        $file_size = $request->file($file_param_name)->getSize();
        $file_name = HelperGlobal::saveFile($file);

        $data = [
            'file_name' => $file_name,
            'file_original_name' => $request->get('file_original_name'),
            'file_mime_type' => $file_mime_type,
            'file_size' => $file_size,
            'file_type' => $file_type,
        ];

        $file = ModelFile::create($data);
        return $file;
    }

    static function createVideoThumbnail(ModelFile $file_video)
    {

        $video_url = HelperGlobal::getStorageRoot() . $file_video->file_name;


        $file_name = bin2hex(random_bytes(20)) . '.jpg';
        $full_path = HelperGlobal::getStorageRoot() . '/' . $file_name;

        Log::info("File to form " . $full_path);


        $ffprobe = FFMpeg\FFProbe::create(array(
            'ffmpeg.binaries' => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe'));

        $dimensions = $ffprobe
            ->streams($video_url)
            ->videos()
            ->first()
            ->getDimensions();

        $duration = $ffprobe->format($video_url)->get('duration');
        $duration = explode(".", $duration)[0];
        $thumbnail_pos = $duration / 2;

        Log::info("Posos is $thumbnail_pos");

        $width = $dimensions->getWidth();
        $height = $dimensions->getHeight();

        VideoThumbnail::createThumbnail($video_url, HelperGlobal::getStorageRoot(), $file_name, $thumbnail_pos, $width, $height);

        $image_url = HelperGlobal::getStorageRoot() . $file_name;
        Log::info("Image url is " . $image_url);

        $data = [
            'file_name' => $file_name,
            'file_original_name' => $file_video->file_original_name . '_thumbail',
            'file_mime_type' => 'image/jpeg',
            'file_size' => File::size($image_url),
            'file_type' => 'image'
        ];

        $file = ModelFile::create($data);
        return $file;
    }
}