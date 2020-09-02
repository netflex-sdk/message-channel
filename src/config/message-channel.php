<?php

use Netflex\Pages\Components\Picture;

return [

  /*
    |--------------------------------------------------------------------------
    | Handlers
    |--------------------------------------------------------------------------
    |
    | Your application's incoming message handler
    |
    */
  'handler' => [
    'endpoint' => env('APP_URL') . '/incoming-message-handler',
    'method' => 'post',
  ],

];
