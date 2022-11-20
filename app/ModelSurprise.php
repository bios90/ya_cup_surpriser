<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 11/19/22
 * Time: 7:28 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;


class ModelSurprise extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'text',
        'file_type',
        'reaction_date',
        'attachment_file_id',
        'reaction_file_id',
        'is_rejected',
        'reaction_date',
    ];

    protected $casts = [
        'is_rejected' => 'boolean',
    ];

    protected $with = [
        'sender',
        'receiver',
        'attachment',
        'reaction',
    ];

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }

    public function attachment()
    {
        return $this->hasOne(ModelFile::class, 'id', 'attachment_file_id');
    }

    public function reaction()
    {
        return $this->hasOne(ModelFile::class, 'id', 'reaction_file_id');
    }
}