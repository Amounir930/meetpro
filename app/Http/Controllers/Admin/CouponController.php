<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::orderBy('id', 'DESC');
        $isFiltered = false;

        // Set filter array by code, name, type 
        $filters = [
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
        ];

        // Filter by status
        $status = $request->status;
        if ($status) {
            $coupons->where('status', $status);
            $isFiltered = true;
        }

        // Filter by code , name and type
        foreach ($filters as $column => $value) {
            if ($value !== null) { // This allows 0 to be included
                $coupons->where($column, 'like', '%' . $value . '%');
                $isFiltered = true;
            }
        }

        $coupons = $coupons->paginate(config('app.pagination'))->withQueryString();

        return view('admin.coupon.index', [
            'pageTitle' => __('Coupons'),
            'coupons' => $coupons,
            'filters' => $filters,
            'status' => $status,
            'isFiltered' => $isFiltered,
        ]);
    }

    // Show create coupon form
    public function create()
    {
        return view('admin.coupon.create', [
            'pageTitle' => __('Create Coupon'),
        ]);

    }

    // Store coupon in database
    public function store(CreateCouponRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $coupon = new Coupon;

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->days = $request->days;
        $coupon->percentage = $request->type ? 100 : $request->percentage;
        $coupon->quantity = $request->quantity;

        $coupon->save();

        return redirect()->route('admin.coupon')->with('message', __('Coupon created successfully.'));
    }

    // Show edit plan form 
    public function edit($id)
    {
        $coupon = Coupon::where('id', $id)->withTrashed()->firstOrFail();

        return view('admin.coupon.edit', [
            'pageTitle' => __('Update Coupon'),
            'coupon' => $coupon,
        ]);

    }

    // Update coupon in database
    public function update(UpdateCouponRequest $request, $id)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $coupon = Coupon::withTrashed()->findOrFail($id);

        $coupon->code = $request->code;
        $coupon->days = $request->days;
        $coupon->quantity = $request->quantity;

        $coupon->save();

        return redirect()->route('admin.coupon')->with('message', __('Coupon updated successfully.'));
    }

    // Update coupon status via toggle
    public function updateStatus(Request $request)
    {
        if (isDemoMode()) {
            return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('This feature is not available in demo mode')]);
        }

        $coupon = Coupon::find($request->couponId);
        $coupon->status = $request->couponStatus;
        $coupon->save();

        return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('Status Updated Successfully')]);
    }
}