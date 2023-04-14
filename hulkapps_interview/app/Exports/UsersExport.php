<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection,WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select('name','email','date_of_birth','address')->where('role_as','!=','1')->get();
    }

    public function headings(): array
    {
        return ["Name", "Email", "Date Of Birth",'Address'];
    }

    public function columnWidths(): array
    {
        return [
            'a' => 35,
            'B' => 35, 
            'c' => 35,
            'D' => 35          
        ];
    }
}
