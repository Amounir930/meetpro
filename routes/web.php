<?php

require __DIR__ . '/auth.php';

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SocialLoginController;
use App\Http\Controllers\Admin\WebhookController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckAuthMode;
use App\Http\Middleware\CheckPaymentMode;
use App\Http\Middleware\CheckTFA;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

if (file_exists(storage_path('installed'))) {
    Route::get('/install', function () {
        return redirect('/');

    });
}

//pages route
Route::get('/pages/{id}', [PageController::class, 'show'])->name('pages.show');

//pricing route
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

Route::get('meeting/{id}', [MeetingController::class, 'meeting'])->name('meeting');

if (file_exists(storage_path('installed'))) {
    Auth::routes([
        'register' => getSetting('REGISTRATION') == 'enabled',
        'verify' => getSetting('VERIFY_USERS') == 'enabled'
    ]);
} else {
    Auth::routes();
}

Route::post('/get-details', [MeetingController::class, 'getDetails']);
Route::post('meeting-files', [MeetingController::class, 'fileUploads']);
Route::post('delete-meeting-files', [MeetingController::class, 'deleteFolder']);
Route::post('check-meeting-password', [MeetingController::class, 'checkMeetingPassword']);
Route::get('get-nodejs-details', [MeetingController::class, 'getNodejsDetails']);
Route::get('widget', [MeetingController::class, 'widget']);

Route::group(['middleware' => ['auth']], function () {
    Route::middleware([CheckAuthMode::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::post('/dashboard/create-meeting', [DashboardController::class, 'createMeeting'])->name('createMeeting');
    Route::post('/dashboard/edit-meeting', [DashboardController::class, 'editMeeting'])->name('editMeeting');
    Route::post('/dashboard/delete-meeting', [DashboardController::class, 'deleteMeeting'])->name('deleteMeeting');
    Route::post('send-invite', [DashboardController::class, 'sendInvite']);
    Route::get('get-invites', [DashboardController::class, 'getInvites']);

    Route::get('/profile/basic', [ProfileController::class, 'basic'])->name('user.profile.basic');
    Route::post('/profile/basic/update', [ProfileController::class, 'updateBasic'])->name('user.profile.basic.update');
    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadAvatar']);
    Route::post('profile/delete-avatar', [ProfileController::class, 'deleteAvatar']);
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('user.profile.security');
    Route::post('/profile/security/update', [ProfileController::class, 'updateSecurity'])->name('user.profile.security.update');
    Route::get('/profile/plan', [ProfileController::class, 'plan'])->name('user.profile.plan');
    Route::post('/profile/plan/cancel-plan', [ProfileController::class, 'cancelPlan'])->name('user.profile.cancel-plan');
    Route::get('/profile/payment', [ProfileController::class, 'payment'])->name('user.profile.payment');
    Route::get('/profile/payment/invoice/{id}', [ProfileController::class, 'invoice'])->name('profile.payment.invoice');
    Route::get('/profile/api-token', [ProfileController::class, 'apiToken'])->name('user.profile.api-token');
    Route::get('/profile/api-token/create', [ProfileController::class, 'createApiToken'])->name('user.profile.api-token.create');
    Route::post('/profile/api-token/store', [ProfileController::class, 'storeApiToken'])->name('user.profile.api-token.store');
    Route::get('/profile/api-token/delete/{token}', [ProfileController::class, 'deleteApiToken'])->name('user.profile.api-token.destroy');
    Route::get('/profile/contact', [ProfileController::class, 'contacts'])->name('user.profile.contacts');
    Route::get('/profile/contact/create', [ProfileController::class, 'createContact'])->name('user.profile.contact.create');
    Route::post('/profile/contact/store', [ProfileController::class, 'storeContact'])->name('user.profile.contact.store');
    Route::get('/profile/contact/edit/{id}', [ProfileController::class, 'editContact'])->name('user.profile.contact.edit');
    Route::put('/profile/contact/update/{id}', [ProfileController::class, 'updateContact'])->name('user.profile.contact.update');
    Route::get('/profile/contact/delete/{language}', [ProfileController::class, 'deleteContact'])->name('user.profile.contact.destroy');
    Route::get('/profile/contact/import-form/', [ProfileController::class, 'showImportForm'])->name('user.profile.contact.import.form');
    Route::get('/profile/contact/download-csv', [ProfileController::class, 'downloadCsvFile'])->name('user.profile.contact.downloadCsvFile');
    Route::post('/profile/contact/import-contact', [ProfileController::class, 'importContact'])->name('user.profile.contact.import');
    Route::get('/profile/tfa', [ProfileController::class, 'tfa'])->name('user.profile.tfa');
    Route::post('/profile/update-tfa', [ProfileController::class, 'updateTfa']);
    Route::get('/profile/delete-account', [ProfileController::class, 'deleteAccount'])->name('user.profile.delete-account');
    Route::get('/profile/account/delete', [ProfileController::class, 'delete'])->name('user.profile.account.delete');

});

Route::middleware(['auth'])->group(function () {
    //two factor authentication routes
    Route::get('two-factor-auth', [App\Http\Controllers\TwoFAController::class, 'index'])->name('tfa.index');
    Route::post('two-factor-auth/store', [App\Http\Controllers\TwoFAController::class, 'store'])->name('tfa.post');
    Route::get('two-factor-auth/resend', [App\Http\Controllers\TwoFAController::class, 'resend'])->name('tfa.resend');
});

Route::post('check-meeting', [CommonController::class, 'checkMeeting']);
Route::get('languages/{locale}', [CommonController::class, 'setLocale'])->name('language');
Route::post('/check-details', [CommonController::class, 'checkDetails']);
Route::post('/toggle-theme', [CommonController::class, 'toggleTheme'])->name('theme.toggle');
Route::post('/user-activity-status', [CommonController::class, 'userActivityStatus']);


// Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'verified']], function () {
Route::group(['prefix' => '/admin', 'middleware' => ['auth', IsAdmin::class]], function () {

    //Dashboard routes
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    //Meeting routes
    Route::get('/meetings', [App\Http\Controllers\Admin\MeetingController::class, 'index'])->name('admin.meeting');
    Route::get('/meetings/delete/{meeting}', [App\Http\Controllers\Admin\MeetingController::class, 'delete'])->name('admin.meeting.destroy');
    Route::post('/meeting/update-status', [App\Http\Controllers\Admin\MeetingController::class, 'updateStatus']);
    Route::get('/meetings/export-meeting', [App\Http\Controllers\Admin\MeetingController::class, 'exportMeeting'])->name('export-meeting');

    //User routes
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.user');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.user.create');
    Route::post('/users/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.user.store');
    Route::get('/users/delete/{user}', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin.user.destroy');
    Route::post('/user/assign-plan', [App\Http\Controllers\Admin\UserController::class, 'assignPlan']);
    Route::post('/user/update-status', [App\Http\Controllers\Admin\UserController::class, 'updateStatus']);
    Route::get('/users/export-user', [App\Http\Controllers\Admin\UserController::class, 'exportUser'])->name('export-user');


    //Language routes
    Route::get('/languages', [App\Http\Controllers\Admin\LanguageController::class, 'index'])->name('admin.language');
    Route::get('/languages/create', [App\Http\Controllers\Admin\LanguageController::class, 'create'])->name('admin.language.create');
    Route::post('/languages/store', [App\Http\Controllers\Admin\LanguageController::class, 'store'])->name('admin.language.store');
    Route::get('/languages/edit/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'edit'])->name('admin.language.edit');
    Route::put('/languages/update/{id}', [App\Http\Controllers\Admin\LanguageController::class, 'update'])->name('admin.language.update');
    Route::get('/languages/delete/{language}', [App\Http\Controllers\Admin\LanguageController::class, 'delete'])->name('admin.language.destroy');
    Route::get('languages/download-english', [App\Http\Controllers\Admin\LanguageController::class, 'downloadEnglish'])->name('admin.language.download-sample');
    Route::get('languages/download-file/{code}', [App\Http\Controllers\Admin\LanguageController::class, 'downloadFile'])->name('admin.language.downloadFile');

    //Page routes
    Route::get('/pages', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('admin.page');
    Route::get('/pages/create', [App\Http\Controllers\Admin\PageController::class, 'create'])->name('admin.page.create');
    Route::post('/pages/store', [App\Http\Controllers\Admin\PageController::class, 'store'])->name('admin.page.store');
    Route::get('/pages/edit/{id}', [App\Http\Controllers\Admin\PageController::class, 'edit'])->name('admin.page.edit');
    Route::put('/pages/update/{id}', [App\Http\Controllers\Admin\PageController::class, 'update'])->name('admin.page.update');
    Route::get('/pages/delete/{page}', [App\Http\Controllers\Admin\PageController::class, 'delete'])->name('admin.page.destroy');

    //Plugin routes
    Route::get('/plugins', [App\Http\Controllers\Admin\PluginController::class, 'index'])->name('admin.plugin');
    Route::get('/plugins/create', [App\Http\Controllers\Admin\PluginController::class, 'create'])->name('admin.plugin.create');
    Route::post('/plugins/store', [App\Http\Controllers\Admin\PluginController::class, 'store'])->name('admin.plugin.store');
    Route::get('/plugins/edit/{id}', [App\Http\Controllers\Admin\PluginController::class, 'edit'])->name('admin.plugin.edit');
    Route::put('/plugins/update/{id}', [App\Http\Controllers\Admin\PluginController::class, 'update'])->name('admin.plugin.update');
    Route::get('/plugins/delete/{plugin}', [App\Http\Controllers\Admin\PluginController::class, 'delete'])->name('admin.plugin.destroy');
    Route::post('/plugin/update-status', [App\Http\Controllers\Admin\PluginController::class, 'updateStatus']);


    //Plan routes
    Route::get('/plans', [App\Http\Controllers\Admin\PlanController::class, 'index'])->name('admin.plan');
    Route::get('/plans/create', [App\Http\Controllers\Admin\PlanController::class, 'create'])->name('admin.plan.create');
    Route::post('/plans/store', [App\Http\Controllers\Admin\PlanController::class, 'store'])->name('admin.plan.store');
    Route::get('/plans/edit/{id}', [App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('admin.plan.edit');
    Route::post('/plan/update-status', [App\Http\Controllers\Admin\PlanController::class, 'updateStatus']);
    Route::post('/plan/update-popularity', [App\Http\Controllers\Admin\PlanController::class, 'updatePopularity']);
    Route::put('/plans/update/{id}', [App\Http\Controllers\Admin\PlanController::class, 'update'])->name('admin.plan.update');

    //Coupon routes 
    Route::get('/coupons', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('admin.coupon');
    Route::get('/coupons/create', [App\Http\Controllers\Admin\CouponController::class, 'create'])->name('admin.coupon.create');
    Route::post('/coupons/store', [App\Http\Controllers\Admin\CouponController::class, 'store'])->name('admin.coupon.store');
    Route::get('/coupons/edit/{id}', [App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('admin.coupon.edit');
    Route::put('/coupons/update/{id}', [App\Http\Controllers\Admin\CouponController::class, 'update'])->name('admin.coupon.update');
    Route::post('/coupon/update-status', [App\Http\Controllers\Admin\CouponController::class, 'updateStatus']);

    //Tax Rate routes
    Route::get('/taxrates', [App\Http\Controllers\Admin\TaxrateController::class, 'index'])->name('admin.taxrate');
    Route::get('/taxrates/create', [App\Http\Controllers\Admin\TaxrateController::class, 'create'])->name('admin.taxrate.create');
    Route::post('/taxrates/store', [App\Http\Controllers\Admin\TaxrateController::class, 'store'])->name('admin.taxrate.store');
    Route::get('/taxrates/edit/{id}', [App\Http\Controllers\Admin\TaxrateController::class, 'edit'])->name('admin.taxrate.edit');
    Route::put('/taxrates/update/{id}', [App\Http\Controllers\Admin\TaxrateController::class, 'update'])->name('admin.taxrate.update');
    Route::post('/taxrate/update-status', [App\Http\Controllers\Admin\TaxrateController::class, 'updateStatus']);

    //Transaction routes
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transaction');
    Route::get('/transactions/export-transaction', [App\Http\Controllers\Admin\TransactionController::class, 'exportTransaction'])->name('export-transaction');

    Route::get('/payment-gateways/stripe', [App\Http\Controllers\Admin\SettingController::class, 'stripePaymentGateway'])->name('admin.payment-gateway.stripe');
    Route::get('/payment-gateways/paypal', [App\Http\Controllers\Admin\SettingController::class, 'paypalPaymentGateway'])->name('admin.payment-gateway.paypal');
    Route::get('/payment-gateways/paystack', [App\Http\Controllers\Admin\SettingController::class, 'paystackPaymentGateway'])->name('admin.payment-gateway.paystack');
    Route::get('/payment-gateways/mollie', [App\Http\Controllers\Admin\SettingController::class, 'molliePaymentGateway'])->name('admin.payment-gateway.mollie');
    Route::get('/payment-gateways/razorpay', [App\Http\Controllers\Admin\SettingController::class, 'razorpayPaymentGateway'])->name('admin.payment-gateway.razorpay');
    Route::post('/payment-gateways/update-stripe', [App\Http\Controllers\Admin\SettingController::class, 'updateStripe'])->name('admin.payment_gateways.update-stripe');
    Route::post('/payment-gateways/update-razorpay', [App\Http\Controllers\Admin\SettingController::class, 'updateRazorpay'])->name('admin.payment_gateways.update-razorpay');
    Route::post('/payment-gateways/update-paystack', [App\Http\Controllers\Admin\SettingController::class, 'updatePaystack'])->name('admin.payment_gateways.update-paystack');
    Route::post('/payment-gateways/update-paypal', [App\Http\Controllers\Admin\SettingController::class, 'updatePaypal'])->name('admin.payment_gateways.update-paypal');
    Route::post('/payment-gateways/update-mollie', [App\Http\Controllers\Admin\SettingController::class, 'updateMollie'])->name('admin.payment_gateways.update-mollie');

    //Email Template routes
    Route::get('/email-templates', [App\Http\Controllers\Admin\EmailTemplateController::class, 'index'])->name('admin.email-template');
    Route::get('/email-templates/edit/{id}', [App\Http\Controllers\Admin\EmailTemplateController::class, 'edit'])->name('admin.email-template.edit');
    Route::put('/email-templates/update/{id}', [App\Http\Controllers\Admin\EmailTemplateController::class, 'update'])->name('admin.email-template.update');

    //Signaling Server Routes
    Route::get('/signaling-server', [App\Http\Controllers\Admin\AdminController::class, 'signalingServer'])->name('admin.signaling-server');
    Route::get('/check-signaling-server', [App\Http\Controllers\Admin\AdminController::class, 'checkSignalingServer']);

    //Manage updates Routes
    Route::get('/manage-updates', [App\Http\Controllers\Admin\AdminController::class, 'manageUpdate'])->name('admin.manage-update');
    Route::get('/check-for-update', [App\Http\Controllers\Admin\AdminController::class, 'checkUpdate']);
    Route::get('/download-update', [App\Http\Controllers\Admin\AdminController::class, 'downloadUpdate']);

    //Manage License Routes
    Route::get('/manage-license', [App\Http\Controllers\Admin\AdminController::class, 'manageLicense'])->name('admin.license');
    Route::get('/verify-license', [App\Http\Controllers\Admin\AdminController::class, 'verifyLicense']);
    Route::get('/uninstall-license', [App\Http\Controllers\Admin\AdminController::class, 'uninstallLicense']);

    //Activity log Routes
    Route::get('/activity-logs', [App\Http\Controllers\Admin\ActivityLogsController::class, 'index'])->name('admin.activity-log');
    Route::get('/activity-logs/export-activity-log', [App\Http\Controllers\Admin\ActivityLogsController::class, 'exportActivityLog'])->name('export-activity-log');

    //Setting Routes
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'basic'])->name('admin.setting');
    Route::post('/settings/update-basic', [App\Http\Controllers\Admin\SettingController::class, 'updateBasic'])->name('admin.setting.update-basic');
    Route::get('/settings/application', [App\Http\Controllers\Admin\SettingController::class, 'application'])->name('admin.setting.application');
    Route::post('/settings/update-application', [App\Http\Controllers\Admin\SettingController::class, 'updateApplication'])->name('admin.setting.update-application');
    Route::get('/settings/meeting', [App\Http\Controllers\Admin\SettingController::class, 'meeting'])->name('admin.setting.meeting');
    Route::post('/settings/update-meeting', [App\Http\Controllers\Admin\SettingController::class, 'updateMeeting'])->name('admin.setting.update-meeting');
    Route::get('/settings/nodejs', [App\Http\Controllers\Admin\SettingController::class, 'nodejs'])->name('admin.setting.nodejs');
    Route::post('/settings/update-nodejs', [App\Http\Controllers\Admin\SettingController::class, 'updateNodejs'])->name('admin.setting.update-nodejs');
    Route::get('/settings/custom-js', [App\Http\Controllers\Admin\SettingController::class, 'customJs'])->name('admin.setting.custom-js');
    Route::post('/settings/update-custom-js', [App\Http\Controllers\Admin\SettingController::class, 'updateCustomJs'])->name('admin.setting.update-custom-js');
    Route::get('/settings/custom-css', [App\Http\Controllers\Admin\SettingController::class, 'customCss'])->name('admin.setting.custom-css');
    Route::post('/settings/update-custom-css', [App\Http\Controllers\Admin\SettingController::class, 'updateCustomCss'])->name('admin.setting.update-custom-css');
    Route::get('/settings/smtp', [App\Http\Controllers\Admin\SettingController::class, 'smtp'])->name('admin.setting.smtp');
    Route::post('/settings/update-smtp', [App\Http\Controllers\Admin\SettingController::class, 'updateSmtp'])->name('admin.setting.update-smtp');
    Route::post('/setting/test-smtp', [App\Http\Controllers\Admin\SettingController::class, 'testSmtp']);
    Route::get('/settings/google-recaptcha', [App\Http\Controllers\Admin\SettingController::class, 'googleRecaptcha'])->name('admin.setting.google-recaptcha');
    Route::post('/settings/update-google-recaptcha', [App\Http\Controllers\Admin\SettingController::class, 'updateGoogleRecaptcha'])->name('admin.setting.update-google-recaptcha');
    Route::get('/settings/company-information', [App\Http\Controllers\Admin\SettingController::class, 'companyInformation'])->name('admin.setting.company-information');
    Route::post('/settings/update-company-information', [App\Http\Controllers\Admin\SettingController::class, 'updateCompanyInformation'])->name('admin.setting.update-company-information');
    Route::get('/settings/social-login', [App\Http\Controllers\Admin\SettingController::class, 'socialLogin'])->name('admin.setting.social-login');
    Route::post('/settings/update-social-login', [App\Http\Controllers\Admin\SettingController::class, 'updateSocialLogin'])->name('admin.setting.update-social-login');
});

Route::get('/resolve-license', [App\Http\Controllers\Admin\AdminController::class, 'handshakeResponse'])->name('admin.resolve-license');
Route::post('/fix-license', [App\Http\Controllers\Admin\AdminController::class, 'fixLicense'])->name('fix-license');

//checkout routes
Route::middleware(['auth', CheckPaymentMode::class, CheckTFA::class])->prefix('checkout')->group(function () {
    Route::get('/cancelled', [App\Http\Controllers\CheckoutController::class, 'cancelled'])->name('checkout.cancelled');
    Route::get('/pending', [App\Http\Controllers\CheckoutController::class, 'pending'])->name('checkout.pending');
    Route::get('/complete', [App\Http\Controllers\CheckoutController::class, 'complete'])->name('checkout.complete');

    Route::get('/{id}', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/{id}', [App\Http\Controllers\CheckoutController::class, 'process']);
});

Route::post('webhooks/stripe', [WebhookController::class, 'stripe'])->name('webhooks.stripe');
Route::post('webhooks/paypal', [WebhookController::class, 'paypal'])->name('webhooks.paypal');
Route::post('webhooks/paystack', [WebhookController::class, 'paystack'])->name('webhooks.paystack');
Route::post('webhooks/mollie', [WebhookController::class, 'mollie'])->name('webhooks.mollie');
Route::post('webhooks/razorpay', [WebhookController::class, 'razorpay'])->name('webhooks.razorpay');

Route::get('/paystack/callback', [WebhookController::class, 'handlePaystackGatewayCallback'])->name('callback.paystack');
Route::get('/mollie/callback', [WebhookController::class, 'handleMollieGatewayCallback'])->name('callback.mollie');


Route::middleware(['guest'])->group(function () {
    //Google
    Route::get('/login/google', [SocialLoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('login.google.callback');
    //Facebook
    Route::get('/login/facebook', [SocialLoginController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('/login/facebook/callback', [SocialLoginController::class, 'handleFacebookCallback'])->name('login.facebook.callback');
    //Linkedin
    Route::get('/login/linkedin', [SocialLoginController::class, 'redirectToLinkedin'])->name('login.linkedin');
    Route::get('/login/linkedin/callback', [SocialLoginController::class, 'handleLinkedinCallback'])->name('login.linkedin.callback');
    //Twitter
    Route::get('/login/twitter', [SocialLoginController::class, 'redirectToTwitter'])->name('login.twitter');
    Route::get('/login/twitter/callback', [SocialLoginController::class, 'handleTwitterCallback'])->name('login.twitter.callback');
});

//add username page when login/register through social login
Route::get('add-username', [App\Http\Controllers\Auth\RegisterController::class, 'username'])->name('username.add');
Route::post('add-username/verify', [App\Http\Controllers\Auth\RegisterController::class, 'usernameVerify'])->name('username.add.verify');