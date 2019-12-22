<?php

namespace App\Http\Controllers;

use App\Quote;
use App\QuoteMeta;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        $quote = new Quote;

        $quote_meta = [
        new QuoteMeta(['key' => 'collection', 'value' => json_encode($request->collection)]),
        new QuoteMeta(['key' => 'delivery', 'value' => json_encode($request->delivery)]),
        new QuoteMeta(['key' => 'waypoints', 'value' => json_encode($request->waypoints)]),
        new QuoteMeta(['key' => 'movingDate', 'value' => $request->movingDate]),
        new QuoteMeta(['key' => 'vanSize', 'value' => $request->vanSize]),
        new QuoteMeta(['key' => 'customerInfoName', 'value' => $request->customerInfoName]),
        new QuoteMeta(['key' => 'customerInfoEmail', 'value' => $request->customerInfoEmail]),
        new QuoteMeta(['key' => 'customerInfoPhone', 'value' => $request->customerInfoPhone]),
        new QuoteMeta(['key' => 'notification', 'value' => $request->notification]),
        new QuoteMeta(['key' => 'helpersRequired', 'value' => $request->helpersRequired]),
        new QuoteMeta(['key' => 'description', 'value' => $request->description]),
        new QuoteMeta(['key' => 'loadingUnloadingTime', 'value' => $request->loadingUnloadingTime]),
        new QuoteMeta(['key' => 'travelTime', 'value' => $request->travelTime]),
        new QuoteMeta(['key' => 'totalTime', 'value' => $request->totalTime]),
        new QuoteMeta(['key' => 'milesDriven', 'value' => round($request->milesDriven,2)]),
        new QuoteMeta(['key' => 'stairsTime', 'value' => $request->stairsTime]),
        new QuoteMeta(['key' => 'estimatedTotalTime', 'value' => $request->estimatedTotalTime]),
        ];
        $quote->save();
        $quote->metas()->saveMany($quote_meta);
        
        return 'Success stored quotes';

    }
}
