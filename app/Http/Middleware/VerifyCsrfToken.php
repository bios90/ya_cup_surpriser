<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/register',
        '/login',
        '/get_users',
        '/get_all_files',
        '/upload_image',
        '/upload_video',
        '/upload_avatar',
        '/create_surprise',
        '/get_surprise_by_id',
        '/get_my_sended',
        '/get_my_received',
        '/reject_surprise',
        '/update_reaction',
    ];
}