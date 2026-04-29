<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateApplicationSettingRequest;
use App\Http\Requests\UpdateBasicSettingRequest;
use App\Http\Requests\UpdateCompanyInformationRequest;
use App\Http\Requests\UpdateCssSettingRequest;
use App\Http\Requests\UpdateJsSettingRequest;
use App\Http\Requests\UpdateMeetingSettingRequest;
use App\Http\Requests\UpdateMollieRequest;
use App\Http\Requests\UpdateNodejsSettingRequest;
use App\Http\Requests\UpdatePaypalRequest;
use App\Http\Requests\UpdatePaystackRequest;
use App\Http\Requests\UpdateRazorpayRequest;
use App\Http\Requests\UpdateRecaptchaSettingRequest;
use App\Http\Requests\UpdateSmtpSettingRequest;
use App\Http\Requests\UpdateSocialLoginSettingRequest;
use App\Http\Requests\UpdateStripeRequest;
use App\Mail\TestSMTPMail;
use App\Models\Country;
use App\Models\EmailTemplate;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Show stripe payment gateway form
    public function stripePaymentGateway(Request $request)
    {
        return view('admin.payment-gateway.stripe', [
            'pageTitle' => __('Stripe'),
        ]);
    }

    // Show paypal payment gateway form
    public function paypalPaymentGateway(Request $request)
    {
        return view('admin.payment-gateway.paypal', [
            'pageTitle' => __('Paypal'),
        ]);
    }

    // Show paystack payment gateway form
    public function paystackPaymentGateway(Request $request)
    {
        return view('admin.payment-gateway.paystack', [
            'pageTitle' => __('Paystack'),
        ]);
    }

    // Show mollie payment gateway form
    public function molliePaymentGateway(Request $request)
    {
        return view('admin.payment-gateway.mollie', [
            'pageTitle' => __('Mollie'),
        ]);
    }

    // Show razorpay payment gateway form
    public function razorpayPaymentGateway(Request $request)
    {
        return view('admin.payment-gateway.razorpay', [
            'pageTitle' => __('Razorpay'),
        ]);
    }

    //save settings helper
    private function saveSettings(Request $request, $keys)
    {
        // Fetch all rows in one query
        $settings = Setting::whereIn('key', $keys)->get()->keyBy('key');

        DB::transaction(function () use ($request, $keys, $settings) {
            foreach ($keys as $key) {
                $setting = $settings->get($key);

                if ($setting) {
                    $setting->update(['value' => $request->input($key)]);
                }
            }
        });
    }

    // Update Stripe payment gateway 
    public function updateStripe(UpdateStripeRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'STRIPE',
            'STRIPE_KEY',
            'STRIPE_SECRET',
            'STRIPE_WH_SECRET',
        ];
        
        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Update Razorpay payment gateway 
    public function updateRazorpay(UpdateRazorpayRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'RAZORPAY',
            'RAZORPAY_API_KEY',
            'RAZORPAY_SECRET_KEY',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Update Paystack payment gateway 
    public function updatePaystack(UpdatePaystackRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'PAYSTACK',
            'PAYSTACK_SECRET_KEY',
        ];
        
        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Update Paypal payment gateway 
    public function updatePaypal(UpdatePaypalRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'PAYPAL',
            'PAYPAL_MODE',
            'PAYPAL_CLIENT_ID',
            'PAYPAL_SECRET',
            'PAYPAL_WEBHOOK_ID',
        ];
        
        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Update Mollie payment gateway 
    public function updateMollie(UpdateMollieRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'MOLLIE',
            'MOLLIE_API_KEY',
        ];
        
        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Show basic details form in setting module
    public function basic()
    {
        return view('admin.setting.basic', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update basic details in settings module
    public function updateBasic(UpdateBasicSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'APPLICATION_NAME',
            'PRIMARY_COLOR',
            'PRIMARY_LOGO',
            'SECONDARY_LOGO',
            'FAVICON',
        ];

        foreach ($rows as $row) {
            // Store logo and favicon in files
            if ($row == 'PRIMARY_LOGO' || $row == 'FAVICON' || $row == 'SECONDARY_LOGO') {
                $file = $request->file($row);
                if ($file && $file->isValid()) {
                    $filename = $row . '_' . now()->timestamp . '.png';

                    $globalconfigs = Setting::where('key', $row)->first();
                    if ($globalconfigs) {
                        $oldFilename = $globalconfigs->value;

                        if ($oldFilename && Storage::exists('images/' . $oldFilename)) {
                            Storage::delete('images/' . $oldFilename);
                        }

                        $globalconfigs->update(['value' => $request->input($filename)]);
                    }

                    Storage::putFileAs('images', $file, $filename);
                }
                if ($request[$row]) {
                    activity('Setting')
                        ->causedBy(auth()->user())
                        ->withProperties([
                            'attributes' => [
                                'key' => $row,
                                'message' => "{$row} image has been updated.",
                            ],
                        ])
                        ->log("Updated {$row}");
                }
            } else {
                $globalconfigs = Setting::where('key', $row)->first();
                if (!empty($globalconfigs)) {
                    $globalconfigs->update(['value' => $request->input($row)]);
                }
            }
        }


        return back()->with('message', __('Settings saved.'));
    }

    // Show appliocation details form in setting module
    public function application()
    {
        return view('admin.setting.application', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update application details in settings module
    public function updateApplication(UpdateApplicationSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'AUTH_MODE',
            'COOKIE_CONSENT',
            'LANDING_PAGE',
            'GOOGLE_ANALYTICS_ID',
            'SOCIAL_INVITATION',
            'PAYMENT_MODE',
            'REGISTRATION',
            'VERIFY_USERS',
            'PWA',
            'DEFAULT_THEME',
            'ADMIN_TIMEZONE',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Show meeting details form in setting module
    public function meeting()
    {
        return view('admin.setting.meeting', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update meeting details in settings module
    public function updateMeeting(UpdateMeetingSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'MODERATOR_RIGHTS',
            'DEFAULT_USERNAME',
            'SIGNALING_URL',
            'END_URL',
            'LIMITED_SCREEN_SHARE',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Show meeting details form in setting module
    public function nodejs()
    {
        return view('admin.setting.nodejs', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update meeting details in settings module
    public function updateNodejs(UpdateNodejsSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'KEY_PATH',
            'CERT_PATH',
            'PORT',
            'IP',
            'ANNOUNCED_IP',
            'RTC_MIN_PORT',
            'RTC_MAX_PORT',
            'AI_CHATBOT_API_KEY',
            'AI_CHATBOT',
            'AI_CHATBOT_MODEL',
            'AI_CHATBOT_SECONDS',
            'AI_CHATBOT_MESSAGE_LIMIT',
            'AI_CHATBOT_MAX_CONVERSATION_LENGTH'
        ];

        $this->saveSettings($request, $rows);

        foreach ($rows as $row) {
            $globalconfigs = Setting::where('key', $row)->first();
            if (!empty($globalconfigs)) {
                $globalconfigs->getModel()->update(['value' => $request->input($row)]);
            }
        }

        return back()->with('message', __('Settings saved.'));
    }


    // Show custom js form in setting module
    public function customJs()
    {
        return view('admin.setting.custom-js', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update custom js in settings module
    public function updateCustomJs(UpdateJsSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'CUSTOM_JS',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }


    // Show custom css form in setting module
    public function customCss()
    {
        return view('admin.setting.custom-css', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update custom css in settings module
    public function updateCustomCss(UpdateCssSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'CUSTOM_CSS',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }


    // Show smtp form in setting module
    public function smtp()
    {
        return view('admin.setting.smtp', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update smtp details in settings module
    public function updateSmtp(UpdateSmtpSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Test SMTP 
    public function testSmtp(Request $request)
    {
        if (isDemoMode()) {
            return json_encode(['success' => false, 'error' => 'This feature is not available in demo mode']);
        }
        
        try {
            $emailBody = EmailTemplate::where('slug', 'test-smtp')->first();
            Mail::to($request->email)->send(new TestSMTPMail($emailBody->name, $emailBody['content']));
            return json_encode(['success' => true]);
        } catch (Exception $e) {
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    // Show google recaptcha details form in setting module
    public function googleRecaptcha()
    {
        return view('admin.setting.google-recaptcha', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update google recaptcha in settings module
    public function updateGoogleRecaptcha(UpdateRecaptchaSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        try {
            $rows = [
                'GOOGLE_RECAPTCHA',
                'GOOGLE_RECAPTCHA_KEY',
                'GOOGLE_RECAPTCHA_SECRET',
                'CAPTCHA_REGISTER_PAGE',
                'CAPTCHA_LOGIN_PAGE',
            ];

            $this->saveSettings($request, $rows);

            return back()->with('message', __('Settings saved.'));
        } catch (Exception $e) {
            return back()->with('ermessageror', $e->getMessage());
        }
    }

    // Show company information form in setting module
    public function companyInformation()
    {
        $countries = Country::all();
        return view('admin.setting.company-information', [
            'pageTitle' => __('Settings'),
            'countries' => $countries,
        ]);
    }

    // Update companu information in settings module
    public function updateCompanyInformation(UpdateCompanyInformationRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'COMPANY_NAME',
            'COMPANY_ADDRESS',
            'COMPANY_CITY',
            'COMPANY_STATE',
            'COMPANY_POSTAL_CODE',
            'COMPANY_COUNTRY',
            'COMPANY_PHONE',
            'COMPANY_EMAIL',
            'COMPANY_TAX_ID',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }

    // Show social login details form in setting module
    public function socialLogin()
    {
        return view('admin.setting.social-login', [
            'pageTitle' => __('Settings'),
        ]);
    }

    // Update social login details in settings module
    public function updateSocialLogin(UpdateSocialLoginSettingRequest $request)
    {
        if (isDemoMode()) {
            return redirect()->back()->with('message', __('This Feature is not available in demo mode.'));
        }

        $rows = [
            'GOOGLE_SOCIAL_LOGIN',
            'GOOGLE_CLIENT_ID',
            'GOOGLE_CLIENT_SECRET',
            'FACEBOOK_SOCIAL_LOGIN',
            'FACEBOOK_CLIENT_ID',
            'FACEBOOK_CLIENT_SECRET',
            'LINKEDIN_SOCIAL_LOGIN',
            'LINKEDIN_CLIENT_ID',
            'LINKEDIN_CLIENT_SECRET',
            'TWITTER_SOCIAL_LOGIN',
            'TWITTER_CLIENT_ID',
            'TWITTER_CLIENT_SECRET',
        ];

        $this->saveSettings($request, $rows);

        return back()->with('message', __('Settings saved.'));
    }
}