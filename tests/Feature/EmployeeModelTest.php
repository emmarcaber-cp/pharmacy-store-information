<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Pharmacy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test case for the Employee model.
 *
 * This test class covers various functionalities and relationships
 * of the Employee model, including:
 * - Creating and updating employee records
 * - Testing the many-to-many relationship between employees and pharmacies via works
 */
class EmployeeModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an Employee can be created successfully.
     *
     * @return void
     */
    public function test_it_can_create_an_employee()
    {
        // Arrange: Prepare the data for the new employee
        $data = [
            'name' => 'John Doe',
        ];

        // Act: Create a new Employee instance
        $employee = Employee::create($data);

        // Assert: Check if the employee was created successfully and attributes match
        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertEquals('John Doe', $employee->name);

        // Verify that the employee data is saved in the database
        $this->assertDatabaseHas('employees', $data);
    }

    /**
     * Test that an Employee can be updated successfully.
     *
     * @return void
     */
    public function test_it_can_update_an_employee()
    {
        // Arrange: Create an employee with initial data
        $employee = Employee::factory()->create([
            'name' => 'Jane Doe',
        ]);

        // Act: Update the employee's name
        $employee->update([
            'name' => 'Janet Doe',
        ]);

        // Assert: Check if the employee's name is updated correctly
        $this->assertEquals('Janet Doe', $employee->name);

        // Verify the database reflects the updated employee data
        $this->assertDatabaseHas('employees', [
            'name' => 'Janet Doe',
        ]);
        // Ensure the old data is no longer in the database
        $this->assertDatabaseMissing('employees', [
            'name' => 'Jane Doe',
        ]);
    }

    /**
     * Test the many-to-many relationship between Employee and Pharmacy via works.
     *
     * @return void
     */
    public function test_it_belongs_to_many_pharmacies_via_works()
    {
        // Arrange: Create an employee and some pharmacies
        $employee = Employee::factory()->create();
        $pharmacies = Pharmacy::factory()->count(2)->create();

        // Act: Attach the pharmacies to the employee with shift details
        $employee->works()->attach($pharmacies[0]->phar_id, [
            'shift_start' => now()->startOfDay(),
            'shift_end' => now()->endOfDay(),
        ]);

        $employee->works()->attach($pharmacies[1]->phar_id, [
            'shift_start' => now()->startOfDay()->addDay(),
            'shift_end' => now()->endOfDay()->addDay(),
        ]);

        // Act: Retrieve the pharmacies related to the employee
        $relatedPharmacies = $employee->works;

        // Assert: Check that the relationships exist
        $this->assertCount(2, $relatedPharmacies);
        $this->assertTrue($relatedPharmacies->contains($pharmacies[0]));
        $this->assertTrue($relatedPharmacies->contains($pharmacies[1]));

        // Verify the pivot table has the correct work data
        $this->assertDatabaseHas('works', [
            'employee_id' => $employee->employee_id,
            'pharmacy_id' => $pharmacies[0]->phar_id,
            'shift_start' => now()->startOfDay()->toDateTimeString(),
            'shift_end' => now()->endOfDay()->toDateTimeString(),
        ]);
        $this->assertDatabaseHas('works', [
            'employee_id' => $employee->employee_id,
            'pharmacy_id' => $pharmacies[1]->phar_id,
            'shift_start' => now()->startOfDay()->addDay()->toDateTimeString(),
            'shift_end' => now()->endOfDay()->addDay()->toDateTimeString(),
        ]);
    }
}
