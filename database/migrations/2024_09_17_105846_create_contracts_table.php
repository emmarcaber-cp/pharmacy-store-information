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
        Schema::create('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('phar_id');
            $table->unsignedBigInteger('drug_manufacturer_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('phar_id')
                ->references('phar_id')
                ->on('pharmacies')
                ->onDelete('cascade');

            $table
                ->foreign('drug_manufacturer_id')
                ->references('company_id')
                ->on('drug_manufacturers')
                ->onDelete('cascade');

            $table->primary(['phar_id', 'drug_manufacturer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
