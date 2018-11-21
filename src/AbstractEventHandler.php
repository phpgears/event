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
        $supportedEventType = $this->getSupportedEventType();
        if (!\is_a($event, $supportedEventType)) {
            throw new InvalidEventException(\sprintf(
                'Event must implement %s interface, %s given',
                $supportedEventType,
                \get_class($event)
            ));
        }

        $this->handleEvent($event);
    }

    /**
     * Get supported event type.
     *
     * @return string
     */
    abstract protected function getSupportedEventType(): string;

    /**
     * Handle event.
     *
     * @param Event $event
     */
    abstract protected function handleEvent(Event $event): void;
}
