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
        Schema::create('drugs', function (Blueprint $table) {
            $table->string('trade_name')->primary();
            $table->unsignedBigInteger('drug_manufacturer_id');
            $table->timestamps();

            $table->foreign('drug_manufacturer_id')
                ->references('company_id')
                ->on('drug_manufacturers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropForeign(['drug_manufacturer_id']);
        });

        Schema::dropIfExists('drugs');
    }
};
