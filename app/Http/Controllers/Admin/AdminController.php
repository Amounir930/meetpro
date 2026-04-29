<?php

namespace App\Http\Controllers\Admin;
use App\Jobs\SendVersionUpgradeEmail;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AdminController extends Controller
{
    public function signalingServer()
    {

        $url = getSetting('SIGNALING_URL');

        return view('admin.signaling-server.index', [
            'pageTitle' => __('Signaling Server'),
            'url' => $url,
        ]);

    }

    public function checkSignalingServer()
    {
        $status = __('Running');

        if (!getSignalingServerStatus()) {
            $status = __('Unreachable');
        }

        return response()->json([
            'success' => true,
            'error' => '',
            'status' => $status,
            'message' => __('Signaling Status Fetched'),
        ]);
    }

    public function manageUpdate()
    {
        if (getSetting('VERSION') == '1.8.8') {
            $settinngs = Setting::where('key', 'VERSION')->first();
            $settinngs->value = '2.0.0';
            $settinngs->save();
        }


        return view('admin.manage-update.index', [
            'pageTitle' => __('Manage Updates'),
        ]);
    }

    public function checkUpdate()
    {
        if (isDemoMode()) {
            return json_encode(['success' => false, 'error' => __('This feature is not available in demo mode')]);
        }

        $license_notifications_array = aplVerifyLicense('', true);

        if ($license_notifications_array['notification_case'] != "notification_license_ok") {
            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('Error fetching update details. Error: ' . $license_notifications_array['notification_text'])
                ->log('User');

            return json_encode(['success' => false, 'error' => $license_notifications_array['notification_text']]);
        }

        $current_version = getSetting('VERSION');
        $all_versions = ausGetAllVersions();
        $changelog = [];

        foreach ($all_versions['notification_data']['product_versions'] as $version) {
            if ($current_version < $version['version_number']) {
                $changelog[$version['version_number']] = ausGetVersion($version['version_number'])['notification_data']['version_changelog'];
            }
            ;
        }

        if ($changelog) {
            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('Update details successfully fetched')
                ->log('User');

            return json_encode(['success' => true, 'version' => $all_versions['notification_data']['product_versions'][0]['version_number'], 'changelog' => $changelog]);
        } else {
            return json_encode(['success' => false, 'version' => $current_version]);
        }
    }

    public function downloadUpdate()
    {
        $license_notifications_array = aplVerifyLicense('', true);

        if ($license_notifications_array['notification_case'] != "notification_license_ok") {
            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('Error while downloading the update. Error: ' . $license_notifications_array['notification_text'])
                ->log('User');

            return json_encode(['success' => false, 'error' => $license_notifications_array['notification_text']]);
        }

        if (date('Y-m-d') > json_decode($license_notifications_array['notification_data'])->support) {
            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('Error while downloading the update. Error: Your support has expired. Please renew your support to continue enjoying auto updates.')
                ->log('User');

            return json_encode(['success' => false, 'error' => __('Your support has expired. Please renew your support to continue enjoying auto updates.')]);
        }

        $current_version = getSetting('VERSION');
        $all_versions = ausGetAllVersions();
        $version_numbers = [];

        foreach ($all_versions['notification_data']['product_versions'] as $version) {
            if ($current_version < $version['version_number'])
                array_unshift($version_numbers, $version['version_number']);
        }

        foreach ($version_numbers as $version) {
            $download_notifications_array = ausDownloadFile('version_upgrade_file', $version);

            if ($download_notifications_array['notification_case'] == "notification_operation_ok") {
                $query_notifications_array = ausFetchQuery('upgrade', $version);

                if ($query_notifications_array['notification_case'] == "notification_operation_ok" && $query_notifications_array['notification_data']) {
                    DB::unprepared($query_notifications_array['notification_data']);
                }

                $model = Setting::where('key', 'VERSION')->first();
                $model->value = $version;
                $model->save();

                Cache::flush();
                Artisan::call('migrate', ['--force' => true]);
            } else {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn(Auth::user())
                    ->withProperties(['key' => 'value'])
                    ->event('Error while downloading the update. Error: ' . $download_notifications_array['notification_text'], )
                    ->log('User');
                return json_encode(['success' => false, 'error' => $download_notifications_array['notification_text']]);
            }
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn(Auth::user())
            ->withProperties(['key' => 'value'])
            ->event('The system successfully updated to version: ' . getSetting('VERSION'))
            ->log('User');

        $details = [
            'email' => Auth::user()->email,
            'version' => getSetting('VERSION'),
        ];

        SendVersionUpgradeEmail::dispatch($details);

        return json_encode(['success' => true]);
    }

    public function manageLicense()
    {
        return view('admin.manage-license.index', [
            'pageTitle' => __('Manage License'),
        ]);
    }

    public function verifyLicense()
    {
        if (RateLimiter::tooManyAttempts('verify-license:' . Auth::user()->id, 5)) {
            return json_encode(['success' => false, 'error' => __('Rate Limit reached, please try after sometime.')]);
        }

        RateLimiter::hit('verify-license:' . Auth::user()->id, 3600);

        if (isDemoMode()) {
            return json_encode(['success' => false, 'error' => __('This feature is not available in demo mode')]);
        }

        $license_notifications_array = aplVerifyLicense('', true);

        if ($license_notifications_array['notification_case'] == "notification_license_ok") {
            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('The license successfully verified')
                ->log('User');

            $types = new \stdClass();

            if (isset($license_notifications_array['notification_data'])) {
                $types = json_decode($license_notifications_array['notification_data']);
            }

            return json_encode(['success' => true, 'type' => $types->type ?? null, 'support' => $types->support ?? null]);
        } else {
            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('Error while verifying the license.')
                ->log('User');

            return json_encode(['success' => false, 'error' => $license_notifications_array['notification_text']]);
        }
    }
    public function uninstallLicense()
    {
        if (isDemoMode()) {
            return json_encode(['success' => false, 'error' => __('This feature is not available in demo mode')]);
        }

        $license_notifications_array = aplUninstallLicense('');

        if ($license_notifications_array['notification_case'] == "notification_license_ok") {
            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('The license successfully uninstalled')
                ->log('User');
            return json_encode(['success' => true]);
        } else {

            activity()
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties(['key' => 'value'])
                ->event('Error while uninstalling the license.')
                ->log('User');
            return json_encode(['success' => false, 'error' => $license_notifications_array['notification_text']]);
        }
    }
    public function handshakeResponse(Request $request)
    {
        return view('admin.fix-license', [
            'page' => __('Fix License'),
        ]);
    }

    public function fixLicense(Request $request)
    {
        $request->validate([
            'license_code' => 'required|min:19|max:36',
            'admin_password' => 'required|min:6|max:100',
        ]);

        if (RateLimiter::tooManyAttempts('fix-license:' . $request->ip(), 5)) {
            return redirect()->route('admin.resolve-license')->with('message', __('Rate Limit reached, please try after sometime.'));
        }

        RateLimiter::hit('fix-license:' . $request->ip(), 3600);

        $adminUser = User::where('role', 'admin')->first();

        if (!$adminUser || !Hash::check($request->admin_password, $adminUser->password)) {
            return redirect()->route('admin.resolve-license')->with('message', __('Admin password is incorrect.'));
        }

        try {
            aplUninstallLicense();
            $LICENSE_CODE = $request->license_code;
            aplVerifyEnvatoPurchase($LICENSE_CODE);
            $installLicense = aplInstallLicense(url('/'), '', $LICENSE_CODE, '');

            if ($installLicense['notification_case'] == 'notification_license_ok') {
                return redirect()->route('admin.resolve-license')->with('message', __('License fixed successfully.'));
            }

            return redirect()->route('admin.resolve-license')->with('message', __('An error occured, Error: ' . $installLicense['notification_case']));
        } catch (\Exception $e) {
            return redirect()->route('admin.resolve-license')->with('message', __('Something went wrong, Error: ' . $e->getMessage()));
        }
    }
}