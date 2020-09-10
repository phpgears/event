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

namespace Gears\Event\Time;

/**
 * Fixed date time provider.
 */
final class FixedTimeProvider implements TimeProvider
{
    /**
     * Fixed date.
     *
     * @var \DateTimeImmutable
     */
    private $fixedTime;

    /**
     * FixedTimeProvider constructor.
     *
     * @param \DateTimeInterface $fixedTime
     */
    public function __construct(\DateTimeInterface $fixedTime)
    {
        $this->setCurrentTime($fixedTime);
    }

    /**
     * Set fixed date.
     *
     * @param \DateTimeInterface $fixedTime
     */
    public function setCurrentTime(\DateTimeInterface $fixedTime): void
    {
        /** @var \DateTime|\DateTimeImmutable $fixedTime */
        if ($fixedTime instanceof \DateTime) {
            $fixedTime = \DateTimeImmutable::createFromMutable($fixedTime);
        }

        $this->fixedTime = $fixedTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTime(): \DateTimeImmutable
    {
        return $this->fixedTime;
    }
}
