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
    exit();
}

echo "\n\n";
echo sprintf('%u valid tables were identified. Now generating chart...', sizeof($tables));

foreach ($tables as $i => $table) {
    $chart = new Chart($table);
    $path = $chart->generateChartAsPng();

    echo "\n\n";
    echo sprintf('Generated chart for table(s) %u at: %s', ($i + 1), $path);
}

echo "\n\n";
echo 'Processing finished. See you!';

exit();