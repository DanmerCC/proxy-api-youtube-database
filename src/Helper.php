<?php

namespace YoutubeCompilator;

abstract class Helper
{
    public static function getId($url)
    {
        preg_match('/(?<=v=)[^&#]+/', $url, $video_id);
        return isset($video_id[0]) ? $video_id[0] : null;
    }

    public static function get_video_title($video_id)
    {
        $api_key = env('YOUTUBE_API_KEY');
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $video_id . '&key=' . $api_key;
        $data = file_get_contents($api_url);
        $json = json_decode($data);
        return $json->items[0]->snippet->title;
    }

    public static function verifyMaxTime()
    {
    }
}
