<?php

namespace Netflex\MessageChannel;

use GuzzleHttp\Client as Guzzle;

class Client
{
  /** @var string */
  public $id;

  /** @var Guzzle */
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
    $this->id = md5_to_uuid(md5($publicKey));

    $this->incomingMessageHandler = $incomingMessageHandler;

    $this->client = new Guzzle([
      'base_uri' => 'https://broadcast.netflexapp.com',
      'auth' => [
        $publicKey,
        $privateKey
      ]
    ]);

    $this->register();
  }

  protected function register()
  {
    if ($this->incomingMessageHandler) {
      $this->client->post('/register', ['json' => $this->incomingMessageHandler]);
      return true;
    }

    return false;
  }

  public function broadcast($message, $topic = 'public')
  {
    $response = json_decode(
      $this->client->post('/broadcast/' . $topic, ['json' => (object) ['data' => $message]])
        ->getBody()
    );

    if (!$response->handler || $response->handler->endpoint !== $this->incomingMessageHandler->endpoint) {
      $this->register();
    }

    return $response;
  }
}
