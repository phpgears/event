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

namespace Gears\Event\Tests;

use Gears\Event\Exception\InvalidEventException;
use Gears\Event\Tests\Stub\AbstractEmptyEventStub;
use Gears\Event\Tests\Stub\AbstractEventHandlerStub;
use Gears\Event\Tests\Stub\AbstractEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract domain event handler test.
 */
class AbstractEventHandlerTest extends TestCase
{
    public function testInvalidEventType(): void
    {
        $this->expectException(InvalidEventException::class);
        $this->expectExceptionMessageRegExp(
            '/^Event handler ".+" can only handle events of: ".+\\\AbstractEventStub", ".+" given\.$/'
        );

        $handler = new AbstractEventHandlerStub();
        $handler->handle(AbstractEmptyEventStub::instance());
    }

    public function testHandling(): void
    {
        $handler = new AbstractEventHandlerStub();
        $handler->handle(AbstractEventStub::instance([]));

        static::assertTrue(true);
    }
}
