<?php

namespace App\Http\Controllers;

use App\Enums\TradeType;
use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Models\Launchpad;
use App\Models\Rate;
use App\Services\CandleService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Enum;

class TradesController extends Controller
{

    protected $candleService;

    public function __construct(CandleService $candleService)
    {
        $this->candleService = $candleService;
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'launchpad_id' => ['required', 'integer', 'exists:launchpads,id'],
            'address' => ['required', 'string'],
            'qty' => ['required', 'string'],
            'txid' => ['required', 'string'],
            'amount' => ['required', 'string'],
            'type' => ['required', 'string', 'max:255', new Enum(TradeType::class)],
        ]);
        $trade = Trade::where('txid', $request->txid)->firstOrNew();
        $user = $request->user();
        //if user in not current silently discard
        if (strtolower($user->address) != strtolower($request->address)) return back();
        $trade->launchpad_id = $request->launchpad_id;
        $trade->txid = $request->txid;
        $trade->address = $request->address;
        $trade->qty = $request->qty;
        $trade->amount = $request->amount;
        $trade->type = $request->type;
        $trade->save();
        $launchpad = $trade->launchpad()->first();
        $rate = Rate::where('chainId', $launchpad->chainId)->first();
        if ($rate) {
            $trade->usd = $request->amount * $rate->usd_rate;
            $trade->save();
        }

        return back();
    }


    /**
     * Get OHLCV candles for TradingView chart
     */
    public function getCandles(Request $request, Launchpad $launchpad): JsonResponse
    {
        $request->validate([
            'timeframe' => 'required|string',
            'from' => 'required|integer',
            'to' => 'required|integer',
        ]);
        $from = Carbon::createFromTimestamp($request->from);
        $to = Carbon::createFromTimestamp($request->to);
        $candles = $this->candleService->getCandles(
            $launchpad,
            $request->timeframe,
            $from,
            $to
        );
        return response()->json($candles);
    }
}
