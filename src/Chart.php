<?php

namespace WikiChartGenerator;

class Chart
{
    private array $data;

    /**
     * Chart constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function generateChartAsPng(): string {
        //todo generate
        return 'foo';
    }
}