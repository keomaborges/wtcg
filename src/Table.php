<?php

namespace WikiChartGenerator;

class Table
{
    /**
     * @var array
     */
    private array $data;
    /**
     * @var array
     */
    private array $header;
    /**
     * @var string|null
     */
    private ?string $title;

    /**
     * Table constructor.
     *
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        $this->data = [];
        $this->header = [];
        $this->title = $title;
    }

    /**
     * Load data from a <table>.
     *
     * @param \DOMElement $table
     */
    public function loadData(\DOMElement $table): void
    {
        $rows = $table->getElementsByTagName('tr');

        foreach ($rows as $i => $row) {
            /*
             * Headers are identified by <th>. Their names are stored.
             */
            $headers = $row->getElementsByTagName('th');
            foreach ($headers as $header) {
                $this->header[] = $header->nodeValue;
            }

            /*
             * Tries to find numeric values from the <td>s. If some match, they
             * are added to the data array. Otherwise, fills with null.
             */
            $this->data[$i] = [];
            $columns = $row->getElementsByTagName('td');
            foreach ($columns as $j => $column) {
                preg_match('!\d+\.*\d*!', $column->nodeValue, $out);
                $this->data[$i][] = $out ? floatval($out[0]) : null;
            }
        }

        /**
         * Cleaner. Removes null elements and columns that does not contain a
         * single numeric value.
         */
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

        /*
         * Refreshes the indexes.
         */
        $this->header = array_values($this->header);
        $this->data = array_values($this->data);
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return sizeof($this->header) > 0 && sizeof($this->data);
    }
}