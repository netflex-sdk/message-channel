<?php

namespace Netflex\MessageChannel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed broadcast(mixed $message, string $topic = 'public')
 * @method static string key()
 *
 * @see \Netflex\MessageChannel\Client
 */
class MessageChannel extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'netflex-message-channel';
  }
}
