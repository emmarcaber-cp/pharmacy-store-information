<?php

namespace Tests\Feature;

use App\Models\Drug;
use App\Models\DrugManufacturer;
use App\Models\Pharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test case for the DrugManufacturer model.
 *
 * This test class covers various functionalities and relationships
 * of the DrugManufacturer model, including:
 * - Creating and updating drug manufacturer records
 * - Verifying the one-to-many relationship between drug manufacturers and drugs
 * - Testing the many-to-many relationship between drug manufacturers and pharmacies via contracts
 */
class DrugManufacturerModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a DrugManufacturer can be created successfully.
     *
     * @return void
     */
    public function test_it_can_create_a_drug_manufacturer()
    {
        // Arrange: Prepare the data for the new drug manufacturer
        $data = [
            'name' => 'Pharma Corp',
            'address' => '123 Health St, Medical City',
        ];

        // Act: Create a new DrugManufacturer instance
        $manufacturer = DrugManufacturer::create($data);

        // Assert: Check if the drug manufacturer was created successfully and attributes match
        $this->assertInstanceOf(DrugManufacturer::class, $manufacturer);
        $this->assertEquals('Pharma Corp', $manufacturer->name);
        $this->assertEquals('123 Health St, Medical City', $manufacturer->address);

        // Verify that the manufacturer data is saved in the database
        $this->assertDatabaseHas('drug_manufacturers', $data);
    }

    /**
     * Test that a DrugManufacturer can be updated successfully.
     *
     * @return void
     */
    public function test_it_can_update_a_drug_manufacturer()
    {
        // Arrange: Create a drug manufacturer with initial data
        $manufacturer = DrugManufacturer::factory()->create([
            'name' => 'Old Pharma Corp',
            'address' => '456 Old St',
        ]);

        // Act: Update the manufacturer's details
        $manufacturer->update([
            'name' => 'New Pharma Corp',
            'address' => '789 New Health Blvd',
        ]);

        // Assert: Check if the manufacturer's details are updated correctly
        $this->assertEquals('New Pharma Corp', $manufacturer->name);
        $this->assertEquals('789 New Health Blvd', $manufacturer->address);

        // Verify that the updated data is present in the database
        $this->assertDatabaseHas('drug_manufacturers', [
            'name' => 'New Pharma Corp',
            'address' => '789 New Health Blvd',
        ]);
        // Ensure the old data is no longer in the database
        $this->assertDatabaseMissing('drug_manufacturers', [
            'name' => 'Old Pharma Corp',
        ]);
    }

    /**
     * Test the one-to-many relationship between DrugManufacturer and Drug.
     *
     * @return void
     */
    public function test_it_has_many_drugs()
    {
        // Arrange: Create a drug manufacturer and some drugs associated with that manufacturer
        $manufacturer = DrugManufacturer::factory()->create();
        $drugs = Drug::factory()->count(3)->create([
            'drug_manufacturer_id' => $manufacturer->company_id,
        ]);

        // Act: Retrieve the drugs associated with the manufacturer
        $manufacturerDrugs = $manufacturer->drugs;

        // Assert: Verify the manufacturer has the correct drugs
        $this->assertCount(3, $manufacturerDrugs);
        $this->assertTrue($manufacturerDrugs->contains($drugs[0]));
        $this->assertTrue($manufacturerDrugs->contains($drugs[1]));
        $this->assertTrue($manufacturerDrugs->contains($drugs[2]));
    }

    /**
     * Test the many-to-many relationship between DrugManufacturer and Pharmacy via contracts.
     *
     * @return void
     */
    public function test_it_belongs_to_many_pharmacies_via_contracts()
    {
        // Arrange: Create a drug manufacturer, some pharmacies, and attach contracts
        $manufacturer = DrugManufacturer::factory()->create();
        $pharmacies = Pharmacy::factory()->count(2)->create();

        // Attach contracts to the manufacturer-pharmacy relationships
        $manufacturer->contracts()->attach($pharmacies[0]->phar_id, [
            'start_date' => now()->subYear(),
            'end_date' => now()->addYear(),
        ]);

        $manufacturer->contracts()->attach($pharmacies[1]->phar_id, [
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonth(),
        ]);

        // Act: Retrieve the pharmacies associated with the manufacturer
        $relatedPharmacies = $manufacturer->contracts;

        // Assert: Verify the manufacturer has the correct pharmacies
        $this->assertCount(2, $relatedPharmacies);
        $this->assertTrue($relatedPharmacies->contains($pharmacies[0]));
        $this->assertTrue($relatedPharmacies->contains($pharmacies[1]));

        // Verify that the contract data is correctly saved in the database
        $this->assertDatabaseHas('contracts', [
            'drug_manufacturer_id' => $manufacturer->company_id,
            'phar_id' => $pharmacies[0]->phar_id,
        ]);
        $this->assertDatabaseHas('contracts', [
            'drug_manufacturer_id' => $manufacturer->company_id,
            'phar_id' => $pharmacies[1]->phar_id,
        ]);
    }
}
