# Netflex MessageChannel

This library lets you send real time messages to connected clients over WebSocket using the Netflex MessageChannel API.

## Installation

Just add this package as a dependency to yout Netflex SDKv2 based project, and it should be ready to use, no additional setup is required.

```bash
composer require netflex/message-channel
```

## Usage

```php
<?php

use MessageChannel;

MessageChannel::broadcast(['status' => 'Hello World']);
```

This will send this message to the MessageChannel API server, which will then relay that message to its connected clients over WebSocket.

## Handling incoming messages

To handle incoming messages, you will have to register a handler.
This can be configured in your apps config `config/message-channel.php`

```php
<?php

return [
  'handler' => [
    'endpoint' => 'https://my-endpoint-to-handle-incoming-messages',
    'method' => 'post' // This is optional, 'post' is the default method
  ]
];
```

## Sending to specific clients/topics

A client can register for a 'topic'. If you use e.g a users ID as the topic, you can then relay messages to this specific topic.

```php
<?php

use MessageChannel;

// Only clients listening for the 'news' topic will receive this message
MessageChannel::broadcast(['status' => 'Hello World'], 'news');
```
