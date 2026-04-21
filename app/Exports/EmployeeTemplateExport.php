<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\EmploymentType;
use App\Models\EmploymentStatus;
use App\Models\Education;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\Bank; 


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\DataValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeeTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new Sheets\EmployeesSheet(),

            // MASTER DATA
            new Sheets\MasterSheet('Companies', Company::pluck('company_name')),
            new Sheets\MasterSheet('Departments', Department::pluck('department_name')),
            new Sheets\MasterSheet('Positions', Position::pluck('position_name')),
            new Sheets\MasterSheet('EmploymentTypes', EmploymentType::pluck('type_name')),
            new Sheets\MasterSheet('EmploymentStatuses', EmploymentStatus::pluck('status_name')),
            new Sheets\MasterSheet('Educations', Education::pluck('education_level')),
            new Sheets\MasterSheet('MaritalStatuses', MaritalStatus::pluck('marital_status_name')),
            new Sheets\MasterSheet('Religions', Religion::pluck('religion_name')),
            new Sheets\MasterSheet('Banks', Bank::pluck('bank_name')),

            // ➕ TAMBAHAN
            new Sheets\MasterSheet('Genders', collect(['Laki-laki', 'Perempuan'])),
            new Sheets\MasterSheet('BloodTypes', collect(['A', 'B', 'AB', 'O'])),
        ];
    }

}
