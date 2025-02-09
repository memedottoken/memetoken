<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Uploads;
use App\Enums\SettingRpc;
use App\Http\Controllers\Controller;
use App\Install\Helpers\EnvHelper;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rules\Enum;

class SettingsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $request->validate([
            'logo_uri' => ['nullable', 'required_if:logo_upload,true', 'string'],
            'logo_upload' => ['required', 'boolean'],
            'logo_path' => ['nullable', 'required_if:logo_upload,true'],
            'name' => ['required', 'string'],
            'twitter' => ['nullable', 'string', 'url'],
            'youtube' => ['nullable', 'string', 'url'],
            'telegram_group' => ['nullable', 'string', 'url'],
            'telegram_channel' => ['nullable', 'string', 'url'],
            'discord' => ['nullable', 'string', 'url'],
            'documentation' => ['nullable', 'string', 'url'],
            'rpc' => ['nullable', 'string',  new Enum(SettingRpc::class)],
            'ankr' => ['nullable', 'string'],
            'infura' => ['nullable', 'string'],
            'blast' => ['nullable', 'string'],
            'chat' => ['nullable', 'boolean'],
            'featured' => ['nullable', 'boolean'],
        ]);
        $setting = Setting::find(1);
        if ($request->logo_upload || $request->logo_uri) {
            $upload = app(Uploads::class)->upload($request,  $setting, 'logo');
            $setting->logo = $upload->url;
        }
        $setting->name = $request->name;
        $setting->twitter = $request->twitter;
        $setting->youtube = $request->youtube;
        $setting->telegram_group = $request->telegram_group;
        $setting->telegram_channel = $request->telegram_channel;
        $setting->discord = $request->discord;
        $setting->documentation = $request->documentation;
        $setting->rpc = $request->rpc;
        $setting->ankr = $request->ankr;
        $setting->infura = $request->infura;
        $setting->blast = $request->blast;
        $setting->chat = $request->chat;
        $setting->featured = $request->featured;
        $setting->save();
        return back();
    }


    public function saveMailSettings(Request $request, $mailer)
    {

        $envHelper = new EnvHelper;
        $validated = match ($mailer) {
            'mailsend' => $request->validate([
                'MAIL_MAILER' => 'required|string',
                'MAIL_FROM_ADDRESS' => 'required|email',
                'MAIL_FROM_NAME' => 'required|string',
                'MAILERSEND_API_KEY' => 'required_if:MAIL_MAILER,mailersend|string',
            ]),
            'mailgun' => $request->validate([
                'MAIL_MAILER' => 'required|string',
                'MAIL_FROM_ADDRESS' => 'required|email',
                'MAIL_FROM_NAME' => 'required|string',
                'MAILGUN_SECRET' => 'required_if:MAIL_MAILER,mailgun|string',
                'MAILGUN_DOMAIN' => 'required_if:MAIL_MAILER,mailgun|string',
                'MAILGUN_ENDPOINT' => 'required_if:MAIL_MAILER,mailgun|string',
            ]),
            'postmark' => $request->validate([
                'MAIL_MAILER' => 'required|string',
                'MAIL_FROM_ADDRESS' => 'required|email',
                'MAIL_FROM_NAME' => 'required|string',
                'POSTMARK_TOKEN' => 'required_if:MAIL_MAILER,postmark|string',
            ]),
            'resend' => $request->validate([
                'MAIL_MAILER' => 'required|string',
                'MAIL_FROM_ADDRESS' => 'required|email',
                'MAIL_FROM_NAME' => 'required|string',
                'RESEND_KEY' => 'required_if:MAIL_MAILER,resend|string',
            ]),
            'smtp' => $request->validate([
                'MAIL_MAILER' => 'required|string',
                'MAIL_FROM_ADDRESS' => 'required|email',
                'MAIL_FROM_NAME' => 'required|string',
                'MAIL_HOST' => 'required_if:MAIL_MAILER,smtp|string',
                'MAIL_PORT' => 'required_if:MAIL_MAILER,smtp|string',
                'MAIL_ENCRYPTION' => 'nullable|string',
                'MAIL_USERNAME' => 'nullable|string',
                'MAIL_PASSWORD' => 'nullable|string',
            ]),
        };
        $envHelper->updateMultipleEnv($validated);
        Artisan::call('config:clear');
        return back();
    }
}
