<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Drug;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test case for the Patient model.
 *
 * This test class covers various functionalities and relationships
 * of the Patient model, including:
 * - Creating and updating patient records
 * - Testing the relationship between patients and doctors
 * - Testing the many-to-many relationship between patients and drugs via prescriptions
 */
class PatientModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a Patient can be created successfully.
     *
     * @return void
     */
    public function test_it_can_create_a_patient()
    {
        // Arrange: Create a doctor to associate with the patient
        $doctor = Doctor::factory()->create();

        // Arrange: Prepare the data for creating a new patient
        $data = [
            'name' => 'John Doe',
            'sex' => 'Male',
            'address' => '789 Health Ave',
            'contact_no' => '555-1234',
            'doctor_id' => $doctor->phys_id,
        ];

        // Act: Create a new Patient instance with the prepared data
        $patient = Patient::create($data);

        // Assert: Check if the patient was created successfully and attributes match
        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertEquals('John Doe', $patient->name);
        $this->assertEquals('Male', $patient->sex);
        $this->assertEquals('789 Health Ave', $patient->address);
        $this->assertEquals('555-1234', $patient->contact_no);
        $this->assertEquals($doctor->phys_id, $patient->doctor_id);

        // Verify the data is saved in the database
        $this->assertDatabaseHas('patients', $data);
    }

    /**
     * Test that a Patient can be updated successfully.
     *
     * @return void
     */
    public function test_it_can_update_a_patient()
    {
        // Arrange: Create a doctor and a patient with initial data
        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create([
            'name' => 'Jane Doe',
            'address' => '456 Old St',
            'doctor_id' => $doctor->phys_id,
        ]);

        // Act: Update the patient's name and address
        $patient->update([
            'name' => 'Jane Smith',
            'address' => '321 New Rd',
        ]);

        // Assert: Check if the patient's name and address were updated correctly
        $this->assertEquals('Jane Smith', $patient->name);
        $this->assertEquals('321 New Rd', $patient->address);

        // Verify the database reflects the updated patient data
        $this->assertDatabaseHas('patients', [
            'name' => 'Jane Smith',
            'address' => '321 New Rd',
        ]);
        // Ensure the old data is no longer present in the database
        $this->assertDatabaseMissing('patients', [
            'name' => 'Jane Doe',
        ]);
    }

    /**
     * Test the relationship between Patient and Doctor.
     *
     * @return void
     */
    public function test_it_belongs_to_a_doctor()
    {
        // Arrange: Create a doctor and a patient associated with that doctor
        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create([
            'doctor_id' => $doctor->phys_id,
        ]);

        // Act: Retrieve the doctor associated with the patient
        $patientDoctor = $patient->doctor;

        // Assert: Check the doctor's details
        $this->assertInstanceOf(Doctor::class, $patientDoctor);
        $this->assertEquals($doctor->phys_id, $patientDoctor->phys_id);
    }

    /**
     * Test the many-to-many relationship between Patient and Drug via prescriptions.
     *
     * @return void
     */
    public function test_it_belongs_to_many_drugs_via_prescriptions()
    {
        // Arrange: Create a patient, some drugs, and attach prescriptions
        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create([
            'doctor_id' => $doctor->phys_id,
        ]);

        $drugs = Drug::factory()->count(2)->create();

        // Act: Attach prescriptions to the patient for each drug
        $patient->prescriptions()->attach($drugs[0]->trade_name, [
            'date_prescribed' => now(),
            'quantity' => 5,
            'doctor_id' => $doctor->phys_id,
        ]);

        $patient->prescriptions()->attach($drugs[1]->trade_name, [
            'date_prescribed' => now(),
            'quantity' => 10,
            'doctor_id' => $doctor->phys_id,
        ]);

        // Act: Retrieve the drugs associated with the patient via prescriptions
        $relatedDrugs = $patient->prescriptions;

        // Assert: Check that the relationships exist
        $this->assertCount(2, $relatedDrugs);
        $this->assertTrue($relatedDrugs->contains($drugs[0]));
        $this->assertTrue($relatedDrugs->contains($drugs[1]));

        // Verify the pivot table has the correct prescription data
        $this->assertDatabaseHas('prescriptions', [
            'patient_id' => $patient->PID,
            'drug_trade_name' => $drugs[0]->trade_name,
            'date_prescribed' => now()->toDateString(),
            'quantity' => 5,
            'doctor_id' => $doctor->phys_id,
        ]);
        $this->assertDatabaseHas('prescriptions', [
            'patient_id' => $patient->PID,
            'drug_trade_name' => $drugs[1]->trade_name,
            'date_prescribed' => now()->toDateString(),
            'quantity' => 10,
            'doctor_id' => $doctor->phys_id,
        ]);
    }
}
