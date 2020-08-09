<?php

require_once 'vendor/autoload.php';

use WikiChartGenerator\Chart;
use WikiChartGenerator\Table;
use WikiChartGenerator\TableGenerator;

echo "\n\n";
echo 'Welcome to the Wikipedia Table Chart Generator by Keoma';
echo "\n\n";
echo 'Inform the Wikipedia table url: ';
//$url = readline();
$url = 'https://en.wikipedia.org/wiki/Women%27s_high_jump_world_record_progression';

$tableGenerator = new TableGenerator($url);

try {
    $tables = $tableGenerator->generateTables();
} catch (\Exception $exception) {
    echo $exception->getMessage();
}

echo "\n\n";
echo sprintf('%u tables were identified. Now generating chart...', sizeof($tables));

/*$data = $table->getData();
$chart = new Chart($data);

try {
    $path = $chart->generateChartAsPng();
} catch (\Exception $exception) {
    echo $exception->getMessage();
}*/

echo "\n\n";
//echo sprintf('Chart generated successfully at %s', $path);
echo "\n\n";
exit();