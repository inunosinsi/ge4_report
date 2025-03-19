<?php
/****************************************************************************************/
/* https://developers.google.com/analytics/devguides/reporting/data/v1/api-schema?hl=ja */
/****************************************************************************************/

require __DIR__."/vendor/autoload.php";
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;

include_once(__DIR__."/config.php");

putenv("GOOGLE_APPLICATION_CREDENTIALS=".__DIR__."/json/".CREDENTIALS.".json");
$client = new BetaAnalyticsDataClient();

$request = (new RunReportRequest())
        ->setProperty('properties/' . PROPERTY_ID)
        ->setDateRanges([
            new DateRange([
                'start_date' => '2024-09-01',
                'end_date' => '2024-09-15',
            ]),
        ])
        ->setDimensions([
            new Dimension([
                'name' => 'defaultChannelGroup',
            ]),
            new Dimension([
            	'name' => 'sourceMedium',
            ]),
            new Dimension([
            	'name' => 'eventName'
            ]),
            new Dimension([
            	'name' => 'landingPage'
            ]),
            new Dimension([
            	'name' => 'unifiedPagePathScreen'	
            ])
        ])
        ->setMetrics([
            new Metric([
                'name' => 'keyEvents',
            ]),
            new Metric([
            	'name' => 'sessions',
            ]),
            new Metric([
            	'name' => 'totalUsers'
            ])
        ]);

$res = $client->runReport($request);
var_dump($res);
