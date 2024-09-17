<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Drug;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\DrugManufacturer;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test case for the Drug model.
 *
 * This test class covers various functionalities and relationships
 * of the Drug model, including:
 * - Creating and updating drug records
 * - Verifying the relationship between drugs and drug manufacturers
 * - Testing the many-to-many relationship between drugs and patients via prescriptions
 */
class DrugModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a Drug can be created successfully.
     *
     * @return void
     */
    public function test_it_can_create_a_drug()
    {
        // Arrange: Create a drug manufacturer
        $manufacturer = DrugManufacturer::factory()->create();

        // Arrange: Prepare the data for the drug
        $data = [
            'trade_name' => 'Aspirin',
            'drug_manufacturer_id' => $manufacturer->company_id,
        ];

        // Act: Create a new Drug instance
        $drug = Drug::create($data);

        // Assert: Check if the drug was created successfully and attributes match
        $this->assertInstanceOf(Drug::class, $drug);
        $this->assertEquals('Aspirin', $drug->trade_name);
        $this->assertEquals($manufacturer->company_id, $drug->drug_manufacturer_id);

        // Verify that the drug data is saved in the database
        $this->assertDatabaseHas('drugs', $data);
    }

    /**
     * Test that a Drug can be updated successfully.
     *
     * @return void
     */
    public function test_it_can_update_a_drug()
    {
        // Arrange: Create a drug manufacturer and a drug
        $manufacturer = DrugManufacturer::factory()->create();
        $drug = Drug::factory()->create([
            'trade_name' => 'Old Aspirin',
            'drug_manufacturer_id' => $manufacturer->company_id,
        ]);

        // Act: Update the drug's trade name
        $drug->update([
            'trade_name' => 'New Aspirin',
        ]);

        // Assert: Check if the drug's trade name is updated correctly
        $this->assertEquals('New Aspirin', $drug->trade_name);

        // Verify the database reflects the updated drug data
        $this->assertDatabaseHas('drugs', [
            'trade_name' => 'New Aspirin',
        ]);
        // Ensure the old data is no longer in the database
        $this->assertDatabaseMissing('drugs', [
            'trade_name' => 'Old Aspirin',
        ]);
    }

    /**
     * Test the belongs-to relationship between Drug and DrugManufacturer.
     *
     * @return void
     */
    public function test_it_belongs_to_drug_manufacturer()
    {
        // Arrange: Create a drug manufacturer and a drug
        $manufacturer = DrugManufacturer::factory()->create();
        $drug = Drug::factory()->create([
            'trade_name' => 'Aspirin',
            'drug_manufacturer_id' => $manufacturer->company_id,
        ]);

        // Act: Retrieve the drug manufacturer associated with the drug
        $drugManufacturer = $drug->drugManufacturer;

        // Assert: Check the details of the drug manufacturer
        $this->assertInstanceOf(DrugManufacturer::class, $drugManufacturer);
        $this->assertEquals($manufacturer->company_id, $drugManufacturer->company_id);
    }

    /**
     * Test the many-to-many relationship between Drug and Patient via prescriptions.
     *
     * @return void
     */
    public function test_it_belongs_to_many_patients_via_prescriptions()
    {
        // Arrange: Create a drug, a doctor, and some patients, then attach prescriptions
        $manufacturer = DrugManufacturer::factory()->create();
        $doctor = Doctor::factory()->create();
        $drug = Drug::factory()->create([
            'trade_name' => 'Aspirin',
            'drug_manufacturer_id' => $manufacturer->company_id,
        ]);

        $patients = Patient::factory()->count(2)->create();

        // Attach prescriptions to the drug
        $drug->prescriptions()->attach($patients[0]->PID, [
            'doctor_id' => $doctor->phys_id,
            'date_prescribed' => now(),
            'quantity' => 10,
        ]);

        $drug->prescriptions()->attach($patients[1]->PID, [
            'doctor_id' => $doctor->phys_id,
            'date_prescribed' => now(),
            'quantity' => 20,
        ]);

        // Act: Retrieve the patients related to the drug
        $relatedPatients = $drug->prescriptions;

        // Assert: Check that the patients have the expected prescriptions
        $this->assertCount(2, $relatedPatients);
        $this->assertTrue($relatedPatients->contains($patients[0]));
        $this->assertTrue($relatedPatients->contains($patients[1]));

        // Verify the pivot table has the correct prescription data
        $this->assertDatabaseHas('prescriptions', [
            'drug_trade_name' => $drug->trade_name,
            'patient_id' => $patients[0]->PID,
            'date_prescribed' => now()->toDateString(),
            'quantity' => 10,
        ]);
        $this->assertDatabaseHas('prescriptions', [
            'drug_trade_name' => $drug->trade_name,
            'patient_id' => $patients[1]->PID,
            'date_prescribed' => now()->toDateString(),
            'quantity' => 20,
        ]);
    }
}
