<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Uploads;
use App\Enums\MsgStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Msg as MsgResource;
use App\Models\Msg;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MsgsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = Msg::query()->with(['user', 'launchpad']);
        if (!empty($keyword)) {
            $query->where('message', 'LIKE', "%$keyword%");
        }
        $msgsItems = $query->latest()->paginate($perPage);
        $msgs = MsgResource::collection($msgsItems);
        return Inertia::render('Admin/Msgs/Index', [
            'msgs' => $msgs,
            'statuses' => MsgStatus::cases(),
        ]);
    }



    /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function status(Request $request, Msg $msg, MsgStatus $status)
    {
        $msg->status = $status;
        $msg->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Msg $msg)
    {
        $msg->delete();
        return back();
    }
}
