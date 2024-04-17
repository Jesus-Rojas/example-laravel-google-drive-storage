<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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

Route::post('/save-file', function (Request $request) {
    if (!$request->hasFile('file')) {
        return response()->json(['message' => 'No file uploaded'], 400);
    }

    /** @var \Illuminate\Http\UploadedFile $disk */
    $disk = Storage::disk('google');
    $file = $request->file('file');
    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
    $path = $disk->putFileAs('', $file, $filename);
    $url = $disk->url($filename);
    return response()->json(['path' => $path, 'url' => $url]);
});
