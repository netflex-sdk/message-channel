<?php

namespace Netflex\MessageChannel;

use JsonSerializable;

class Handler implements JsonSerializable
{
  /** @var string */
  public $endpoint;

  /** @var string */
  public $method;

  public function __construct($endpoint, $method = 'post')
  {
    $this->endpoint = $endpoint;
    $this->method = $method;
  }

  #[\ReturnTypeWillChange]
  public function jsonSerialize()
  {
    return [
      'method' => $this->method,
      'endpoint' => $this->endpoint
    ];
  }
}
