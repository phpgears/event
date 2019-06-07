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

use Gears\Event\Tests\Stub\AbstractEmptyEventStub;
use Gears\Event\Tests\Stub\AbstractEventHandlerStub;
use Gears\Event\Tests\Stub\AbstractEventStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract domain event handler test.
 */
class AbstractEventHandlerTest extends TestCase
{
    /**
     * @expectedException \Gears\Event\Exception\InvalidEventException
     * @expectedExceptionMessageRegExp /Event must be a .+\\AbstractEventStub, .+ given/
     */
    public function testInvalidEventType(): void
    {
        $handler = new AbstractEventHandlerStub();
        $handler->handle(AbstractEmptyEventStub::instance());
    }

    public function testHandling(): void
    {
        $handler = new AbstractEventHandlerStub();
        $handler->handle(AbstractEventStub::instance([]));

        $this->assertTrue(true);
    }
}
