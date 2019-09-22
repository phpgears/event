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

final class EventArrayCollection implements EventCollection
{
    /**
     * @var Event[]
     */
    private $events = [];

    /**
     * EventArrayCollection constructor.
     *
     * @param (Event|mixed)[] $events
     *
     * @throws InvalidEventException
     */
    public function __construct(array $events)
    {
        foreach ($events as $event) {
            if (!$event instanceof Event) {
                throw new InvalidEventException(\sprintf(
                    'Event collection only accepts "%s", "%s" given',
                    Event::class,
                    \is_object($event) ? \get_class($event) : \gettype($event)
                ));
            }

            $this->events[] = $event;
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return Event
     */
    public function current(): Event
    {
        return \current($this->events);
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        \next($this->events);
    }

    /**
     * {@inheritdoc}
     *
     * @return string|int|null
     */
    public function key()
    {
        return \key($this->events);
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return \key($this->events) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        \reset($this->events);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->events);
    }
}
