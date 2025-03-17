<?php

require __DIR__."/vendor/autoload.php";
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;

include_once(__DIR__."/config.php");

putenv("GOOGLE_APPLICATION_CREDENTIALS=".__DIR__."/json/".CREDENTIALS.".json");
$client = new BetaAnalyticsDataClient();

$request = new RunReportRequest([
    'property' => 'properties/'.PROPERTY_ID,
    'dateRanges' => [
   		new DateRange([
   			'start_date' => '30daysAgo',
   			'end_date' => 'today',
   		]),
   	],
   
   	'dimensions' => [
   		new Dimension(['name' => "defaultChannelGroup"])
   	],
   	'metrics' => [
   		new Metric(['name' => "keyEvents"])
   	]
]);

$res = $client->runReport($request);
var_dump($res);
