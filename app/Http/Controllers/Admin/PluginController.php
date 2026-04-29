<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePluginRequest;
use App\Http\Requests\UpdatePluginRequest;
use App\Models\Plugin;
use Illuminate\Http\Request;
use Str;

class PluginController extends Controller
{
    public function index(Request $request)
    {
        $plugins = Plugin::orderBy('id', 'DESC');

        $isFiltered = false;

        // Setting array for filtering title and slug
        $filters = [
            'title' => $request->title,
            'slug' => $request->slug,
        ];

        // Filter title and slug
        foreach ($filters as $column => $value) {
            if ($value) {
                $plugins->where($column, 'like', '%' . $value . '%');
                $isFiltered = true;
            }
        }

        $plugins = $plugins->paginate(config('app.pagination'))->withQueryString();

        return view('admin.plugin.index', [
            'pageTitle' => __('Plugins'),
            'plugins' => $plugins,
            'filters' => $filters,
            'isFiltered' => $isFiltered,
        ]);
    }

    public function create(Request $request)
    {
        $token = Str::random(32);

        return view('admin.plugin.create', ['pageTitle' => __('Register Plugin'), 'token' => $token]);
    }

    public function store(CreatePluginRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $verification_result = aplVerifyPluginPurchase($request->license_code, $request->product_id, $request->domain, "create");

        if (!$verification_result) {
            return redirect()->route('admin.plugin')->with('message', __('Something went wrong'));
        }

        if (empty($verification_result->success) || !$verification_result->success) {
            return redirect()
                ->back()
                ->withErrors([
                    'license_code' => $verification_result->message,
                ])
                ->withInput();
        }

        $plugin = new Plugin();
        $plugin->product_id = $request->product_id;
        $plugin->product_name = config('plugins')[$request->product_id];
        $plugin->license_code = $request->license_code;
        $plugin->domain = $request->domain;
        $plugin->token = $request->api_token;
        $plugin->save();

        return redirect()->route('admin.plugin')->with('message', __('Plugin registered successfully'));
    }

    public function edit($id)
    {
        $plugin = Plugin::findOrFail($id);

        return view('admin.plugin.edit', [
            'pageTitle' => __('Edit Plugin'),
            'plugin' => $plugin,
        ]);
    }

    public function update(UpdatePluginRequest $request, $id)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $plugin = Plugin::findOrFail($id);

        $verification_result = aplVerifyPluginPurchase($plugin->license_code, $plugin->product_id, $request->domain, "edit");

        if (!$verification_result) {
            return redirect()->route('admin.plugin')->with('message', __('Something went wrong'));
        }

        if (empty($verification_result->success) || !$verification_result->success) {
            return redirect()->route('admin.plugin')->with('message', $verification_result->message);
        }

        $plugin->domain = $request->domain;
        $plugin->save();

        return redirect()->route('admin.plugin')->with('message', __('Plugin updated successfully.'));
    }

    public function delete($id)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $plugin = Plugin::findOrFail($id);

        $verification_result = aplVerifyPluginPurchase($plugin->license_code, $plugin->product_id, $plugin->domain, "delete");

        if (!$verification_result) {
            return redirect()->route('admin.plugin')->with('message', __('Something went wrong'));
        }

        if (empty($verification_result->success) || !$verification_result->success) {
            return redirect()->route('admin.plugin')->with('message', $verification_result->message);
        }

        $plugin->delete();

        return redirect()->route('admin.plugin')->with('message', __('Plugin Deleted Successfully.'));
    }

    public function updateStatus(Request $request)
    {
        if (isDemoMode()) {
            return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('This feature is not available in demo mode')]);
        }

        $plugin = Plugin::find($request->pluginId);
        $plugin->status = $request->pluginStatus;
        $plugin->save();

        return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('Status Updated Successfully')]);
    }
}
