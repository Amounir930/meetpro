<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Setting::insert([
      ['key' => 'APPLICATION_NAME', 'value' => 'JupiterMeet Pro'],
      ['key' => 'PRIMARY_COLOR', 'value' => '#7453f0'],
      ['key' => 'PRIMARY_LOGO', 'value' => 'PRIMARY_LOGO.png'],
      ['key' => 'FAVICON', 'value' => 'FAVICON.png'],
      ['key' => 'SIGNALING_URL', 'value' => 'https://yourdomain.in:9007'],
      ['key' => 'DEFAULT_USERNAME', 'value' => 'Guest'],
      ['key' => 'COOKIE_CONSENT', 'value' => 'enabled'],
      ['key' => 'LANDING_PAGE', 'value' => 'enabled'],
      ['key' => 'GOOGLE_ANALYTICS_ID', 'value' => null],
      ['key' => 'CAPTCHA_LOGIN_PAGE', 'value' => 'disabled'],
      ['key' => 'SOCIAL_INVITATION', 'value' => 'Hey, check out this amazing website, where you can host video meetings!'],
      ['key' => 'MODERATOR_RIGHTS', 'value' => 'enabled'],
      ['key' => 'AUTH_MODE', 'value' => 'enabled'],
      ['key' => 'PAYMENT_MODE', 'value' => 'disabled'],
      ['key' => 'REGISTRATION', 'value' => 'enabled'],
      ['key' => 'VERIFY_USERS', 'value' => 'disabled'],
      ['key' => 'STRIPE_KEY', 'value' => 'pk_test_example'],
      ['key' => 'STRIPE_SECRET', 'value' => 'sk_test_example'],
      ['key' => 'STRIPE', 'value' => '0'],
      ['key' => 'STRIPE_WH_SECRET', 'value' => ''],
      ['key' => 'PAYPAL', 'value' => '0'],
      ['key' => 'PAYPAL_MODE', 'value' => 'sandbox'],
      ['key' => 'PAYPAL_CLIENT_ID', 'value' => ''],
      ['key' => 'PAYPAL_SECRET', 'value' => ''],
      ['key' => 'PAYPAL_WEBHOOK_ID', 'value' => ''],
      ['key' => 'END_URL', 'value' => '/pages/thank-you'],
      ['key' => 'CUSTOM_JS', 'value' => ''],
      ['key' => 'CUSTOM_CSS', 'value' => ''],
      ['key' => 'MAIL_MAILER', 'value' => 'smtp'],
      ['key' => 'MAIL_HOST', 'value' => 'localhost'],
      ['key' => 'MAIL_PORT', 'value' => '1025'],
      ['key' => 'MAIL_USERNAME', 'value' => ''],
      ['key' => 'MAIL_PASSWORD', 'value' => ''],
      ['key' => 'MAIL_ENCRYPTION', 'value' => ''],
      ['key' => 'MAIL_FROM_ADDRESS', 'value' => 'admin@example.com'],
      ['key' => 'VERSION', 'value' => '2.1.7'],
      ['key' => 'PAYSTACK', 'value' => '0'],
      ['key' => 'PAYSTACK_SECRET_KEY', 'value' => ''],
      ['key' => 'MOLLIE', 'value' => '0'],
      ['key' => 'MOLLIE_API_KEY', 'value' => ''],
      ['key' => 'RAZORPAY', 'value' => '0'],
      ['key' => 'RAZORPAY_API_KEY', 'value' => ''],
      ['key' => 'RAZORPAY_SECRET_KEY', 'value' => ''],
      ['key' => 'PWA', 'value' => 'disabled'],
      ['key' => 'LIMITED_SCREEN_SHARE', 'value' => '0'],
      ['key' => 'GOOGLE_RECAPTCHA_KEY', 'value' => ''],
      ['key' => 'GOOGLE_RECAPTCHA_SECRET', 'value' => ''],
      ['key' => 'CAPTCHA_REGISTER_PAGE', 'value' => '0'],
      ['key' => 'GOOGLE_RECAPTCHA', 'value' => '0'],
      ['key' => 'COMPANY_NAME', 'value' => ''],
      ['key' => 'COMPANY_ADDRESS', 'value' => ''],
      ['key' => 'COMPANY_CITY', 'value' => ''],
      ['key' => 'COMPANY_STATE', 'value' => ''],
      ['key' => 'COMPANY_POSTAL_CODE', 'value' => ''],
      ['key' => 'COMPANY_COUNTRY', 'value' => ''],
      ['key' => 'COMPANY_PHONE', 'value' => ''],
      ['key' => 'COMPANY_EMAIL', 'value' => ''],
      ['key' => 'COMPANY_TAX_ID', 'value' => ''],
      ['key' => 'GOOGLE_SOCIAL_LOGIN', 'value' => 'disabled'],
      ['key' => 'GOOGLE_CLIENT_ID', 'value' => ''],
      ['key' => 'GOOGLE_CLIENT_SECRET', 'value' => ''],
      ['key' => 'FACEBOOK_SOCIAL_LOGIN', 'value' => 'disabled'],
      ['key' => 'FACEBOOK_CLIENT_ID', 'value' => ''],
      ['key' => 'FACEBOOK_CLIENT_SECRET', 'value' => ''],
      ['key' => 'LINKEDIN_SOCIAL_LOGIN', 'value' => 'disabled'],
      ['key' => 'LINKEDIN_CLIENT_ID', 'value' => ''],
      ['key' => 'LINKEDIN_CLIENT_SECRET', 'value' => ''],
      ['key' => 'TWITTER_SOCIAL_LOGIN', 'value' => 'disabled'],
      ['key' => 'TWITTER_CLIENT_ID', 'value' => ''],
      ['key' => 'TWITTER_CLIENT_SECRET', 'value' => ''],
      ['key' => 'KEY_PATH', 'value' => '/etc/letsencrypt/live/yourdomain.com/privkey.pem'],
      ['key' => 'CERT_PATH', 'value' => '/etc/letsencrypt/live/yourdomain.com/fullchain.pem'],
      ['key' => 'PORT', 'value' => '9007'],
      ['key' => 'IP', 'value' => '0.0.0.0'],
      ['key' => 'ANNOUNCED_IP', 'value' => ''],
      ['key' => 'RTC_MIN_PORT', 'value' => '10000'],
      ['key' => 'RTC_MAX_PORT', 'value' => '59999'],
      ['key' => 'AI_CHATBOT_API_KEY', 'value' => ''],
      ['key' => 'AI_CHATBOT', 'value' => 'ChatGPT'],
      ['key' => 'AI_CHATBOT_MODEL', 'value' => 'gpt-3.5-turbo'],
      ['key' => 'AI_CHATBOT_SECONDS', 'value' => '10'],
      ['key' => 'AI_CHATBOT_MESSAGE_LIMIT', 'value' => '50'],
      ['key' => 'AI_CHATBOT_MAX_CONVERSATION_LENGTH', 'value' => '10'],
      ['key' => 'DEFAULT_THEME', 'value' => 'light'],
    ]);
  }
}
