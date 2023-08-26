<?php

namespace BertW\MemoryUsage\Test;

use BertW\MemoryUsage\ResultException;
use BertW\MemoryUsage\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    /**
     * @dataProvider provideConvertInputs
     */
    public function testConvertInputs($inputValue, $inputUnit, $outputValue, $outputUnit): void
    {
        $result = Result::make($inputValue, $inputUnit);

        $this->assertEquals($outputValue, round($result->to($outputUnit)->value(), 2));
    }

    public static function provideConvertInputs(): array
    {
        // Values are rounded to 2 decimals.
        return [
            [0, 'B', 0, 'B'],
            [1024, 'B', 1, 'kB'],
            [45884123, 'B', 43.76, 'MB'],
            [0, 'B', 0, 'GB'],
            [1024, 'kB', 1048576, 'B'],
            [417720, 'kB', 407.93, 'MB'],
            [1, 'kB', 0, 'TB'],
            [5.2, 'GB', 5583457484.8, 'B'],
            [459.61, 'GB', 0.45, 'TB'],
        ];
    }

    public function testInvalidConstruction(): void
    {
        $this->expectException(ResultException::class);

        Result::make(5.25, 'xxB');
    }

    public function testInvalidConversion(): void
    {
        $result = Result::make(5, 'kB');

        $this->expectException(ResultException::class);

        $converted = $result->to('xxB');

    }
}