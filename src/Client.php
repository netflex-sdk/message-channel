<?php

namespace Netflex\MessageChannel;

use Netflex\API\Client as API;
use Illuminate\Broadcasting\Channel;

class Client
{
  /** @var string */
  public $channel;

  /** @var API */
  protected $client;

  /** @var IncomingMessageHandler|null */
  protected $incomingMessageHandler;

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
   * 
   * @return string
   */
  public function key()
  {
    return $this->channel;
  }

  /**
   * Registers a Handler
   * 
   * @param Handler $handler = null
   */
  public function register(Handler $handler = null)
  {
    $this->incomingMessageHandler = $handler ? $handler : $this->incomingMessageHandler;

    if ($this->incomingMessageHandler) {
      $this->client->post('register', $this->incomingMessageHandler);
      return true;
    }

    return false;
  }

  /**
   * Broadcasts the message to the given topic
   * 
   * @param mixed $message
   * @param Channel|string $topic
   * @return mixed
   */
  public function broadcast($message, $topic = 'public')
  {
    $topic = $topic instanceof Channel ? $topic->name : $topic;
    $response = $this->client->post("broadcast/$topic", ['data' => $message]);

    if (!$response->handler || $response->handler->endpoint !== $this->incomingMessageHandler->endpoint) {
      $this->register();
    }

    return $response;
  }
}
