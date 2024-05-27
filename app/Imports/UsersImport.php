<?php

namespace App\Imports;

use App\Models\UserLibrary;
use Maatwebsite\Excel\Concerns\ToModel;



    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   class UsersImport implements ToModel
    {
        public function model(array $row)
        {
            return new UserLibrary([
                'nom' => $row[0],
                'prénom' => $row[1],
                'email' => $row[2],
                'password' => $row[3],
                'Role' => $row[4],
                'Tél' => $row[5],
            ]);
        }
    }
    