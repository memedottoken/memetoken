<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Uploads;
use App\Http\Controllers\Controller;
use App\Http\Resources\Promo as PromoResource;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Promo::query();
        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('image', 'LIKE', "%$keyword%");
        }
        $promosItems = $query->latest()->paginate($perPage);
        $promos = PromoResource::collection($promosItems);
        return Inertia::render('Admin/Promos/Index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Admin/Promos/Create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'image_uri' => ['required', 'string'],
            'image_upload' => ['required', 'boolean'],
            'image_path' => ['nullable', 'required_if:image_upload,true'],
            'url' => ['required', 'url'],
            'starts_at' => ['required', 'string'],
            'ends_at' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);
        $promo = new Promo;
        $promo->name = $request->name;
        $promo->url = $request->url;
        $promo->active = $request->active;
        $promo->starts_at = Carbon::parse($request->starts_at);
        $promo->ends_at = Carbon::parse($request->ends_at);
        $promo->save();
        $upload = app(Uploads::class)->upload($request,  $promo, 'image');
        $promo->image =  $upload->url;
        $promo->save();
        return redirect()->route('admin.promos.index')->with('success', 'Promo added!');
    }


    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Promo $promo)
    {

        return Inertia::render('Admin/Promos/Edit', [
            'promo' => new PromoResource($promo)
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
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'image_uri' => ['nullable', 'required_if:image_upload,true', 'string'],
            'image_upload' => ['required', 'boolean'],
            'image_path' => ['nullable',  'required_if:image_upload,true'],
            'url' => ['required', 'url'],
            'starts_at' => ['required', 'string'],
            'ends_at' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);
        if ($request->image_upload) {
            $upload = app(Uploads::class)->upload($request,  $promo, 'image');
            $promo->image = $upload->url;
        }
        $promo->name = $request->name;
        $promo->url = $request->url;
        $promo->starts_at = Carbon::parse($request->starts_at);
        $promo->ends_at = Carbon::parse($request->ends_at);
        $promo->active = $request->active;
        $promo->save();
        return back()->with('success', 'Promo updated!');
    }

    /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle(Request $request, Promo $promo)
    {
        $promo->active = !$promo->active;
        $promo->save();
        return back()->with('success', $promo->active ? __(' :name Promo Enabled !', ['name' => $promo->name]) : __(' :name  Promo Disabled!', ['name' => $promo->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Promo $promo)
    {
        $promo->delete();
        return back()->with('success', 'Promo deleted!');
    }
}
