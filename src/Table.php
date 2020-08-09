<?php

namespace WikiChartGenerator;

use WikiChartGenerator\Exceptions\InvalidURLException;

class Table
{
    private array $data;
    private array $header;

    public function __construct() {
        $this->data = [];
        $this->header = [];
    }

    public function loadData(\DOMElement $table): void
    {
        $rows = $table->getElementsByTagName('tr');

        foreach ($rows as $i => $row) {
            $headers = $row->getElementsByTagName('th');
            foreach ($headers as $header) {
                $this->header[] = [
                    'name' => $header->nodeValue,
                    'isDate' => in_array(
                        strtolower(trim($header->nodeValue)),
                        ['date', 'time', 'day', 'date time']
                    ),
                ];
            }

            $this->data[$i] = [];

            $columns = $row->getElementsByTagName('td');
            foreach ($columns as $j => $column) {
                if ($this->header[$j]['isDate']) {
                    $this->data[$i][] = strtotime($column->nodeValue);
                } else {
                    preg_match('!\d+\.*\d*!', $column->nodeValue, $out);
                    $this->data[$i][] = $out ? $out[0] : null;
                }
            }
        }
    }

    public function getData(): array
    {
        return $this->data;
    }
}