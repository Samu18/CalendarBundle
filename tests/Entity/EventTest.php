<?php

namespace CalendarBundle\Tests\Entity;

use PhpSpec\ObjectBehavior;
use CalendarBundle\Entity\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    private $title;
    private $start;
    private $end;
    private $options;

    public function setUp(): void
    {
        $this->title = 'Title';
        $this->start = new \DateTime('2019-03-18 08:41:31');
        $this->end = new \DateTime('2019-03-18 08:41:31');
        $this->options = ['textColor' => 'blue'];

        $this->entity = new Event(
            $this->title,
            $this->start,
            $this->end,
            $this->options
        );
    }

    public function testItHasRequireValues()
    {
        $this->assertEquals($this->title, $this->entity->getTitle());
        $this->assertEquals($this->start, $this->entity->getStart());
        $this->assertEquals($this->end, $this->entity->getEnd());
        $this->assertEquals($this->options, $this->entity->getOptions());
    }

    public function testItShouldConvertItsValuesInToArray()
    {
        $url = 'url';
        $urlValue = 'www.url.com';

        $options = [
            $url => $urlValue,
        ];

        $allDay = false;

        $this->entity->setAllDay($allDay);

        $this->entity->addOption('be-removed', 'value');
        $this->entity->removeOption('be-removed');

        $this->assertEquals(null, $this->entity->removeOption('no-found-key'));

        $this->entity->setOptions($options);
        $this->assertEquals($options, $this->entity->getOptions());

        $this->assertEquals($urlValue, $this->entity->getOption($url, $urlValue));

        $this->assertEquals(
            [
                'title' => $this->title,
                'start' => $this->start->format('Y-m-d\\TH:i:sP'),
                'allDay' => $allDay,
                'end' => $this->end->format('Y-m-d\\TH:i:sP'),
                $url => $urlValue,
            ],
            $this->entity->toArray()
        );
    }
}
