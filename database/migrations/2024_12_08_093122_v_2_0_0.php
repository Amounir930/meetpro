<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // add welcome email to email templates
        DB::table('email_templates')->insert(array(
            array(
                'name' => 'Welcome',
                'slug' => 'welcome',
                'content' => '<p>Hello!&nbsp;[USER_NAME], Welcome to our site.</p>'
            )
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
