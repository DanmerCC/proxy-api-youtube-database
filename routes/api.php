<?php

use Illuminate\Http\Request;
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
    $link = App\Models\Link::firstOrCreate(
        ['url' => $url]
    );

    if (!$link->title) {
        $video_id = Helper::getId($url);
        $link->title = Helper::get_video_title($video_id);
        $link->save();
    }

    return response()->json([
        'url' => $link->url,
        'title' => $link->title
    ]);
});
