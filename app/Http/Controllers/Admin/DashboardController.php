<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingRpc;
use App\Http\Controllers\Controller;
use App\Http\Resources\Trade as ResourcesTrade;
use App\Http\Resources\User as ResourcesUser;

use App\Models\Launchpad;
use App\Models\Msg;
use App\Models\Setting;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Inertia\Response;
     */
    public function dashboard(Request $request)
    {
        $users  = User::count();
        $userToday = User::whereDate('created_at', today())->count();
        $trades  = Trade::query()->count();
        $tradesToday = Trade::whereDate('created_at', today())->count();
        $launchpads  = Launchpad::count();
        $launchpadsToday = Launchpad::whereDate('created_at', today())->count();
        $msgs  = Msg::count();
        $msgsToday = Msg::whereDate('created_at', today())->count();
        return Inertia::render('Admin/Dashboard', [
            'setting' => Setting::find(1),
            'rpcs' => collect(SettingRpc::cases())->map(fn(SettingRpc $s) => ['label' => ucfirst($s->value), 'value' => $s->value]),
            'trades' => function () {
                $trades = Trade::query()->with('launchpad')->latest()->take(10)->get();
                return ResourcesTrade::collection($trades);
            },
            'users' => function () {
                $users = User::query()->latest()->take(10)->get();
                return ResourcesUser::collection($users);
            },
            'mail' => [
                'mailer' => config('mail.from'),
                'mailgun' => config('services.mailgun'),
                'smtp' => collect(config('mail.mailers.smtp'))->only([
                    'host',
                    'port',
                    'encryption',
                    'username',
                    'password',
                ])->toArray(),
                'posmark' => config('services.postmark'),
                'mailersend' => config('services.mailersend'),
                'resend' => config('services.resend'),
            ],
            'stats' => [
                [
                    'name' => 'users',
                    'title' => "Registered Users",
                    'subtitle' => "Total Members count",
                    'total' => $users,
                    'today' => $userToday
                ],
                [
                    'name' => 'trades',
                    'title' => "Trades History",
                    'subtitle' => "Lifetime Trades Created",
                    'total' => $trades,
                    'symbol' => 'USD',
                    'today' => $tradesToday
                ],
                [
                    'name' => 'launchpads',
                    'title' => "Launchpads Created",
                    'subtitle' => "Total launchpads Created",
                    'total' => $launchpads,
                    'today' => $launchpadsToday
                ],
                [
                    'name' => 'chat',
                    'title' => 'Live Chat Activity',
                    'subtitle' => "Messages and Chat History",
                    'total' => $msgs,
                    'today' => $msgsToday
                ]
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return \Inertia\Response;
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $query  = User::query()->withCount([
            'launchpads',
            'trades',
            'msgs',
            'holders',
        ]);
        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%");
        }
        $usersItems = $query->latest()->paginate($perPage);
        $users = ResourcesUser::collection($usersItems);
        return Inertia::render('Admin/Users/Index', compact('users'));
    }





    /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function toggle(Request $request, User $user)
    {
        $user->active = !$user->active;
        $user->save();
        return back()->with('success', $user->active ? __(' :name User Enabled !', ['name' => $user->name]) : __(' :name  User Disabled!', ['name' => $user->name]));
    }
    /**
     * toggle status of  the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function banned(Request $request, User $user)
    {
        $user->banned = !$user->banned;
        $user->save();
        return back()->with('success', $user->banned ? __(' :name User Enabled !', ['name' => $user->name]) : __(' :name  User Disabled!', ['name' => $user->name]));
    }
}
