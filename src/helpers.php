<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('md5_to_uuid')) {
  /**
   * Generates a UUID from a md5 hash
   * @return string
   */
  function md5_to_uuid($md5)
  {
    return substr($md5, 0, 8) . '-' .
      substr($md5, 8, 4) . '-' .
      substr($md5, 12, 4) . '-' .
      substr($md5, 16, 4) . '-' .
      substr($md5, 20);
  }
}

if (!function_exists('message_channel_key')) {
  /**
   * Retrieves the applications message channel key
   * @return string
   */
  function message_channel_key()
  {
    return md5_to_uuid(Config::get('api.publicKey'));
  }
}
