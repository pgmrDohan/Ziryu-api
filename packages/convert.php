<?php
require_once __DIR__ . '/vendor/autoload.php';

use Notion2json\Notion2json;
$pageDataFile=fopen($argv[2],"w") or die("Unabletoopenfile!");
$pageData = json_encode(Notion2json::convert($argv[1]));
fwrite($pageDataFile, $pageData);
fclose($pageDataFile);