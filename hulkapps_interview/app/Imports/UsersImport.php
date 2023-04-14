<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function rules(): array
    {
        return [
            'email' => 'unique:users,email',
        ];
    }  

    public function customValidationMessages()
    {
        return [
            'email.unique' => 'Email Address Must be unique.',
        ];
    }

public function model(array $row)
    {
        return new User([
            'name'     => $row['name'],
            'email'    => $row['email'], 
            'password' => \Hash::make($row['password']),
            'date_of_birth' => date('Y-m-d', strtotime($row['dob'])),
            'address' => $row['address'],
        ]);
    }
}