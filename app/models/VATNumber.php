<?php

require_once __DIR__ . '/VATStatus.php';

class VATNumber
{
    private string $raw;
    public string $corrected = '';
    public VATStatus $status = VATStatus::INVALID;
    public string $reason = '';

    public function __construct(string $raw)
    {
        $this->raw = trim($raw);
        $this->validate();
    }

    private function validate(): void
    {
        if (preg_match('/^IT\d{11}$/', $this->raw)) {
            $this->status = VATStatus::VALID;
        } elseif (preg_match('/^\d{11}$/', $this->raw)) {
            $this->corrected = 'IT' . $this->raw;
            $this->status = VATStatus::CORRECTED;
            $this->reason = 'Missing IT prefix';
        } else {
            $this->reason = 'Invalid format';
        }
    }

    public function getDisplayValue(): string
    {
        return $this->status === VATStatus::CORRECTED ? $this->corrected : $this->raw;
    }
}
