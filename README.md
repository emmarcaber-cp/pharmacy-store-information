# Pharmacy Store Information

## Overview

The Pharmacy Store Information is a Laravel application designed to manage pharmacies, employees, patients, and drug manufacturers. The application includes features for managing pharmacy records, employee assignments, patient prescriptions, and drug manufacturer contracts.

## Features

-   **Pharmacy Management**: Create, update, and manage pharmacy records.
-   **Employee Management**: Assign employees to pharmacies, manage shifts.
-   **Patient Management**: Create and update patient records, handle prescriptions.
-   **Drug Manufacturer Management**: Manage contracts with drug manufacturers.

## Installation

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Laravel >= 11.x
-   MySQL or another supported database

### Steps

1. **Clone the Repository**

    ```bash
    git clone https://github.com/emmarcaber-cp/pharmacy-store-information.git
    cd pharmacy-store-information
    ```

2. **Install Dependencies**

    ```bash
    composer install
    ```

3. **Set Up Environment**
   Copy the .env.example file to .env:

    ```bash
    copy .env .example
    ```

4. **Generate the application key:**

    ```bash
     php artisan key:generate
    ```

5. **Configure Database**

    ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=pharmacy_store_information
     DB_USERNAME=root
     DB_PASSWORD=
    ```

6. **Run migrations:**

    ```bash
    php artisan migrate
    ```

## Testing

To run the tests, use:

```bash
php artisan test
```

### Available Tests

-   **DoctorModelTest**: Tests the creation, updating, and relationships of the Doctor model.
-   **DrugModelTest**: Tests the creation, updating, and relationships of the Drug model.
-   **DrugManufacturerModelTest**: Tests the creation, updating, and relationships of the Doctor model.
-   **EmployeeModelTest**: Tests the creation, updating, and relationships of the Employee model.
-   **PatientModelTest**: Tests the creation, updating, and relationships of the Patient model.
-   **PharmacyModelTest**: Tests the creation, updating, and relationships of the Pharmacy model.

### Project Structure

-   **app/**: Contains the application's core code including models, controllers, and services.
-   **database/**: Contains migrations, seeds, and model factories.
-   **tests/**: Contains test cases for the application.
