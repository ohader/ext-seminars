<?php

declare(strict_types=1);

namespace OliverKlee\Seminars\Domain\Model\Event;

/**
 * This class represents a date for an event that has an association to a topic.
 */
class EventDate extends Event
{
    use EventTrait;

    /**
     * @var \OliverKlee\Seminars\Domain\Model\Event\EventTopic|null
     */
    protected $topic;

    public function getTopic(): ?EventTopic
    {
        return $this->topic;
    }

    public function setTopic(EventTopic $topic): void
    {
        $this->topic = $topic;
    }
}
