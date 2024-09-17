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
        Schema::create('works', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedInteger('pharmacy_id');
            $table->datetime('shift_start');
            $table->datetime('shift_end');
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('pharmacy_id')
                ->references('phar_id')
                ->on('pharmacies')
                ->onDelete('cascade');

            $table->primary(['employee_id', 'shift_start', 'shift_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
