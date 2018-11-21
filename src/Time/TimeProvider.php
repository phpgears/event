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
 * Time provider interface.
 */
interface TimeProvider
{
    /**
     * Get time from clock.
     *
     * @return \DateTimeImmutable
     */
    public function getCurrentTime(): \DateTimeImmutable;
}
