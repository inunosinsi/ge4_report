<?php

require __DIR__."/vendor/autoload.php";
//use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\Client\AlphaAnalyticsDataClient;
use Google\Analytics\Data\V1alpha\RunFunnelReportRequest;
use Google\Analytics\Data\V1alpha\RunFunnelReportResponse;
use Google\Analytics\Data\V1alpha\DateRange;
use Google\Analytics\Data\V1alpha\Dimension;
use Google\Analytics\Data\V1alpha\Funnel;
use Google\Analytics\Data\V1alpha\FunnelStep;
use Google\Analytics\Data\V1alpha\FunnelBreakdown;
use Google\Analytics\Data\V1alpha\FunnelEventFilter;
use Google\Analytics\Data\V1alpha\FunnelFieldFilter;
use Google\Analytics\Data\V1alpha\FunnelFilterExpression;
use Google\Analytics\Data\V1alpha\FunnelFilterExpressionList;
use Google\Analytics\Data\V1alpha\StringFilter;
use Google\Analytics\Data\V1alpha\StringFilter\MatchType;
//use Google\Analytics\Data\V1beta\RunFunnelReportRequest;

include_once(__DIR__."/config.php");

putenv("GOOGLE_APPLICATION_CREDENTIALS=".__DIR__."/json/".CREDENTIALS.".json");
$client = new AlphaAnalyticsDataClient();

// Create the funnel report request.
/**
 *
 * ・デフォルト・チャネルグループ
 * ・参照元/メディア
 * ・イベント名
 * ・ランディングページ
 * ・ページパスとスクリーンクラス
 */
$request = (new RunFunnelReportRequest())
    ->setProperty('properties/' . PROPERTY_ID)
    ->setDateRanges([
        new DateRange([
            'start_date' => '30daysAgo',
            'end_date' => 'today',
        ]),
    ])
    ->setFunnelBreakdown(
        new FunnelBreakdown([
            'breakdown_dimension' =>
                new Dimension([
                    'name' => 'defaultChannelGroup'
                ])
                /**
                new Dimension([
	                'name' => 'sourceMedium'
                ])
                **/
        ])
    )
    ->setFunnel(new Funnel());

// Add funnel steps to the funnel.

// 1. Add first open/visit step.
$request->getFunnel()->getSteps()[] = new FunnelStep([
    'name' => 'First open/visit',
    'filter_expression' => new FunnelFilterExpression([
        'or_group' => new FunnelFilterExpressionList([
            'expressions' => [
                new FunnelFilterExpression([
                    'funnel_event_filter' => new FunnelEventFilter([
                        'event_name' => 'first_open',
                    ])
                ]),
                new FunnelFilterExpression([
                    'funnel_event_filter' => new FunnelEventFilter([
                        'event_name' => 'first_visit'
                    ])
                ])
            ]
        ])
    ])
]);

/** 2. Add organic visitors step.
$request->getFunnel()->getSteps()[] = new FunnelStep([
    'name' => 'Organic visitors',
    'filter_expression' => new FunnelFilterExpression([
        'funnel_field_filter' => new FunnelFieldFilter([
            'field_name' => 'firstUserMedium',
            'string_filter' => new StringFilter([
                'match_type' => MatchType::CONTAINS,
                'case_sensitive' => false,
                'value' => 'organic',
            ])
        ])
    ])
]);
**/

/** 3. Add session start step.
$request->getFunnel()->getSteps()[] = new FunnelStep([
    'name' => 'Session start',
    'filter_expression' => new FunnelFilterExpression([
        'funnel_event_filter' => new FunnelEventFilter([
            'event_name' => 'session_start',
        ])
    ])
]);
**/

/** 4. Add screen/page view step.
$request->getFunnel()->getSteps()[] = new FunnelStep([
    'name' => 'Screen/Page view',
    'filter_expression' => new FunnelFilterExpression([
        'or_group' => new FunnelFilterExpressionList([
            'expressions' => [
                new FunnelFilterExpression([
                    'funnel_event_filter' => new FunnelEventFilter([
                        'event_name' => 'screen_view',
                    ])
                ]),
                new FunnelFilterExpression([
                    'funnel_event_filter' => new FunnelEventFilter([
                        'event_name' => 'page_view'
                    ])
                ])
            ]
        ])
    ])
]);
**/

/** 5. Add purchase step.
$request->getFunnel()->getSteps()[] = new FunnelStep([
    'name' => 'Purchase',
    'filter_expression' => new FunnelFilterExpression([
        'or_group' => new FunnelFilterExpressionList([
            'expressions' => [
                new FunnelFilterExpression([
                    'funnel_event_filter' => new FunnelEventFilter([
                        'event_name' => 'purchase',
                    ])
                ]),
                new FunnelFilterExpression([
                    'funnel_event_filter' => new FunnelEventFilter([
                        'event_name' => 'in_app_purchase'
                    ])
                ])
            ]
        ])
    ])
]);
**/
$resp = $client->runFunnelReport($request);

var_dump($resp);
