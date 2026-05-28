<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unknown_words', function (Blueprint $table) {
            $table->boolean('is_familiar')->default(false)->after('enabled');
        });
    }

    public function down(): void
    {
        Schema::table('unknown_words', function (Blueprint $table) {
            $table->dropColumn('is_familiar');
        });
    }
};
