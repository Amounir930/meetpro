<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckTFA;
use App\Http\Middleware\CustomVerified;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateProfileBasicRequest;
use App\Jobs\SendCancelSubscriptionEmail;
use App\Models\ApiToken;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(CheckTFA::class);

        if (getSetting('VERIFY_USERS') == 'enabled') {
            $this->middleware(CustomVerified::class);
        }
    }

    // get basic profile information
    public function basic()
    {
        $user = Auth::user();
        return view('user.profile.basic', [
            'pageTitle' => __('Profile'),
            'user' => $user,
        ]);
    }

    // update basic profile information
    public function updateBasic(UpdateProfileBasicRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        try {

            $request->user()->first_name = $request->first_name;
            $request->user()->last_name = $request->last_name;
            $request->user()->username = $request->username;

            $request->user()->save();

            return back()->with('message', __('Settings saved.'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // upload your profile image
    public function uploadAvatar(Request $request)
    {
        if (isDemoMode()) {
            return response()->json(['success' => true, 'error' => false, 'data' => [], 'message' => __('This feature is not available in demo mode')]);
        }

        try {
            $avatarPath = storage_path('app/public/avatars/');

            if (!File::exists($avatarPath)) {
                File::makeDirectory($avatarPath);
            }

            if ($request->user()->avatar && File::exists($avatarPath . $request->user()->avatar)) {
                unlink(storage_path('app/public/avatars/' . $request->user()->avatar));
            }

            activity('User')
                ->causedBy(auth()->user())
                ->withProperties([
                    'attributes' => [
                        'key' => 'Profile image Updated',
                        'message' => "Profile image has been updated.",
                    ],
                ])
                ->log("Updated Profile image");

            $image = $request->image;
            $imageName = uniqid() . '.' . $request->extension;
            $image->move(storage_path('app/public/avatars/'), $imageName);
            $request->user()->avatar = $imageName;

            activity()->disableLogging();
            $request->user()->save();
            activity()->enableLogging();

            return response()->json(['success' => true, 'message' => __('Data updated successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => true, 'message' => __('Something went wrong')]);
        }
    }

    // delete your profile image
    public function deleteAvatar(Request $request)
    {
        unlink(storage_path('app/public/avatars/' . $request->user()->avatar));

        activity('User')
            ->causedBy(auth()->user())
            ->withProperties([
                'attributes' => [
                    'key' => 'Profile image Deleted',
                    'message' => "Profile image has been deleted.",
                ],
            ])
            ->log("Deleted Profile image");

        $request->user()->avatar = null;

        activity()->disableLogging();
        $request->user()->save();
        activity()->enableLogging();

        return json_encode(['success' => true, 'id' => $request->id]);
    }

    // get change password page
    public function security()
    {
        $user = Auth::user();
        return view('user.profile.security', [
            'pageTitle' => __('Profile'),
            'user' => $user,
        ]);
    }

    // update your password
    public function updateSecurity(Request $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('The current password is incorrect.')]);
        }

        activity('User')
            ->causedBy(auth()->user())
            ->withProperties([
                'attributes' => [
                    'key' => 'Password Updated',
                    'message' => "Password has been updated.",
                ],
            ])
            ->log("Password Updated");

        activity()->disableLogging();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        Auth::logoutOtherDevices($request->password);
        activity()->enableLogging();

        return back()->with('message', __('Settings saved.'));
    }

    // view your plan details
    public function plan()
    {
        $user = Auth::user();
        return view('user.profile.plan', [
            'pageTitle' => __('Profile'),
            'user' => $user,
        ]);
    }

    // cancel your current plan
    public function cancelPlan(Request $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        activity('User')
            ->causedBy(auth()->user())
            ->withProperties([
                'attributes' => [
                    'key' => 'Plan Cancelled',
                    'message' => "Plan has been cancelled.",
                ],
            ])
            ->log("Plan cancelled");

        activity()->disableLogging();
        $request->user()->planSubscriptionCancel();
        activity()->enableLogging();

        SendCancelSubscriptionEmail::dispatch($request->user());

        return back()->with('message', __('Plan Cancelled Successfully.'));
    }

    // view your payment history
    public function payment(Request $request)
    {
        $payments = Payment::where('user_id', $request->user()->id)
            ->orderBy('id', 'DESC')->paginate(config('app.pagination'));

        $plans = Plan::where([['amount_month', '>', 0], ['amount_year', '>', 0]])->withTrashed()->get();

        return view('user.profile.payment', ['payments' => $payments, 'plans' => $plans, 'page' => __('Payments'), 'pageTitle' => 'Payments']);
    }

    // view the payment invoice
    public function invoice($encodedId, Request $request)
    {
        // Decode the base64 encoded ID
        $id = base64_decode($encodedId);

        $payments = Payment::where('id', $id)
            ->firstOrFail();

        if ($payments->user_id != Auth::id() && Auth::user()->role != 'admin') {
            abort(404);
        }

        $companyDetails = Setting::where('key', 'like', '%company%')->orWhere('key', 'like', '%logo%')->get();
        $commonData = [];
        foreach ($companyDetails as $key => $val) {
            $commonData[$val->key] = $val->value;
        }

        $taxAmount = 0;
        if (isset($payments->tax_rates) && $payments->tax_rates[0]) {
            if ($payments->tax_rates[0]->type == 0) {
                // $taxAmount = (isset($payments->product->amount_year)  ? $payments->product->amount_year : $payments->product->amount_month) * ($payments->tax_rates[0]->percentage /100);
                $taxAmount = 0;
            } elseif ($payments->tax_rates[0]->type == 1) {
                $taxAmount = (isset($payments->product->amount_year) ? $payments->product->amount_year : $payments->product->amount_month) * ($payments->tax_rates[0]->percentage / 100);
            }
        }

        $discountAmt = 0;
        $discountDetails = [];
        if ($payments->coupon) {
            $discountAmt = calculateDiscount(isset($payments->product->amount_year) ? $payments->product->amount_year + floatval($taxAmount) : $payments->product->amount_month + floatval($taxAmount), $payments->coupon->percentage);
            $discountDetails['couponName'] = $payments->coupon->code;
            $discountDetails['discountAmt'] = $discountAmt;
        }

        return view('user.profile.invoice', ['payments' => $payments, 'commonData' => $commonData, 'userEmail' => $request->user()->email, 'route' => 'payments', 'taxAmount' => $taxAmount, 'discountAmt' => $discountAmt, 'page' => __('Invoice')]);
    }

    // view your API token
    public function apiToken(Request $request)
    {
        $apiTokens = ApiToken::where('user_id', Auth::user()->id)->paginate();
        return view('user.profile.api-token.index', ['apiTokens' => $apiTokens, 'pageTitle' => 'Api Tokens']);
    }

    // view create contact form
    public function createApiToken()
    {
        return view('user.profile.api-token.create', ['pageTitle' => __('Create API Token')]);
    }


    // view create contact form
    public function storeApiToken(Request $request)
    {
        // Check if user already has 5 tokens
        if (ApiToken::where('user_id', auth()->id())->count() >= 5) {
            return redirect()->route('user.profile.api-token')
                ->with('message', __('You can create a maximum of 5 API tokens.'));
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:50',
                Rule::unique('api_tokens')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create API Token
        ApiToken::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'token' => Str::random(32),
            'last_accessed' => null,
        ]);

        return redirect()->route('user.profile.api-token')
            ->with('message', __('API Token Created Successfully.'));

    }

    // delete a contact
    public function deleteApiToken($id)
    {
        $apiToken = ApiToken::findOrFail($id);
        $apiToken->delete();

        return redirect()->route('user.profile.api-token')->with('message', __('API Token Deleted Successfully.'));
    }

    // view your contacts list
    public function contacts()
    {
        $contacts = Contact::where('user_id', Auth::user()->id)
            ->orderBy('id', 'DESC')->paginate(config('app.pagination'));

        return view('user.profile.contact.index', ['contacts' => $contacts, 'pageTitle' => __('Contacts')]);
    }

    // view create contact form
    public function createContact()
    {
        return view('user.profile.contact.create', ['pageTitle' => __('Create Contact')]);
    }

    // store a new contact
    public function storeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'required|email:filter|unique:contacts,email,NULL,id,user_id,' . Auth::id() . '|max:50',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $values = [
            'name' => $request->name,
            'email' => $request->email,
            'user_id' => Auth::id(),
        ];

        Contact::create($values);

        return redirect()->route('user.profile.contacts')->with('message', __('Contact Added Successfully'));
    }

    // view edit contact form
    public function editContact(Request $request, $id)
    {
        $contact = Contact::where('id', $request->id)->first();
        return view('user.profile.contact.edit', ['contact' => $contact, 'pageTitle' => __('Update Contact')]);
    }

    // update contact details
    public function updateContact(Request $request, $id)
    {
        $contact = Contact::where('id', $id)->firstOrFail();

        if (!$contact) {
            return redirect()->route('user.profile.contacts')->with('error', __('Contact not found'))->withInput();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'email' => 'required|email:filter|unique:contacts,email,' . $id . ',id,user_id,' . Auth::id() . '|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->user_id = Auth::id();
        $contact->save();

        return redirect()->route('user.profile.contacts')->with('message', __('Contact updated Successfully'));
    }

    // delete a contact
    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('user.profile.contacts')->with('message', __('Contact Deleted Successfully.'));
    }

    // show import contact form
    public function showImportForm()
    {
        return view('user.profile.contact.import', ['pageTitle' => __('Import Contact')]);
    }

    // download sample CSV file for import
    public function downloadCsvFile()
    {
        $filepath = public_path('/sources/sample.csv');
        return Response::download($filepath);
    }

    // import contacts from CSV file
    public function importContact(Request $request)
    {

        $file = $request->file('file');
        //file details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        //valid file extensions
        $valid_extension = ["csv"];

        //2MB in bytes
        $maxFileSize = 2097152;

        //check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            //check file size
            if ($fileSize <= $maxFileSize) {

                //file upload location
                $location = 'file_uploads';

                //upload file
                $file->move($location, $filename);

                //import CSV to Database
                $filepath = public_path($location . "/" . $filename);

                //reading file
                $file = fopen($filepath, "r");

                $importData_arr = [];
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                    $num = count($filedata);

                    //skip first row
                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);

                //insert into database
                $totalRecords = count($importData_arr);
                $totalSuccess = 0;
                $totalFailed = 0;
                foreach ($importData_arr as $importData) {
                    $contactExists = Contact::where('user_id', auth()->user()->id)->where('email', trim($importData[1]))->first();
                    if (trim($importData[0]) && trim($importData[1]) && filter_var($importData[1], FILTER_VALIDATE_EMAIL) && !$contactExists) {
                        $insertData = [
                            "name" => $importData[0],
                            "email" => $importData[1],
                            "user_id" => auth()->user()->id,
                        ];
                        $id = Contact::create($insertData)->id;
                        $totalSuccess++;
                    } else {
                        $totalFailed++;
                    }
                }
                if ($totalRecords) {
                    unlink(public_path($location . "/" . $filename));
                    return redirect()->route('user.profile.contacts')->with('message', __('File imported. Out of total :totalRecords records, :totalSuccess succeeded and :totalFailed failed', ['totalRecords' => $totalRecords, 'totalSuccess' => $totalSuccess, 'totalFailed' => $totalFailed]));
                } else {
                    return redirect()->route('user.profile.contacts')->with('error', __('No records were found'));
                }
            } else {
                return redirect()->route('user.profile.contact.import.form')->with('error', __('File too large. File must be less than 2MB'));
            }
        } else {
            return redirect()->route('user.profile.contact.import.form')->with('error', __('Invalid file extension'));
        }
    }

    // view two factor authentication settings
    public function tfa(Request $request)
    {
        return view('user.profile.tfa', ['user' => Auth::user(), 'pageTitle' => __('Two Factor Authentication')]);
    }

    // update two factor authentication settings
    public function updateTfa(Request $request)
    {
        if (isDemoMode()) {
            return response()->json(['success' => false, 'error' => true, 'data' => [], 'message' => __('This feature is not available in demo mode')]);
        }

        if (!getSetting('MAIL_USERNAME') && $request->userTfa == 'active')
            return response()->json(['success' => false, 'error' => true, 'data' => [], 'message' => __('SMTP settings are missing. Please try again later.')]);

        $user = User::find($request->userId);
        $user->tfa = $request->userTfa;
        $user->save();

        Session::put('user_tfa', auth()->user()->id);

        return response()->json(['success' => true, 'error' => '', 'data' => [], 'message' => __('Two factor Authentication Updated Successfully')]);
    }

    // view delete account page
    public function deleteAccount(Request $request)
    {
        return view('user.profile.delete-account', ['pageTitle' => __('Delete Account')]);
    }

    // soft delete your account
    public function delete()
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $user = Auth::user();
        $user->delete();

        return redirect()->route('user.profile.delete-account')->with('message', __('Your account has been deleted.'));

    }

}
