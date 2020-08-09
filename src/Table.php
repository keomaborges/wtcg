<?php

namespace WikiChartGenerator;

use WikiChartGenerator\Exceptions\InvalidURLException;

class Table
{
    private array $data;
    private array $header;
    private ?string $title;

    public function __construct(?string $title = null)
    {
        $this->data = [];
        $this->header = [];
        $this->title = $title;
    }

    public function loadData(\DOMElement $table): void
    {
        $rows = $table->getElementsByTagName('tr');

        foreach ($rows as $i => $row) {
            $headers = $row->getElementsByTagName('th');
            foreach ($headers as $header) {
                $this->header[] = $header->nodeValue;
            }

            $this->data[$i] = [];

            $columns = $row->getElementsByTagName('td');
            foreach ($columns as $j => $column) {
                preg_match('!\d+\.*\d*!', $column->nodeValue, $out);
                $this->data[$i][] = $out ? floatval($out[0]) : null;
            }
        }

        foreach ($this->header as $column => $header) {
            $removedCounter = 0;
            foreach ($this->data as $r => $row) {
                if (sizeof($row) != sizeof($this->header)) {
                    unset($this->data[$r]);
                    continue;
                }

                if (!is_numeric($row[$column])) {
                    $removedCounter++;
                }
            }

            if ($removedCounter === sizeof($this->data)) {
                foreach ($this->data as $r => $row) {
                    unset($this->data[$r][$column]);
                }
                unset($this->header[$column]);
            }
        }

        $this->header = array_values($this->header);
        $this->data = array_values($this->data);

        /* Removes non-numeric columns*/
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function isValid(): bool
    {
        return sizeof($this->header) > 0 && sizeof($this->data);
    }
}