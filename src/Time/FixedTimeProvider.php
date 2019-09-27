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
     * @var \DateTimeZone
     */
    private $timeZone;

    /**
     * FixedTimeProvider constructor.
     *
     * @param \DateTimeInterface $fixedTime
     * @param \DateTimeZone|null $timeZone
     */
    public function __construct(\DateTimeInterface $fixedTime, ?\DateTimeZone $timeZone = null)
    {
        $this->timeZone = $timeZone ?? new \DateTimeZone('UTC');

        $this->setCurrentTime($fixedTime);
    }

    /**
     * Set fixed date.
     *
     * @param \DateTimeInterface $fixedTime
     */
    public function setCurrentTime(\DateTimeInterface $fixedTime): void
    {
        if ($fixedTime instanceof \DateTime) {
            $fixedTime = \DateTimeImmutable::createFromMutable($fixedTime);
        }
        $this->fixedTime = $fixedTime->setTimezone($this->timeZone);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTime(): \DateTimeImmutable
    {
        return $this->fixedTime;
    }
}
