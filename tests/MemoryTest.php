<?php

namespace BertW\MemoryUsage\Test;

use BertW\MemoryUsage\MemoryUsage;
use PHPUnit\Framework\TestCase;

class MemoryTest extends TestCase
{
    public function testGeneralCalculations(): void
    {
        $m = $this->mock('meminfo_2gb.txt');

        $this->assertEquals(1871620, $m->totalUsedMemory()->value());
        $this->assertEquals('1.78 GB', (string)$m->totalUsedMemory()->to('GB'));
        $this->assertEquals(1235784, $m->usedMemory()->value());
        $this->assertEquals(605056, $m->cacheMemory()->value());
        $this->assertEquals(30780, $m->bufferMemory()->value());

        $this->assertEquals('1.18 GB / 1.95 GB', $m->usedMemory()->to('GB') . ' / ' . $m->totalMemory()->to('GB'));
    }

    /**
     * @dataProvider provideUsage
     */
    public function testUsage($file, $expected): void
    {
        $m = $this->mock($file);

        $this->assertEquals($expected, $m->usedMemory()->to('GB') . ' / ' . $m->totalMemory()->to('GB'));
    }

    public static function provideUsage(): array
    {
        return [
            ['meminfo_2gb.txt', '1.18 GB / 1.95 GB'],
            ['meminfo_4gb.txt', '1.06 GB / 3.82 GB'],
            ['meminfo_8gb.txt', '3.32 GB / 7.77 GB'],
        ];
    }

    protected function mock($file): MemoryUsage
    {
        $m = \Mockery::mock(MemoryUsage::class)->makePartial();
        $m->shouldAllowMockingProtectedMethods();
        // Load fixture file.
        $file = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . $file, 'r');
        $m->shouldReceive('file')->andReturn($file);

        return $m;
    }
}