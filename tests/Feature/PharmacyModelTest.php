<?php

namespace Tests\Feature;

use App\Models\DrugManufacturer;
use App\Models\Employee;
use App\Models\Pharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test case for the Pharmacy model.
 *
 * This test class covers various functionalities and relationships
 * of the Pharmacy model, including:
 * - Creating and updating pharmacy records
 * - Testing the many-to-many relationship between pharmacies and drug manufacturers via contracts
 * - Testing the many-to-many relationship between pharmacies and employees via works
 */
class PharmacyModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a Pharmacy can be created successfully.
     *
     * @return void
     */
    public function test_it_can_create_a_pharmacy()
    {
        // Arrange: Prepare the data for creating a new pharmacy
        $data = [
            'name' => 'City Pharmacy',
            'address' => '456 Health St, Medical City',
            'fax' => '123-456-7890',
        ];

        // Act: Create a new Pharmacy instance with the prepared data
        $pharmacy = Pharmacy::create($data);

        // Assert: Check if the pharmacy was created successfully and attributes match
        $this->assertInstanceOf(Pharmacy::class, $pharmacy);
        $this->assertEquals('City Pharmacy', $pharmacy->name);
        $this->assertEquals('456 Health St, Medical City', $pharmacy->address);
        $this->assertEquals('123-456-7890', $pharmacy->fax);

        // Verify the data is saved in the database
        $this->assertDatabaseHas('pharmacies', $data);
    }

    /**
     * Test that a Pharmacy can be updated successfully.
     *
     * @return void
     */
    public function test_it_can_update_a_pharmacy()
    {
        // Arrange: Create a pharmacy with initial data
        $pharmacy = Pharmacy::factory()->create([
            'name' => 'Old Pharmacy',
            'address' => '789 Old St',
            'fax' => '987-654-3210',
        ]);

        // Act: Update the pharmacy's name, address, and fax
        $pharmacy->update([
            'name' => 'New Pharmacy',
            'address' => '101 New Blvd',
            'fax' => '111-222-3333',
        ]);

        // Assert: Check the updated fields
        $this->assertEquals('New Pharmacy', $pharmacy->name);
        $this->assertEquals('101 New Blvd', $pharmacy->address);
        $this->assertEquals('111-222-3333', $pharmacy->fax);

        // Verify the database was updated correctly
        $this->assertDatabaseHas('pharmacies', [
            'name' => 'New Pharmacy',
            'address' => '101 New Blvd',
            'fax' => '111-222-3333',
        ]);
        // Ensure the old data is no longer present in the database
        $this->assertDatabaseMissing('pharmacies', [
            'name' => 'Old Pharmacy',
        ]);
    }

    /**
     * Test the many-to-many relationship between Pharmacy and DrugManufacturer via contracts.
     *
     * @return void
     */
    public function test_it_belongs_to_many_drug_manufacturers_via_contracts()
    {
        // Arrange: Create a pharmacy and some drug manufacturers
        $pharmacy = Pharmacy::factory()->create();
        $manufacturers = DrugManufacturer::factory()->count(2)->create();

        // Act: Attach drug manufacturers to the pharmacy via contracts
        $pharmacy->contracts()->attach($manufacturers[0]->company_id, [
            'start_date' => now()->subYear(),
            'end_date' => now()->addYear(),
        ]);

        $pharmacy->contracts()->attach($manufacturers[1]->company_id, [
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonth(),
        ]);

        // Act: Retrieve the drug manufacturers related to the pharmacy
        $relatedManufacturers = $pharmacy->contracts;

        // Assert: Check that the relationships exist
        $this->assertCount(2, $relatedManufacturers);
        $this->assertTrue($relatedManufacturers->contains($manufacturers[0]));
        $this->assertTrue($relatedManufacturers->contains($manufacturers[1]));

        // Verify the pivot table has the correct contract data
        $this->assertDatabaseHas('contracts', [
            'phar_id' => $pharmacy->phar_id,
            'drug_manufacturer_id' => $manufacturers[0]->company_id,
            'start_date' => now()->subYear()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
        ]);
        $this->assertDatabaseHas('contracts', [
            'phar_id' => $pharmacy->phar_id,
            'drug_manufacturer_id' => $manufacturers[1]->company_id,
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
        ]);
    }

    /**
     * Test the many-to-many relationship between Pharmacy and Employee via works.
     *
     * @return void
     */
    public function test_it_belongs_to_many_employees_via_works()
    {
        // Arrange: Create a pharmacy and some employees
        $pharmacy = Pharmacy::factory()->create();
        $employees = Employee::factory()->count(2)->create();

        // Act: Attach employees to the pharmacy via works
        $pharmacy->employees()->attach($employees[0]->employee_id, [
            'shift_start' => now()->startOfDay(),
            'shift_end' => now()->endOfDay(),
        ]);

        $pharmacy->employees()->attach($employees[1]->employee_id, [
            'shift_start' => now()->startOfDay()->addDay(),
            'shift_end' => now()->endOfDay()->addDay(),
        ]);

        // Act: Retrieve the employees related to the pharmacy
        $relatedEmployees = $pharmacy->employees;

        // Assert: Check that the relationships exist
        $this->assertCount(2, $relatedEmployees);
        $this->assertTrue($relatedEmployees->contains($employees[0]));
        $this->assertTrue($relatedEmployees->contains($employees[1]));

        // Verify the pivot table has the correct work data
        $this->assertDatabaseHas('works', [
            'pharmacy_id' => $pharmacy->phar_id,
            'employee_id' => $employees[0]->employee_id,
            'shift_start' => now()->startOfDay()->toDateTimeString(),
            'shift_end' => now()->endOfDay()->toDateTimeString(),
        ]);
        $this->assertDatabaseHas('works', [
            'pharmacy_id' => $pharmacy->phar_id,
            'employee_id' => $employees[1]->employee_id,
            'shift_start' => now()->startOfDay()->addDay()->toDateTimeString(),
            'shift_end' => now()->endOfDay()->addDay()->toDateTimeString(),
        ]);
    }
}
