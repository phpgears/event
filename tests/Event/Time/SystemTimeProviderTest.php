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

use Gears\Event\Time\SystemTimeProvider;
use PHPUnit\Framework\TestCase;

/**
 * System's time provider test.
 */
class SystemTimeProviderTest extends TestCase
{
    public function testTime(): void
    {
        $timeProvider = new SystemTimeProvider();

        $previousTime = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        for ($i = 0; $i < 10; $i++) {
            $currentTime = $timeProvider->getCurrentTime();

            static::assertTrue($currentTime > $previousTime);

            $previousTime = $currentTime;
        }
    }
}
