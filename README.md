# bert-w/memory-usage
[![Latest Stable Version](https://poser.pugx.org/bert-w/memory-usage/v/stable)](https://packagist.org/packages/bert-w/memory-usage)
[![Total Downloads](https://poser.pugx.org/bert-w/memory-usage/downloads)](https://packagist.org/packages/bert-w/memory-usage)
[![License](https://poser.pugx.org/bert-w/memory-usage/license)](https://packagist.org/packages/bert-w/memory-usage)

Receive information about the current memory usage on your unix machine, similar to the calculations in `htop`.

### Installation instructions
`composer require bert-w/memory-usage`

This package is only compatible with unix-like systems. It requires read permissions to the file `/proc/meminfo` which
contains details about the memory usage on the system.

### Quick start
Get the current memory usage of your system:
```php
$memory = new \BertW\MemoryUsage\MemoryUsage();

$usage = $memory->usedMemory() . ' / ' . $memory->totalMemory();
// Result: "1235784 kB / 2040948 kB"
```
Results are in `kB` (kilobyte) format by default. They can be converted using the `->to()` function which accepts
a conversion unit like `'B'`, `'kB'`, `'MB'`, `'GB'`, `'TB'`, `'PB'` or `'EB'`. A handy `__toString()` is included
which outputs the value and the unit name:
```php

$usage = $memory->usedMemory()->to('GB') . ' / ' . $memory->totalMemory()->to('GB');
// Result: "3.32 GB / 7.77 GB"
```

#### Function list
```php
(new \BertW\MemoryUsage\MemoryUsage)->usedMemory();
(new \BertW\MemoryUsage\MemoryUsage)->totalUsedMemory();
(new \BertW\MemoryUsage\MemoryUsage)->totalMemory();
(new \BertW\MemoryUsage\MemoryUsage)->cacheMemory();
(new \BertW\MemoryUsage\MemoryUsage)->nonCacheMemory();
(new \BertW\MemoryUsage\MemoryUsage)->swapMemory();
(new \BertW\MemoryUsage\MemoryUsage)->bufferMemory();

(new \BertW\MemoryUsage\MemoryUsage)->meminfo();
// Returns Array<string, int> with parsed `/proc/meminfo` content (in kilobytes).

(new \BertW\MemoryUsage\MemoryUsage)->get(\BertW\MemoryUsage\Meminfo::Buffers);
(new \BertW\MemoryUsage\MemoryUsage)->get('Buffers');
// Retrieve any value from the `/proc/meminfo` file. Accepts strings and Enums.
```

