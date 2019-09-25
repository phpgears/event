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
        if (!$this->isEventSupported($event)) {
            throw new InvalidEventException(\sprintf(
                'Event must be a "%s", "%s" given',
                \implode('"or "', $this->getSupportedEventTypes()),
                \get_class($event)
            ));
        }

        $this->handleEvent($event);
    }

    /**
     * Is event supported.
     *
     * @param Event $event
     *
     * @return bool
     */
    private function isEventSupported(Event $event): bool
    {
        $supported = false;

        foreach ($this->getSupportedEventTypes() as $supportedEventType) {
            if (\is_a($event, $supportedEventType)) {
                $supported = true;

                break;
            }
        }

        return $supported;
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
