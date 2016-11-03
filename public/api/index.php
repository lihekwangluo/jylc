<?php

require __DIR__.'/../../bootstrap/autoload.php';

$app = require_once __DIR__.'/../../bootstrap/app.php';

//api二级入口
define("LARAVEL_SERVICE_TYPE", "API_SECONDARY");

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
