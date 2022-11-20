<?php

namespace App;

use App\Http\Helpers\HelperGlobal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file_name', 'file_mime_type', 'file_size', 'file_original_name', 'file_type', 'preview_file_id'
    ];


    protected $with = ['preview_image'];

    protected $appends = ['url'];

    public function preview_image()
    {
        return $this->hasOne(ModelFile::class, 'id', 'preview_file_id');
    }

    function getUrlAttribute()
    {
        return url(HelperGlobal::getStorageRootForUrl() . $this->file_name);
    }

}
