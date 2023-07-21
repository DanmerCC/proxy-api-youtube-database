<?php

namespace YoutubeCompilator;

use Illuminate\Support\Facades\Log;

abstract class Helper
{
    public static function getId($url)
    {
        preg_match('/(?<=v=)[^&#]+/', $url, $video_id);

        //id in case https://www.googleapis.com/youtube/v3/videos?part=snippet&id=&key=AIzaSyAO7MRXqTIqLefKPqJKgZS3OCsxpoZHpVE

        if (!isset($video_id[0])) {
            preg_match('/(?<=be\/)[^&#]+/', $url, $video_id);
        }

        //in cases http://www.youtube.com/v/A_G49pd0Avw&rel=1

        if (!isset($video_id[0])) {
            preg_match('/(?<=v\/)[^&#]+/', $url, $video_id);
        }

        //en caso de embed's https://www.youtube.com/embed/OwVC2CS6fW8
        if (!isset($video_id[0])) {
            preg_match('/(?<=embed\/)[^&#]+/', $url, $video_id);
        }

        //in case http://www.youtube.com/v/abR6yzqe8Uw&hl=es_MX&fs=1&
        if (!isset($video_id[0])) {
            preg_match('/(?<=v\/)[^&#]+/', $url, $video_id);
        }

        return isset($video_id[0]) ? $video_id[0] : null;
    }

    public static function get_video_title($video_id)
    {
        $api_key = env('YOUTUBE_API_KEY');
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $video_id . '&key=' . $api_key;
        Log::info('api_url: ' . $api_url);
        $data = file_get_contents($api_url);
        Log::info('data: ' . json_encode($data));
        $json = json_decode($data);
        return $json->items[0]->snippet->title;
    }

    public static function verifyMaxTime()
    {
    }
}
