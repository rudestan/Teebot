<?php

namespace Teebot\Configuration;

use Teebot\Configuration\ValueObject\EventConfig;

class Container extends AbstractContainer
{
    const ENV_PREFIX = 'TEEBOT__';

    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->values['events'] = $this->hydrateEventConfigItems($this->values['events']);
    }

    /**
     * Creates an event configuration item value objects from plain arrays
     *
     * @param array $events
     *
     * @return array
     */
    protected function hydrateEventConfigItems(array $events)
    {
        $hydratedEvents = [];

        foreach ($events as $event) {
            $hydratedEvents[] = new EventConfig($event);
        }

        return $hydratedEvents;
    }
}
