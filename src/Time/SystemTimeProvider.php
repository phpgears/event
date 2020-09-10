<?php

/*
 * event (https://github.com/phpgears/event).
 * Event handling.
 *
 * @license MIT
 * @link https://github.com/phpgears/event
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Gears\Event\Time;

/**
 * General system time provider.
 */
final class SystemTimeProvider implements TimeProvider
{
    /**
     * {@inheritdoc}
     */
    public function getCurrentTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now');
    }
}
