<?php

require_once 'vendor/autoload.php';

use WikiChartGenerator\Chart;
use WikiChartGenerator\TableGenerator;

echo "\n";
echo 'Welcome to the Wikipedia Table Chart Generator by Keoma.';
echo "\n\n";
echo 'Inform the Wikipedia table url: ';
$url = readline();

$tableGenerator = new TableGenerator($url);

try {
    $tables = $tableGenerator->generateTables();
} catch (\Exception $exception) {
    echo $exception->getMessage();
    exit();
}

echo "\n\n";
echo sprintf('%u valid table(s) was(were) identified. Now generating chart(s)...', sizeof($tables));
echo "\n";

foreach ($tables as $i => $table) {
    $chart = new Chart($table);
    try {
        $path = $chart->generateChartAsPng();
        echo "\n";
        echo sprintf('Successfully generated chart for table(s) "%s" at: %s', $table->getTitle(), $path);
    } catch (Exception $exception) {
        echo 'Error when generating chart.';
        echo $exception->getMessage();
    }
}

echo "\n\n";
echo 'Processing finished. See you!';
echo "\n\n";

exit();