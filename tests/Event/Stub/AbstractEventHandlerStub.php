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

namespace Gears\Event\Tests\Stub;

use Gears\Event\AbstractEventHandler;
use Gears\Event\Event;

/**
 * Abstract event handler stub class.
 */
class AbstractEventHandlerStub extends AbstractEventHandler
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedEventTypes(): array
    {
        return [AbstractEventStub::class];
    }

    /**
     * {@inheritdoc}
     */
    protected function handleEvent(Event $event): void
    {
    }
}
