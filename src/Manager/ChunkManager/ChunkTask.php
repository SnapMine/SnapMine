<?php

namespace SnapMine\Manager\ChunkManager;

use Amp\Cancellation;
use Amp\Parallel\Worker\Task;
use Amp\Sync\Channel;
use Error;

class ChunkTask implements Task
{
    /** @var resource|null */
    private $handle = null;
    private string $offsetTable;

    public function __construct(
        private readonly string $file,
        private readonly int    $x,
        private readonly int    $z
    )
    {
    }

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
        $this->handle = null;
    }

    public function init(): void
    {
        if (! is_resource($this->handle)) {
            $this->handle = fopen($this->file, 'rb');
            if (!$this->handle) {
                throw new Error("Cannot open: {$this->file}");
            }
        }

        $this->offsetTable = fread($this->handle, 4096);
        if (!$this->offsetTable || strlen($this->offsetTable) < 4096) {
            throw new Error("Invalid region file: $this->file");
        }
    }

    public function run(Channel $channel, Cancellation $cancellation): string|null
    {
        $this->init();

        $i = $this->x + $this->z * 32;
        $entryOffset = $i * 4;

        $offset = unpack(
            'N',
            "\x00" .
            $this->offsetTable[$entryOffset] .
            $this->offsetTable[$entryOffset + 1] .
            $this->offsetTable[$entryOffset + 2]
        )[1];
        $sectors = ord($this->offsetTable[$entryOffset + 3]);

        if ($offset === 0 || $sectors === 0) {
            return null; // empty chunk
        }

        fseek($this->handle, $offset * 4096);
        $lengthData = fread($this->handle, 4);
        if ($lengthData === false || strlen($lengthData) < 4) {
            return null;
        }
        $length = unpack('N', $lengthData)[1];

        $compressionType = ord(fread($this->handle, 1));
        $compressedData = fread($this->handle, $length - 1);

        if ($compressionType === 2 && $compressedData !== false) {
            return $compressedData;
        }

        return null;
    }
}