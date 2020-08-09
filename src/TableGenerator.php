<?php

namespace WikiChartGenerator;

use WikiChartGenerator\Exceptions\InvalidURLException;

class TableGenerator
{
    private string $url;
    private array $tables;

    /**
     * TableGenerator constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function generateTables(): array {
        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new InvalidURLException('Invalid URL.');
        }

        if (parse_url($this->url, PHP_URL_HOST) !== 'en.wikipedia.org') {
            throw new InvalidURLException('The given URL is not a Wikipedia page.');
        }

        $dom = new \DOMDocument();

        $dom->loadHTMLFile($this->url, LIBXML_NOWARNING | LIBXML_NOERROR);

        $dom->preserveWhiteSpace = false;
        $domTables = $dom->getElementsByTagName('table');

        foreach ($domTables as $domTable) {
            $table = new Table();
            $table->loadData($domTable);
            $this->tables[] = $table;
        }

        return $this->tables;
    }

    public function getTables()
    {
        return $this->tables;
    }
}