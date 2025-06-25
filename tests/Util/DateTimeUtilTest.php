<?php

namespace ADComponentBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use AscensoDigital\ComponentBundle\Util\DateTimeUtil;

class DateTimeUtilTest extends TestCase
{
    public function testGenerateDateTimeWithFullData()
    {
        $input = [
            'date' => ['year' => 2024, 'month' => 6, 'day' => 22],
            'time' => ['hour' => 14, 'minute' => 5, 'second' => 9]
        ];

        $expected = new \DateTime('2024-06-22 14:05:09');
        $result = DateTimeUtil::generateDateTime($input);

        $this->assertEquals($expected, $result);
    }

    public function testGenerateDateTimeWithoutTime()
    {
        $input = [
            'date' => ['year' => 2023, 'month' => 12, 'day' => 1]
        ];

        $expected = new \DateTime('2023-12-01 00:00:00');
        $result = DateTimeUtil::generateDateTime($input);

        $this->assertEquals($expected, $result);
    }

    public function testGenerateDateTimeWithoutSeconds()
    {
        $input = [
            'date' => ['year' => 2025, 'month' => 1, 'day' => 9],
            'time' => ['hour' => 9, 'minute' => 3]
        ];

        $expected = new \DateTime('2025-01-09 09:03:00');
        $result = DateTimeUtil::generateDateTime($input);

        $this->assertEquals($expected, $result);
    }

    public function testGenerateDateTimeWithSingleDigitPadding()
    {
        $input = [
            'date' => ['year' => 2022, 'month' => 3, 'day' => 8],
            'time' => ['hour' => 2, 'minute' => 4, 'second' => 7]
        ];

        $expected = new \DateTime('2022-03-08 02:04:07');
        $result = DateTimeUtil::generateDateTime($input);

        $this->assertEquals($expected, $result);
    }

    public function testGenerateDateTimeMissingDateThrowsError()
    {
        $this->expectException(\Error::class);
        DateTimeUtil::generateDateTime([]);
    }
}
