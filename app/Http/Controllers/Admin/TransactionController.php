<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::orderBy('id', 'DESC');

        $isFiltered = false;

        // Set filter array for coupon, interval, gateway and payment_id
        $filters = [
            'coupon' => $request->coupon,
            'interval' => $request->type,
            'gateway' => $request->payment_gateway,
            'payment_id' => $request->transaction_id,
        ];

        // Filter payments by username
        $username = $request->username;
        if ($username) {
            $payments->whereHas('user', function ($query) use ($username) {
                $query->where('username', 'LIKE', '%' . $username . '%');
            });
            $isFiltered = true;
        }

        // Filter payments by plan
        $plan = $request->plan;
        if ($plan) {
            $payments->whereHas('plan', function ($query) use ($plan) {
                $query->where('name', 'LIKE', '%' . $plan . '%');
            });
            $isFiltered = true;
        }

        // Filter by coupon, interval, gateway and payment_id
        foreach ($filters as $column => $value) {
            if ($value) {
                $payments->where($column, 'like', '%' . $value . '%');
                $isFiltered = true;
            }
        }

        $payments = $payments->paginate(config('app.pagination'))->withQueryString();

        return view('admin.transaction.index', [
            'pageTitle' => __('Transactions'),
            'payments' => $payments,
            'username' => $username,
            'plan' => $plan,
            'filters' => $filters,
            'isFiltered' => $isFiltered,
        ]);
    }

    public function exportTransaction(Request $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $query = Payment::with('user')->select('payment_id', 'product', 'amount', 'currency', 'interval', 'user_id', 'gateway', 'coupon', 'tax_rates', 'created_at');

        if ($request->has('type')) {
            $query->where('interval', 'LIKE', '%' . $request->type . '%');
        }

        if ($request->has('username')) {
            $username = $request->username;
            $query->whereHas('user', function ($usernameQuery) use ($username) {
                $usernameQuery->where('username', 'LIKE', '%' . $username . '%');
            });
        }

        if ($request->has('plan')) {
            $planname = $request->plan;
            $query->whereHas('plan', function ($planQuery) use ($planname) {
                $planQuery->where('name', 'LIKE', '%' . $planname . '%');
            });
        }

        if ($request->has('payment_gateway')) {
            $query->where('gateway', 'like', '%' . $request->payment_gateway . '%');
        }

        if ($request->has('transaction_id')) {
            $query->where('payment_id', 'like', '%' . $request->transaction_id . '%');
        }

        $transactions = $query->get();
        $arrayToExport = [];

        foreach ($transactions as $transaction) {
            $product = $transaction->product ?? json_decode($transaction->product);
            $arrayToExport[] = [
                'Payment ID' => $transaction->payment_id,
                'Product' => $product->name,
                'Amount' => $transaction->amount,
                'Currency' => $transaction->currency,
                'Interval' => $transaction->interval,
                'Username' => $transaction->user->username,
                'Gateway' => $transaction->gateway,
                'Coupon' => $transaction->coupon,
                'Taxrate' => $transaction->tax_rates,
                'Created_at' => $transaction->created_at->toDateTimestring(),
            ];
        }

        if (empty($arrayToExport)) {
            return back()->with('error', 'No data available to export.');
        }

        return exportCSV('transations.csv', $arrayToExport);
    }
}
