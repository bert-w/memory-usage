<?php

namespace BertW\MemoryUsage;

enum Meminfo: string
{
    case MemTotal = 'MemTotal';
    case MemFree = 'MemFree';
    case MemAvailable = 'MemAvailable';
    case Buffers = 'Buffers';
    case Cached = 'Cached';
    case SwapCached = 'SwapCached';
    case Active = 'Active';
    case Inactive = 'Inactive';
    case ActiveAnon = 'Active(anon)';
    case InactiveAnon = 'Inactive(anon)';
    case ActiveFfile = 'Active(file)';
    case InactiveFile = 'Inactive(file)';
    case Unevictable = 'Unevictable';
    case Mlocked = 'Mlocked';
    case SwapTotal = 'SwapTotal';
    case SwapFree = 'SwapFree';
    case Dirty = 'Dirty';
    case Writeback = 'Writeback';
    case AnonPages = 'AnonPages';
    case Mapped = 'Mapped';
    case Shmem = 'Shmem';
    case KReclaimable = 'KReclaimable';
    case Slab = 'Slab';
    case SReclaimable = 'SReclaimable';
    case SUnreclaim = 'SUnreclaim';
    case KernelStack = 'KernelStack';
    case PageTables = 'PageTables';
    case NFSUnstable = 'NFS_Unstable';
    case Bounce = 'Bounce';
    case WritebackTmp = 'WritebackTmp';
    case CommitLimit = 'CommitLimit';
    case CommittedAS = 'Committed_AS';
    case VmallocTotal = 'VmallocTotal';
    case VmallocUsed = 'VmallocUsed';
    case VmallocChunk = 'VmallocChunk';
    case Percpu = 'Percpu';
    case HardwareCorrupted = 'HardwareCorrupted';
    case AnonHugePages = 'AnonHugePages';
    case ShmemHugePages = 'ShmemHugePages';
    case ShmemPmdMapped = 'ShmemPmdMapped';
    case CmaTotal = 'CmaTotal';
    case CmaFree = 'CmaFree';
    case HugePagesTotal = 'HugePages_Total';
    case HugePagesFree = 'HugePages_Free';
    case HugePagesRsvd = 'HugePages_Rsvd';
    case HugePagesSurp = 'HugePages_Surp';
    case Hugepagesize = 'Hugepagesize';
    case DirectMap4k = 'DirectMap4k';
    case DirectMap2M = 'DirectMap2M';
    case DirectMap1G = 'DirectMap1G';
}