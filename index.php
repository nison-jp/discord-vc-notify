<?php

include __DIR__ . '/vendor/autoload.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\WebSockets\VoiceStateUpdate;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$discord = new Discord([
    'token' => $_ENV['DISCORD_TOKEN'],
    'intents' => Intents::getDefaultIntents()
        | Intents::GUILD_VOICE_STATES
//      | Intents::MESSAGE_CONTENT, // Note: MESSAGE_CONTENT is privileged, see https://dis.gd/mcfaq
]);

$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready!", PHP_EOL;

    // Listen for messages.
    // $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
    //     echo "{$message->author->username}: {$message->content}", PHP_EOL;
    //     // Note: MESSAGE_CONTENT intent must be enabled to get the content if the bot is not mentioned/DMed.
    // });
    $discord->on(Event::VOICE_STATE_UPDATE, function (VoiceStateUpdate $voiceStateUpdate, Discord $discord) {
        $sendingMessage = "{$voiceStateUpdate->user?->username} joined {$voiceStateUpdate->channel?->name}. " . PHP_EOL;
        echo $sendingMessage;
        $voiceStateUpdate->channel?->sendMessage($sendingMessage);
    });
});

$discord->run();