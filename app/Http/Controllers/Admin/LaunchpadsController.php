<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Launchpad as LaunchpadResource;
use App\Models\Launchpad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaunchpadsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Launchpad::query()->with(['factory', 'user', 'trades', 'msgs', 'uploads']);
        if (!empty($keyword)) {
            $query->where('contract', 'LIKE', "%$keyword%")
                ->orWhere('token', 'LIKE', "%$keyword%")
                ->orWhere('name', 'LIKE', "%$keyword%")
                ->orWhere('symbol', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
            ;
        }
        $launchpadsItems = $query->latest()->paginate($perPage);
        $launchpads = LaunchpadResource::collection($launchpadsItems);
        return Inertia::render('Admin/Launchpads/Index', compact('launchpads'));
    }


    /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle(Request $request, Launchpad $launchpad)
    {
        $launchpad->active = !$launchpad->active;
        $launchpad->save();
        return back()->with('success', $launchpad->active ? __(' :name Launchpad Enabled !', ['name' => $launchpad->name]) : __(' :name  Launchpad Disabled!', ['name' => $launchpad->name]));
    }

    /**
     * toggle featured status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function featured(Request $request, Launchpad $launchpad)
    {
        $launchpad->featured = !$launchpad->featured;
        $launchpad->save();
        return back()->with('success', $launchpad->featured ? __(' :name Launchpad Enabled !', ['name' => $launchpad->name]) : __(' :name  Launchpad Disabled!', ['name' => $launchpad->name]));
    }


    /**
     * toggle king of the hill status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function kingofthehill(Request $request, Launchpad $launchpad)
    {
        $launchpad->kingofthehill = !$launchpad->kingofthehill;
        $launchpad->save();
        return back()->with('success', $launchpad->kingofthehill ? __(' :name Launchpad Enabled !', ['name' => $launchpad->name]) : __(' :name  Launchpad Disabled!', ['name' => $launchpad->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Launchpad $launchpad)
    {
        $launchpad->delete();
        return back()->with('success', 'Launchpad deleted!');
    }
}
