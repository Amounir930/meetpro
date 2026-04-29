<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('email_templates')->insert(array(
            array(
                'name' => 'Signaling Server is Down',
                'slug' => 'ping-signaling-server',
                'content' => '<p>Hello,</p><p>Your Signaling server, [SIGNALING_URL] is currently down.</p><p>Please refer to the "Signaling" section in our official documentation for troubleshooting steps.</p>'
            )
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            //
        });
    }
};
