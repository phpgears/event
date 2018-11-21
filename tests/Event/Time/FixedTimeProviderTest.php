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

namespace Gears\Event\Tests\Time;

use Gears\Event\Time\FixedTimeProvider;
use PHPUnit\Framework\TestCase;

/**
 * Fixed time provider test.
 */
class FixedTimeProviderTest extends TestCase
{
    public function testTime(): void
    {
        $fixedTime = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $timeProvider = new FixedTimeProvider($fixedTime);

        $this->assertEquals($fixedTime, $timeProvider->getCurrentTime());

        $newTime = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $timeProvider->setCurrentTime($newTime);
        $this->assertEquals($newTime, $timeProvider->getCurrentTime());
    }
}
