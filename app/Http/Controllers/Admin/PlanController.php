<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Plan;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = Plan::orderBy('id', 'DESC');

        $isFiltered = false;

        // Setting array for filter
        $filters = [
            'name' => $request->name,
            'description' => $request->description,
            'currency' => $request->currency,
            'status' => $request->status,
        ];

        // Filter name, description, currency and status
        foreach ($filters as $column => $value) {
            if ($value) {
                $plans->where($column, 'like', '%' . $value . '%');
                $isFiltered = true;
            }
        }

        $plans = $plans->paginate(config('app.pagination'))->withQueryString();

        // Get all currencies from database
        $currencies = Currency::get();

        return view('admin.plan.index', [
            'pageTitle' => __('Plans'),
            'currencies' => $currencies,
            'plans' => $plans,
            'filters' => $filters,
            'isFiltered' => $isFiltered,
        ]);
    }

    // Display create plan form
    public function create()
    {
        // Get all coupons, taxrate and currency for create plan dropdown form 
        $coupons = Coupon::where('status', 1)->get();
        $taxRates = TaxRate::where('status', 1)->get();
        $currencies = Currency::all();

        return view('admin.plan.create', [
            'pageTitle' => __('Create Plan'),
            'currencies' => $currencies,
            'coupons' => $coupons,
            'taxRates' => $taxRates,
        ]);
    }

    // Store plan in database
    public function store(CreatePlanRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $plan = new Plan;
        $plan->name = $request->name;
        $plan->description = $request->description;
        $plan->amount_month = round($request->amount_month, 2);
        $plan->amount_year = round($request->amount_year, 2);
        $plan->currency = $request->currency;
        $plan->coupons = $request->coupons;
        $plan->tax_rates = $request->tax_rates;
        $plan->features = $request->features;
        $plan->save();

        return redirect()->route('admin.plan')->with('message', __('Plan created Successfully.'));
    }

    // Display edit plan form 
    public function edit($id)
    {
        $plan = Plan::where('id', $id)->firstOrFail();
        $coupons = Coupon::where('status', 1)->get();
        $taxRates = TaxRate::where('status', 1)->get();
        $currencies = Currency::all();

        return view('admin.plan.edit', [
            'pageTitle' => __('Update Plan'),
            'plan' => $plan,
            'currencies' => $currencies,
            'coupons' => $coupons,
            'taxRates' => $taxRates,
        ]);
    }

    // Update plan in database
    public function update(UpdatePlanRequest $request, $id)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $plan = Plan::findOrFail($id);

        if ($plan->hasPrice()) {
            $plan->amount_month = round($request->amount_month, 2);
            $plan->amount_year = round($request->amount_year, 2);
            $plan->currency = $request->currency;
            $plan->coupons = $request->coupons;
            $plan->tax_rates = $request->tax_rates;
        }
        $plan->name = $request->name;
        $plan->description = $request->description;
        $plan->features = $request->features;
        $plan->save();

        return redirect()->route('admin.plan')->with('message', __('Plan updated Successfully.'));
    }

    // Update plan status via toggle 
    public function updateStatus(Request $request)
    {
        if (isDemoMode()) {
            return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('This feature is not available in demo mode')]);
        }

        $plan = Plan::find($request->planId);
        $plan->status = $request->planStatus;
        $plan->save();

        return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('Status Updated Successfully')]);
    }

    public function updatePopularity(Request $request)
    {
        $planId = $request->planId;
        $planStatus = $request->planStatus;

        $plan = Plan::findOrFail($planId);

        if ($planStatus == 1) {
            Plan::where('id', '!=', $planId)->update(['popular' => 'false']);

            $plan->update(['popular' => 'true']);
            return response()->json(['success' => true, 'message' => __('Plan marked as popular.'),]);
        } else {
            $plan->update(['popular' => 'false']);
            return response()->json(['success' => true, 'message' => __('Plan removed from popular.')]);
        }


    }

}