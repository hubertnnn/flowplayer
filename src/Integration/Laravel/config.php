<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FlowPlayer credentials api keys
    |--------------------------------------------------------------------------
    |
    | Private key and site id are required by all api calls.
    | User id is required only if you are planning to create videos
    |
    */

    'credentials' => [
        'apiKey' => env('FLOWPLAYER_API_KEY'),
        'siteId' => env('FLOWPLAYER_SITE_ID'),
        'userId' => env('FLOWPLAYER_USER_ID'),
    ],
];
