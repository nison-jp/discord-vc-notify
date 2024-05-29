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

$notified_sessions = [];

$discord->on('ready', function (Discord $discord) use (&$notified_sessions) {
    echo "Bot is ready!", PHP_EOL;

    $discord->on(Event::VOICE_STATE_UPDATE, function (VoiceStateUpdate $voiceStateUpdate, Discord $discord) use (&$notified_sessions) {
        if (!isset($notified_sessions[$voiceStateUpdate->session_id]) || $notified_sessions[$voiceStateUpdate->session_id] != $voiceStateUpdate->channel_id) {
            $sendingMessage = "{$voiceStateUpdate->user?->username} joined {$voiceStateUpdate->channel?->name}. " . PHP_EOL;
            $voiceStateUpdate->channel?->sendMessage($sendingMessage);
            $notified_sessions[$voiceStateUpdate->session_id] = $voiceStateUpdate->channel_id;
        }
        if (is_null($voiceStateUpdate->channel_id)) {
            unset($notified_sessions[$voiceStateUpdate->session_id]);
        }
        echo "session table length is now: " . count($notified_sessions) . PHP_EOL;
    });
});
pcntl_signal(SIGTERM, function () use ($discord) {
    echo "Received SIGTERM, shutting down..." . PHP_EOL;
    $discord->close();
});
$discord->run();