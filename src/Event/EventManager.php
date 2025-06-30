<?php

namespace Nirbose\PhpMcServ\Event;

use Closure;
use stdClass;

class EventManager
{
    private static array $listeners = [];

    public function __construct()
    {
    }

    public function register(string $eventClass, Closure $listener): void
    {
        self::$listeners[$eventClass][] = $listener;
    }

    public static function call(Event $event): void
    {
        foreach (self::$listeners[get_class($event)] ?? [] as $listener) {
            call_user_func($listener, $event);
        }
    }

}