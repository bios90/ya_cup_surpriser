<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 11/19/22
 * Time: 7:25 PM
 */

namespace App\Http\Controllers;

use App\Http\Helpers\HelperGlobal;
use App\Http\Helpers\HelperResponses;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function get_users(Request $request)
    {
        $query = User::query();

        if ($request->get('search') != null)
        {
            $search = $request->get('search');
            $as_words = explode(' ', $search);

            foreach ($as_words as $word)
            {
                $query->where(function ($query) use ($word)
                {
                    $search_word = '%' . $word . '%';
                    return $query->where('name', 'like', $search_word)
                        ->orWhere('email', 'like', $search_word);
                });
            }
        }

        $users = $query->get();
        return HelperResponses::getSuccessResponse($users);
    }

    public function upload_avatar(Request $request) {
        $rules = array
        (
            'user_id' => 'required',
            'avatar_id' => 'required',

        );

        $messages = array
        (
            'user_id.required' => "**** Error no user id ****",
            'avatar_id.required' => "**** Error no avatar id ****",
        );


        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $user_id = $request->get('user_id');
        $avatar_id = $request->get('avatar_id');

        $user = User::find($user_id);
        if($user == null)
        {
            return HelperResponses::getFailedResponse("Пользователь");
        }

        $user->avatar_id = $avatar_id;
        $user->save();
        return HelperResponses::getSuccessResponse($user);
    }
}