<?php

use WikiChartGenerator\Chart;
use WikiChartGenerator\TableGenerator;

class RunTest extends \PHPUnit\Framework\TestCase
{
    public function testInvalidUrl()
    {
        $this->expectException(\WikiChartGenerator\Exceptions\InvalidURLException::class);
        $tableGenerator = new TableGenerator('https://google.com');
        $tableGenerator->generateTables();
    }

    public function testRunWithExampleTable()
    {
        $tableGenerator = new TableGenerator(
            'https://en.wikipedia.org/wiki/Women%27s_high_jump_world_record_progression'
        );

        $tables = $tableGenerator->generateTables();
        // There is only one valid table
        $this->assertEquals(sizeof($tables), 1);

        foreach ($tables as $i => $table) {
            $chart = new Chart($table);
            $path = $chart->generateChartAsPng();
            $this->assertStringContainsString('outputs/chart_', $path);
        }
    }

    /*
     * Many other tests should be written. But if I assure the chart is
     * generated for the given table, I know that most of my code works.
     */
}