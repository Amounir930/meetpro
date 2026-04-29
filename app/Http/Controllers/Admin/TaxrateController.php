<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaxrateRequest;
use App\Models\Country;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTaxrateRequest;

class TaxrateController extends Controller
{
    public function index(Request $request)
    {
        $taxrates = TaxRate::orderBy('id', 'DESC');

        $isFiltered = false;

        // Set filter array for name
        $filters = [
            'name' => $request->name,
        ];

        // Filter by status
        $status = $request->status;
        if ($status) {
            $taxrates->where('status', $status);
            $isFiltered = true;
        }

        // Filter by name
        foreach ($filters as $column => $value) {
            if ($value) {
                $taxrates->where($column, 'like', '%' . $value . '%');
                $isFiltered = true;
            }
        }

        $taxrates = $taxrates->paginate(config('app.pagination'))->withQueryString();

        return view('admin.taxrate.index', [
            'pageTitle' => __('Tax Rates'),
            'taxrates' => $taxrates,
            'isFiltered' => $isFiltered,
            'filters' => $filters,
            'status' => $status,
        ]);

    }

    // Show create taxrate form
    public function create()
    {
        $countries = Country::all();
        return view('admin.taxrate.create', [
            'pageTitle' => __('Create Tax Rate'),
            'countries' => $countries,
        ]);

    }

    // Store new taxrate in database
    public function store(CreateTaxrateRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $taxRate = new TaxRate;

        $taxRate->name = $request->name;
        $taxRate->type = $request->type;
        $taxRate->percentage = $request->percentage;
        $taxRate->regions = $request->regions;

        $taxRate->save();

        return redirect()->route('admin.taxrate')->with('message', __('Tax Rate created successfully.'));
    }

    // Show edit taxrate form
    public function edit($id)
    {
        $countries = Country::all();
        $taxrate = TaxRate::where('id', $id)->firstOrFail();

        return view('admin.taxrate.edit', [
            'pageTitle' => __('Update Tax Rate'),
            'taxrate' => $taxrate,
            'countries' => $countries,
        ]);
    }

    // Update taxrate from database
    public function update(UpdateTaxrateRequest $request, $id)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $taxRate = TaxRate::findOrFail($id);
        $taxRate->regions = $request->regions;
        $taxRate->save();

        return redirect()->route('admin.taxrate')->with('message', __('Tax Rate updated successfully.'));
    }


    // Update taxrate status via toggle
    public function updateStatus(Request $request)
    {
        if (isDemoMode()) {
            return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('This feature is not available in demo mode')]);
        }

        $taxrate = TaxRate::find($request->taxrateId);
        $taxrate->status = $request->taxrateStatus;
        $taxrate->save();

        return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('Status Updated Successfully')]);
    }
}