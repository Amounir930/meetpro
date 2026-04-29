<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AddSecondaryLogoToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Setting::where('key', 'SECONDARY_LOGO')->exists()) {
            Setting::create([
                'key' => 'SECONDARY_LOGO',
                'value' => 'SECONDARY_LOGO.png',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
