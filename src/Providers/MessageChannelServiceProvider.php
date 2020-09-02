<?php

namespace Netflex\MessageChannel\Providers;

use Netflex\MessageChannel\Handler;
use Netflex\MessageChannel\Client;

use Illuminate\Support\ServiceProvider;

class MessageChannelServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->singleton('netflex-message-channel', function () {
      $publicKey = $this->app['config']['api.publicKey'] ?? null;
      $privateKey = $this->app['config']['api.privateKey'] ?? null;
      $handler = null;

      if ($endpoint = $this->app['config']['message-channel.handler.endpoint']) {
        $method = $this->app['config']['message-channel.handler.method'] ?? 'post';
        $handler = new Handler($endpoint, $method);
      }

      return new Client($publicKey, $privateKey, $handler);
    });
  }
}
