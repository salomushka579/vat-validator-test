<?php

class FileHandler
{
    public static function writeCSV(string $filename, array $vatObjects): void
    {
        $fp = fopen($filename, 'wb');
        foreach ($vatObjects as $vat) {
            fputcsv($fp, [$vat->getDisplayValue(), $vat->status->value, $vat->reason]);
        }
        fclose($fp);
    }
}
