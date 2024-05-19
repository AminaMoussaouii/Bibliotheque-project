<?php

namespace App\Imports;

use App\Models\Livre;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class LivresImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $image = 'images/math1.jpg';
        
        $dateEdition = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]));
    
    if (isset($row[13])) {
        $image = $row[13];
    }

        return new Livre([
            "titre"=>$row[0],
            "auteur"=>$row[1],
            "isbn"=>$row[2],
            "editeur"=>$row[3],
            "langue"=>$row[4],
            "date_edition"=>$dateEdition,
            "exp_disp"=>$row[6],
            "etage"=>$row[7],
            "rayon"=>$row[8],
            "nombre_pages"=>$row[9],
            "discipline"=>$row[10],
            "statut"=>$row[11],
            "type_ouvrage"=>$row[12],
            "image"=>$image,
        ]);

    }
}
