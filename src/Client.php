<?php

namespace Netflex\MessageChannel;

use Netflex\API\Client as API;

class Client
{
  /** @var string */
  public $channel;

  /** @var API */
  protected $client;

  /** @var IncomingMessageHandler|null */
  protected $incomingMessageHandler;

  protected $defaultTopic = null;

  /**
   * @param string $publicKey
   * @param string $privateKey
   * @param IncomingMessageHandler|null $incomingMessageHandler
   */
  public function __construct($publicKey, $privateKey, $incomingMessageHandler = null)
  {
    $this->channel = md5_to_uuid(md5($publicKey));
    $this->incomingMessageHandler = $incomingMessageHandler;

    $this->client = new API([
      'base_uri' => 'https://broadcast.netflexapp.com',
      'auth' => [
        $publicKey,
        $privateKey
      ]
    ]);

    $this->register();
  }

  /**
   * Retrieves the channel key
   * @return string
   */
  public function key()
  {
    return $this->channel;
  }

  protected function register()
  {
    if ($this->incomingMessageHandler) {
      $this->client->post('register', $this->incomingMessageHandler);
      return true;
    }

    return false;
  }

  public function broadcast($message, $topic = 'public')
  {
    $response = $this->client->post("broadcast/$topic", ['data' => $message]);

    if (!$response->handler || $response->handler->endpoint !== $this->incomingMessageHandler->endpoint) {
      $this->register();
    }

    return $response;
  }
}
