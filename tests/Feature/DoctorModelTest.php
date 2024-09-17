<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Drug;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test case for the Doctor model.
 *
 * This test class covers various functionalities and relationships
 * of the Doctor model, including:
 * - Creating and updating doctor records
 * - Verifying the one-to-many relationship between doctors and patients
 * - Testing the many-to-many relationship between doctors and drugs via prescriptions
 */
class DoctorModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a Doctor can be created successfully.
     *
     * @return void
     */
    public function test_it_can_create_a_doctor()
    {
        // Arrange: Prepare the data for the new doctor
        $data = [
            'd_name' => 'Dr. Smith',
            'specialty' => 'Cardiology',
        ];

        // Act: Create a new Doctor instance
        $doctor = Doctor::create($data);

        // Assert: Check if the doctor was created successfully and attributes match
        $this->assertInstanceOf(Doctor::class, $doctor);
        $this->assertEquals('Dr. Smith', $doctor->d_name);
        $this->assertEquals('Cardiology', $doctor->specialty);

        // Verify that the doctor data is saved in the database
        $this->assertDatabaseHas('doctors', $data);
    }

    /**
     * Test that a Doctor can be updated successfully.
     *
     * @return void
     */
    public function test_it_can_update_a_doctor()
    {
        // Arrange: Create a doctor with initial data
        $doctor = Doctor::factory()->create([
            'd_name' => 'Dr. Old',
            'specialty' => 'Orthopedics',
        ]);

        // Act: Update the doctor's details
        $doctor->update([
            'd_name' => 'Dr. New',
            'specialty' => 'Neurology',
        ]);

        // Assert: Check if the doctor's details are updated correctly
        $this->assertEquals('Dr. New', $doctor->d_name);
        $this->assertEquals('Neurology', $doctor->specialty);

        // Verify that the updated data is present in the database
        $this->assertDatabaseHas('doctors', [
            'd_name' => 'Dr. New',
            'specialty' => 'Neurology',
        ]);
        // Ensure the old data is no longer in the database
        $this->assertDatabaseMissing('doctors', [
            'd_name' => 'Dr. Old',
        ]);
    }

    /**
     * Test the one-to-many relationship between Doctor and Patient.
     *
     * @return void
     */
    public function test_it_has_many_patients()
    {
        // Arrange: Create a doctor and some patients associated with that doctor
        $doctor = Doctor::factory()->create();
        $patients = Patient::factory()->count(3)->create([
            'doctor_id' => $doctor->phys_id,
        ]);

        // Act: Retrieve the patients associated with the doctor
        $doctorPatients = $doctor->patients;

        // Assert: Verify the doctor has the correct patients
        $this->assertCount(3, $doctorPatients);
        $this->assertTrue($doctorPatients->contains($patients[0]));
        $this->assertTrue($doctorPatients->contains($patients[1]));
        $this->assertTrue($doctorPatients->contains($patients[2]));
    }

    /**
     * Test the many-to-many relationship between Doctor and Drug via prescriptions.
     *
     * @return void
     */
    public function test_it_belongs_to_many_drugs_via_prescriptions()
    {
        // Arrange: Create a doctor, some drugs, and a patient
        $doctor = Doctor::factory()->create();
        $drugs = Drug::factory()->count(2)->create();
        $patient = Patient::factory()->create();

        // Act: Attach drugs to the doctor through prescriptions
        $doctor->prescriptions()->attach($drugs[0]->trade_name, [
            'date_prescribed' => now(),
            'patient_id' => $patient->PID,
            'quantity' => 5,
        ]);

        $doctor->prescriptions()->attach($drugs[1]->trade_name, [
            'date_prescribed' => now(),
            'patient_id' => $patient->PID,
            'quantity' => 10,
        ]);

        // Act: Retrieve the drugs associated with the doctor
        $relatedDrugs = $doctor->prescriptions;

        // Assert: Verify the doctor has the correct drugs
        $this->assertCount(2, $relatedDrugs);
        $this->assertTrue($relatedDrugs->contains($drugs[0]));
        $this->assertTrue($relatedDrugs->contains($drugs[1]));

        // Verify that the prescription data is correctly saved in the database
        $this->assertDatabaseHas('prescriptions', [
            'doctor_id' => $doctor->phys_id,
            'drug_trade_name' => $drugs[0]->trade_name,
            'date_prescribed' => now()->toDateString(),
            'quantity' => 5,
        ]);
        $this->assertDatabaseHas('prescriptions', [
            'doctor_id' => $doctor->phys_id,
            'drug_trade_name' => $drugs[1]->trade_name,
            'date_prescribed' => now()->toDateString(),
            'quantity' => 10,
        ]);
    }
}
