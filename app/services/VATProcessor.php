<?php

require_once __DIR__ . '/../models/VATNumber.php';

class VATProcessor
{
    private array $valid = [], $corrected = [], $invalid = [];

    public function processCSV(string $path): void
    {
        $rows = array_map('str_getcsv', file($path));
        foreach ($rows as $row) {
            $vat = new VATNumber($row[1]);
            match ($vat->status) {
                VATStatus::VALID => $this->valid[] = $vat,
                VATStatus::CORRECTED => $this->corrected[] = $vat,
                VATStatus::INVALID => $this->invalid[] = $vat,
            };
        }
    }

    public function getResults(): array
    {
        return [$this->valid, $this->corrected, $this->invalid];
    }
}
