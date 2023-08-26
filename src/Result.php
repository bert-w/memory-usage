<?php

namespace BertW\MemoryUsage;

class Result
{
    protected const UNITS = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB'];

    public function __construct(
        protected float $value, protected string $unit = 'B'
    )
    {
        if (!in_array($unit, static::UNITS)) {
            throw new ResultException('Unknown unit "' . $unit . '".');
        }
    }

    public static function make(float $value, string $unit = 'B'): static
    {
        return new static($value, $unit);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString($decimals = 2, $separator = ' ', $suffix = true): string
    {
        return round($this->value, $decimals) . $separator . ($suffix ? $this->unit : '');
    }

    public function to($unit): static
    {
        return static::make(
            static::convert($this->value, $this->unit, $unit),
            $unit,
        );
    }

    public function value(): float
    {
        return $this->value;
    }

    public function unit(): float
    {
        return $this->unit;
    }

    /**
     * Converts one unit value to another.
     * @throws \BertW\MemoryUsage\ResultException
     */
    protected static function convert(float $value, string $from, string $to): float
    {
        $fromIndex = array_search($from, static::UNITS);
        $toIndex = array_search($to, static::UNITS);

        if ($fromIndex === false) {
            throw new ResultException('Cannot convert to unknown unit "' . $from . '".');
        }

        if ($toIndex === false) {
            throw new ResultException('Cannot convert to unknown unit "' . $to . '".');
        }

        return $value * pow(1024, $fromIndex - $toIndex);
    }
}