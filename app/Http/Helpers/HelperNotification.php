<?php
/**
 * Created by PhpStorm.
 * User: bios90
 * Date: 2021-04-24
 * Time: 18:01
 */

namespace App\Http\Helpers;

use App\ModelNews;
use App\ModelNotice;
use App\ModelService;
use App\User;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\Topics;

class HelperNotification
{
    static function sendNewUserRegistrationPush($user_id)
    {
        $user = User::find($user_id);
        if ($user == null)
        {
            return;
        }

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(
            [
                'type' => 'new_user_register',
                'user_full_name' => $user->getFullName(),
                'user_id' => $user->id
            ]);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 60 * 24 * 4);

        $option = $optionBuilder->build();
        $data = $dataBuilder->build();

        $topic = new Topics();
        $topic->topic('nash_prihod_admins');

        $topicResponse = FCM::sendToTopic($topic, $option, null, $data);
    }

    static function sendNewsAdd($news_id)
    {
        $news = ModelNews::find($news_id);
        if ($news == null)
        {
            return;
        }

        $title = "Добавлена новость";
        $text = $news->author->getFullName() . " добавил новость: " . $news->title;

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(
            [
                'type' => 'news_add',
                'news_id' => $news_id,
                'title' => $title,
                'text' => $text
            ]);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 60 * 24 * 4);

        $option = $optionBuilder->build();
        $data = $dataBuilder->build();

        $topic = new Topics();
        $topic->topic('nash_prihod_users');

        $topicResponse = FCM::sendToTopic($topic, $option, null, $data);
    }

    static function sendNoticeAdd($notice_id)
    {
        $notice = ModelNotice::find($notice_id);
        if ($notice == null)
        {
            return;
        }

        $title = "Объявление";
        $text = $notice->author->getFullName() . " добавил объявление: " . $notice->title;

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(
            [
                'type' => 'notice_add',
                'notice_id' => $notice_id,
                'title' => $title,
                'text' => $text
            ]);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 60 * 24 * 4);

        $option = $optionBuilder->build();
        $data = $dataBuilder->build();

        $topic = new Topics();
        $topic->topic('nash_prihod_users');

        $topicResponse = FCM::sendToTopic($topic, $option, null, $data);
    }

    static function sendServiceAdd($service_id)
    {
        $service = ModelService::find($service_id);
        if ($service == null)
        {
            return;
        }

        $title = "Добавлено расписание";
        $date_text = date('d-F-Y', strtotime($service->date));
        $text = $date_text . " - " . $service->title;

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(
            [
                'type' => 'service_add',
                'service_id' => $service_id,
                'title' => $title,
                'text' => $text
            ]);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 60 * 24 * 4);

        $option = $optionBuilder->build();
        $data = $dataBuilder->build();

        $topic = new Topics();
        $topic->topic('nash_prihod_users');

        $topicResponse = FCM::sendToTopic($topic, $option, null, $data);
    }
}