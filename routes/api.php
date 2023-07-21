<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use YoutubeCompilator\Helper;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('url', function (Request $request) {
    $url = $request->get('url');
    Log::info('url: ' . $url);

    $link = App\Models\Link::firstOrCreate(
        ['url' => $url]
    );

    if (!$link->title) {
        $video_id = Helper::getId($url);
        Log::info('video_id: ' . $video_id);
        try {
            $link->title = Helper::get_video_title($video_id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'No se pudo obtener el título del video'
            ]);
        }

        $link->save();
    }

    return response()->json([
        'url' => $link->url,
        'title' => $link->title
    ]);
});
