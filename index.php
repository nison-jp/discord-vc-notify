<?php
declare (ticks = 1);
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
]);

$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready!", PHP_EOL;

    $discord->on(Event::VOICE_STATE_UPDATE, function (VoiceStateUpdate $voiceStateUpdate, Discord $discord) {
        
        $sendingMessage = "{$voiceStateUpdate->user?->username} joined {$voiceStateUpdate->channel?->name}. " . PHP_EOL;
        $voiceStateUpdate->channel?->sendMessage($sendingMessage);
    });
});
pcntl_signal(SIGTERM, function () use ($discord) {
    echo "Received SIGTERM, shutting down..." . PHP_EOL;
    $discord->close();
});
$discord->run();