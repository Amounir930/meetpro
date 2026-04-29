<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('email_templates')->insert(array(
            array(
                'name' => 'Version Upgrade',
                'slug' => 'version-upgrade',
                'content' => '<p>Hello,</p><p>Your application has been successfully upgraded to version [VERSION].</p><p>If you have any questions or require assistance, feel free to contact our support team.</p>'
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
