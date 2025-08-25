<?php

namespace SnapMine\Block\Type;

use SnapMine\Block\Data\BlockData;
use SnapMine\Block\Data\Powerable;
use SnapMine\Block\Instrument;

class NoteBlock extends BlockData
{
    private Instrument $instrument = Instrument::BELL;
    private int $note = 0;

    use Powerable;

    public function computedId(array $data = []): int
    {
        return parent::computedId([
            'instrument' => $this->instrument,
            'note' => $this->note,
        ]);
    }

    /**
     * @param Instrument $instrument
     */
    public function setInstrument(Instrument $instrument): void
    {
        $this->instrument = $instrument;
    }

    /**
     * @return Instrument
     */
    public function getInstrument(): Instrument
    {
        return $this->instrument;
    }

    /**
     * @param int $note
     */
    public function setNote(int $note): void
    {
        $this->note = $note;
    }

    /**
     * @return int
     */
    public function getNote(): int
    {
        return $this->note;
    }
}