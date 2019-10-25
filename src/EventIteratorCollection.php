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

final class EventIteratorCollection implements EventCollection
{
    /**
     * @var \Iterator
     */
    private $iterator;

    /**
     * EventIteratorCollection constructor.
     *
     * @param \Iterator $iterator
     */
    public function __construct(\Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * {@inheritdoc}
     *
     * @return Event
     */
    public function current(): Event
    {
        $event = $this->iterator->current();

        if (!$event instanceof Event) {
            throw new InvalidEventException(\sprintf(
                'Event collection only accepts "%s", "%s" given',
                Event::class,
                \is_object($event) ? \get_class($event) : \gettype($event)
            ));
        }

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        $this->iterator->next();
    }

    /**
     * {@inheritdoc}
     *
     * @return string|int|null
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->iterator->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        if ($this->iterator instanceof \EmptyIterator) {
            return 0;
        }

        if ($this->iterator instanceof \Countable) {
            return $this->iterator->count();
        }

        $currentKey = $this->iterator->key();
        $this->iterator->rewind();

        $count = 0;
        while ($this->iterator->valid()) {
            $count++;

            $this->iterator->next();
        }

        $this->iterator->rewind();
        while ($this->iterator->key() !== $currentKey) {
            $this->iterator->next();
        }

        return $count;
    }
}
