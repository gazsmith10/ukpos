<?php

namespace App\Classes;

use League\Csv\Reader;

class CsvParser
{
    public static function parse($filePath)
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = [];
        foreach ($csv as $record) {
            $records[] = $record;
        }
        return $records;
    }
}
