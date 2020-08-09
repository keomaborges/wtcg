<?php

namespace WikiChartGenerator;

use CpChart\Data;
use CpChart\Image;

class Chart
{
    /**
     * @var Table
     */
    private Table $table;

    /**
     * Chart constructor.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Generates the chart and returns its path
     *
     * @return string
     * @throws \Exception
     */
    public function generateChartAsPng(): string {
        /*
         * The library throws some exceptions because it is not fully compatible
         * with PHP 7.4. But they can be ignored since the chart is generated.
         */
        error_reporting(E_ERROR);

        /* Create and populate the Data object */
        $data = new Data();

        /*
         * Gets the data from the table
         */
        $tableData = $this->table->getData();
        $tableHeader = $this->table->getHeader();

        foreach ($tableHeader as $j => $header) {
            $points = [];
            foreach ($tableData as $i => $row) {
                $points[] = $row[$j];
            }

            $data->addPoints($points, $header);
        }

        $data->setAxisName(0, "Values");

        /* Create the Image object */
        $image = new Image(700, 230, $data);

        /* Turn off Antialiasing */
        $image->Antialias = false;

        /* Add a border to the picture */
        $image->drawRectangle(0, 0, 699, 229, ["R" => 0, "G" => 0, "B" => 0]);

        /* Write the chart title */
        $image->setFontProperties(["FontSize" => 11]);
        $image->drawText(
            300,
            35,
            $this->table->getTitle(),
            ["FontSize" => 20, "Align" => TEXT_ALIGN_BOTTOMMIDDLE]
        );

        /* Set the default font */
        $image->setFontProperties(["FontSize" => 6]);

        /* Define the chart area */
        $image->setGraphArea(60, 40, 650, 200);

        /* Draw the scale */
        $scaleSettings = [
            "XMargin" => 10,
            "YMargin" => 10,
            "Floating" => true,
            "GridR" => 200,
            "GridG" => 200,
            "GridB" => 200,
            "DrawSubTicks" => true,
            "CycleBackground" => true
        ];
        $image->drawScale($scaleSettings);

        /* Turn on Antialiasing */
        $image->Antialias = true;

        /* Draw the line of best fit */
        $image->drawBestFit();

        /* Turn on shadows */
        $image->setShadow(true, ["X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10]);

        /* Draw the line chart */
        $image->drawPlotChart();

        /* Write the chart legend */
        $image->drawLegend(580, 20, ["Style" => LEGEND_NOBORDER, "Mode" => LEGEND_HORIZONTAL]);

        if (!file_exists('outputs')) {
            mkdir('outputs', 0777, true);
        }

        /* Render the picture (choose the best way) */
        $path = uniqid('outputs/chart_') . '.png';
        $image->autoOutput($path);

        return $path;
    }
}