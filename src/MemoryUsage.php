<?php

namespace BertW\MemoryUsage;

use BackedEnum;

class MemoryUsage
{
    /**
     * Parsed lines from /proc/meminfo.
     * @var array<string, int>
     */
    protected array $meminfo;

    public function __construct()
    {
        //
    }

    public function usedMemory(): Result
    {
        return static::result(
            $this->totalUsedMemory()->value() - ($this->get(Meminfo::Buffers)->value() + $this->cacheMemory()->value())
        );
    }

    public function totalUsedMemory(): Result
    {
        return static::result(
            $this->get(Meminfo::MemTotal)->value() - $this->get(Meminfo::MemFree)->value()
        );
    }

    public function totalMemory(): Result
    {
        return $this->get(Meminfo::MemTotal);
    }

    public function cacheMemory(): Result
    {
        return static::result(
            $this->get(Meminfo::Cached)->value() + $this->get(Meminfo::SReclaimable)->value() - $this->get(Meminfo::Shmem)->value()
        );
    }

    public function nonCacheMemory(): Result
    {
        return static::result(
            $this->totalUsedMemory()->value() - ($this->bufferMemory()->value() + $this->cacheMemory()->value())
        );
    }

    public function swapMemory(): Result
    {
        return static::result(
            $this->get(Meminfo::SwapTotal)->value() - $this->get(Meminfo::SwapFree)->value()
        );
    }

    public function bufferMemory(): Result
    {
        return $this->get(Meminfo::Buffers);
    }

    /**
     * @throws \BertW\MemoryUsage\MeminfoException
     */
    public function get(Meminfo|string $key): Result
    {
        $key = $key instanceof BackedEnum ? $key->value : $key;

        if (!array_key_exists($key, $this->meminfo())) {
            if (PHP_OS_FAMILY === 'Windows') {
                trigger_error('Attempting to call meminfo is not supported for Windows systems.', E_USER_WARNING);
                return static::result(0);
            }
            throw new MeminfoException('Property "' . $key . '" not found in meminfo.');
        }

        return static::result($this->meminfo()[$key]);
    }

    public function meminfo(): array
    {
        if (!isset($this->meminfo)) {
            $meminfo = [];
            $file = $this->file();

            while ($line = fgets($file)) {
                $arr = explode(' ', preg_replace('![\s:]+!', ' ', $line));
                if (!empty(array_filter($arr))) {
                    $meminfo[$arr[0]] = (int)$arr[1];
                }
            }

            $this->meminfo = $meminfo;
        }
        return $this->meminfo;
    }

    protected function file(): mixed
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return '';
        }

        return fopen('/proc/meminfo', 'r');
    }


    protected static function result(float $kB): Result
    {
        return Result::make($kB, 'kB');
    }
}