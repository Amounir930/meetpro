<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $plans = Plan::all();

        foreach ($plans as $plan) {
            $features = (array) $plan->features;
            $features['max_filesize'] = '50';
            $plan->features = (object) $features;
            $plan->update();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_features', function (Blueprint $table) {
            //
        });
    }
};
