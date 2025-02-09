<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Trade as TradeResource;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TradesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Trade::query()->with(['launchpad']);
        if (!empty($keyword)) {
            $query->where('txid', 'LIKE', "%$keyword%")
                ->orWhere('address', 'LIKE', "%$keyword%")
                ->orWhere('qty', 'LIKE', "%$keyword%")
                ->orWhere('amount', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhereHas('launchpad', function (Builder $query) use ($keyword) {
                    $query->where('contract', 'LIKE', "%$keyword%")
                        ->orWhere('token', 'LIKE', "%$keyword%")
                        ->orWhere('name', 'LIKE', "%$keyword%")
                        ->orWhere('symbol', 'LIKE', "%$keyword%")
                        ->orWhere('description', 'LIKE', "%$keyword%");
                })
            ;
        }
        $tradesItems = $query->latest()->paginate($perPage);
        $trades = TradeResource::collection($tradesItems);
        return Inertia::render('Admin/Trades/Index', compact('trades'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Trade $trade)
    {
        $trade->delete();
        return back()->with('success', 'Trade deleted!');
    }
}
