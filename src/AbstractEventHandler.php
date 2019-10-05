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

namespace Gears\Event;

use Gears\Event\Exception\InvalidEventException;

abstract class AbstractEventHandler implements EventHandler
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidEventException
     */
    final public function handle(Event $event): void
    {
        if (!\in_array($event->getEventType(), $this->getSupportedEventTypes(), true)) {
            throw new InvalidEventException(\sprintf(
                'Event handler "%s" can only handle events of: "%s", "%s" given',
                self::class,
                \implode('"or "', $this->getSupportedEventTypes()),
                \get_class($event)
            ));
        }

        $this->handleEvent($event);
    }

    /**
     * Get supported event type.
     *
     * @return string[]
     */
    abstract protected function getSupportedEventTypes(): array;

    /**
     * Handle event.
     *
     * @param Event $event
     */
    abstract protected function handleEvent(Event $event): void;
}
