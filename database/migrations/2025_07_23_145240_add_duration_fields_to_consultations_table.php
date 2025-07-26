<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (!Schema::hasColumn('consultations', 'duration_hours')) {
                $table->integer('duration_hours')->default(0)->after('status');
            }

            if (!Schema::hasColumn('consultations', 'duration_minutes')) {
                $table->integer('duration_minutes')->default(0)->after('duration_hours');
            }
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['duration_hours', 'duration_minutes']);
        });
    }
};
