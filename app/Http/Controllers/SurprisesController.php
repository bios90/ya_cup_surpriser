<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 11/19/22
 * Time: 7:39 PM
 */

namespace App\Http\Controllers;

use App\Http\Helpers\HelperGlobal;
use App\Http\Helpers\HelperResponses;
use App\ModelSurprise;
use Illuminate\Http\Request;

class SurprisesController extends Controller
{
    public function create_surprise(Request $request)
    {
        $rules = array
        (
            'sender_id' => 'required',
            'receiver_id' => 'required',
        );

        $messages = array
        (
            'sender_id.required' => "**** Error no sender id ****",
            'receiver_id.required' => "**** Error no receiver id ****",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $surprise = ModelSurprise::create($request->all());
        return HelperResponses::getSuccessResponse($surprise);
    }

    public function get_surprise_by_id(Request $request)
    {
        $rules = array
        (
            'surprise_id' => 'required',
        );

        $messages = array
        (
            'surprise_id.required' => "**** Error no surprise id ****",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $surprise_id = $request->get('surprise_id');
        $surprise = ModelSurprise::find($surprise_id);
        if ($surprise == null)
        {
            return HelperResponses::getFailedResponse("Сообщение не найдено");
        }

        return HelperResponses::getSuccessResponse($surprise);
    }

    public function get_my_sended(Request $request)
    {
        $rules = array
        (
            'sender_id' => 'required',
        );

        $messages = array
        (
            'sender_id.required' => "**** Error no sender id ****",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $sender_id = $request->get('sender_id');
        $surprises = ModelSurprise::where('sender_id',$sender_id)->get();
        return HelperResponses::getSuccessResponse($surprises);
    }


    public function get_my_received(Request $request)
    {
        $rules = array
        (
            'receiver_id' => 'required',
        );

        $messages = array
        (
            'receiver_id.required' => "**** Error no receiver id ****",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $sender_id = $request->get('receiver_id');
        $surprises = ModelSurprise::where('receiver_id2',$sender_id)->get();
        return HelperResponses::getSuccessResponse($surprises);
    }

    public function reject_surprise(Request $request)
    {
        $rules = array
        (
            'surprise_id' => 'required',
        );

        $messages = array
        (
            'surprise_id.required' => "**** Error no surprise id ****",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $surprise_id = $request->get('surprise_id');
        $surprise = ModelSurprise::find($surprise_id);
        if ($surprise == null)
        {
            return HelperResponses::getFailedResponse("Сообщение не найдено");
        }

        $surprise->is_rejected = true;
        $surprise->save();

        return HelperResponses::getSuccessResponse($surprise);
    }

    public function update_reaction(Request $request)
    {
        $rules = array
        (
            'surprise_id' => 'required',
            'reaction_file_id' => 'required',
        );

        $messages = array
        (
            'surprise_id.required' => "**** Error no surprise id ****",
            'reaction_file_id.required' => "**** Error no reaction id ****",
        );

        $errors = HelperGlobal::makeValidation($request, $rules, $messages);
        if ($errors != null)
        {
            return HelperResponses::getFailedResponse($errors);
        }

        $surprise_id = $request->get('surprise_id');
        $reaction_file_id = $request->get('reaction_file_id');
        $surprise = ModelSurprise::find($surprise_id);
        if ($surprise == null)
        {
            return HelperResponses::getFailedResponse("Сообщение не найдено");
        }

        $surprise->reaction_file_id = $reaction_file_id;
        $surprise->save();

        return HelperResponses::getSuccessResponse($surprise);
    }
}
