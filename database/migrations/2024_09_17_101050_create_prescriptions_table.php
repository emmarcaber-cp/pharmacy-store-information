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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id');
            $table->string('drug_trade_name');
            $table->unsignedBigInteger('doctor_id');
            $table->date('date_prescribed');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('PID')
                ->on('patients')
                ->onDelete('cascade');

            $table->foreign('drug_trade_name')
                ->references('trade_name')
                ->on('drugs')
                ->onDelete('cascade');

            $table->foreign('doctor_id')
                ->references('phys_id')
                ->on('doctors')
                ->onDelete('cascade');

            $table->unique(['patient_id', 'drug_trade_name', 'doctor_id']);
            $table->primary(['patient_id', 'drug_trade_name', 'doctor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['drug_trade_name']);
            $table->dropForeign(['doctor_id']);
        });

        Schema::dropIfExists('doctor_prescribe_patient_drug');
    }
};
