<?php

namespace App\Http\Controllers;

use App\FbToken;
use App\Http\Helpers\HelperGlobal;
use App\Http\Helpers\HelperResponses;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function privacy()
    {
        return view('authorization.privacy');
    }

    public function register(Request $request)
    {
        $rules = array
        (
            'name' => 'required|max:255',
            'email' => 'bail|email|required|unique:users',
            'password' => 'required|min:8',
        );

        $messages = array
        (
            'name.required' => HelperResponses::getFillFiledText("Имя"),
            'name.max' => "Максимальная длина текста 255 символов",
            'email.required' => HelperResponses::getFillFiledText("Email"),
            'email.unique' => 'Данный email занят, если вы забыли пароль вы можете его восстановить.',
            'email.email' => 'Введите корректный email',
            'password.required' => HelperResponses::getFillFiledText("Пароль"),
            'password.regex' => 'Пароль должен содержать минимум 8 символов',
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $password = bcrypt($request->get('password'));
        $request->merge(['password' => $password]);
        $activation_key = Str::random(64);
        $request->merge(['activation_key' => $activation_key]);

        $user = new User($request->all());
        if ($request->hasFile('avatar') != null)
        {
            $avatar_file = HelperGlobal::saveFileModel($request, 'avatar', 'image');
            $user->avatar_id = $avatar_file->id;
        }

        $user->save();
        $user = User::find($user->id);

        return HelperResponses::getSuccessResponse($user);
    }


    public function login(Request $request)
    {
        $rules = array
        (
            'email' => 'required',
            'password' => 'required',
        );

        $messages = array
        (
            'email.required' => HelperResponses::getFillFiledText("Email"),
            'password.required' => HelperResponses::getFillFiledText("Пароль"),
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $password = $request->get('password');
        $email = $request->get('email');

        $user = User::where('email', '=', $email)->first();
        if ($user == null)
        {
            return HelperResponses::getFailedResponse(["Пользователь с данным email не найден"]);
        }

        if (!Hash::check($password, $user->password))
        {
            return HelperResponses::getFailedResponse(["Неверный логин или пароль"]);
        }


        if ($request->get('fb_token') != null)
        {
            $fb_token = $request->get('fb_token');

            FbToken::where('fb_token', '=', $fb_token)->delete();

            $input = array();
            $input['fb_token'] = $fb_token;
            $input['user_id'] = $user->id;
            FbToken::create($input);
        }

        return HelperResponses::getSuccessResponse($user);
    }

}
