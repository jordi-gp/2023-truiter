<?php

use App\Services\TwitterDateFormat;
use PHPUnit\Framework\TestCase;

class TwitterDateFormatTest extends TestCase
{
    function testClassIsInstantiable()
    {
        $dateFormat = new TwitterDateFormat();
        $this->assertInstanceOf(TwitterDateFormat::class, $dateFormat);
    }

    function testFormatReturnsSecondsWhenLessThanOneMinute()
    {
        $dateFormat = new TwitterDateFormat();
        $date = new DateTime('2022-12-22 08:30:00');
        $value = $dateFormat->format($date);

    }
}
