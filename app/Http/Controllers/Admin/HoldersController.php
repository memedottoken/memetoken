<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Holder as HolderResource;
use App\Models\Holder;
use Inertia\Inertia;

use Illuminate\Http\Request;

class HoldersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Holder::query()->with(['launchpad', 'user']);
        if (!empty($keyword)) {
            $query->where('launchpad_id', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->orWhere('address', 'LIKE', "%$keyword%")
                ->orWhere('qty', 'LIKE', "%$keyword%")
                ->orWhere('prebond', 'LIKE', "%$keyword%");
        }
        $holdersItems = $query->latest()->paginate($perPage);
        $holders = HolderResource::collection($holdersItems);
        return Inertia::render('Holders/Index', compact('holders'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Holders/Create');
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'address' => ['required', 'string'],
            'qty' => ['required', 'string'],
            'prebond' => ['nullable', 'boolean'],
        ]);
        $holder = new Holder;
        $holder->launchpad_id = $request->launchpad_id;
        $holder->user_id = $request->user_id;
        $holder->address = $request->address;
        $holder->qty = $request->qty;
        $holder->prebond = $request->prebond;
        $holder->save();

        return redirect()->route('holders.index')->with('success', 'Holder added!');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Holder $holder)
    {
        $holder->load(['launchpad', 'user']);
        return Inertia::render('Holders/Show', [
            'holder' => new HolderResource($holder)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Holder $holder)
    {
        $holder->load(['launchpad', 'user']);
        return Inertia::render('Holders/Edit', [
            'holder' => new HolderResource($holder)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Holder $holder)
    {
        $request->validate([
            'launchpad_id' => ['required', 'integer', 'exists:launchpads,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'address' => ['required', 'string'],
            'qty' => ['required', 'string'],
            'prebond' => ['nullable', 'boolean'],
        ]);

        $holder->launchpad_id = $request->launchpad_id;
        $holder->user_id = $request->user_id;
        $holder->address = $request->address;
        $holder->qty = $request->qty;
        $holder->prebond = $request->prebond;
        $holder->save();
        return back()->with('success', 'Holder updated!');
    }

    /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle(Request $request, Holder $holder)
    {
        $holder->active = !$holder->active;
        $holder->save();
        return back()->with('success', $holder->active ? __(' :name Holder Enabled !', ['name' => $holder->name]) : __(' :name  Holder Disabled!', ['name' => $holder->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Holder $holder)
    {
        $holder->delete();
        return redirect()->route('holders.index')->with('success', 'Holder deleted!');
    }
}
