<?php

namespace App\Http\Controllers;

use League\Glide\Responses\SymfonyResponseFactory;
use Illuminate\Support\Facades\Storage;
use League\Glide\ServerFactory;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function show(Request $request, $path)
    {
        $server = ServerFactory::create([
            'response' => new SymfonyResponseFactory($request),
            'source' => Storage::getDriver(),
            'cache' => Storage::getDriver(),
            'cache_path_prefix' => '.glide-cache',
        ]);

        return $server->getImageResponse($path, $request->all());
    }
}
