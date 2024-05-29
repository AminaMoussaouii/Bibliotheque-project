<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprunt;
use App\Models\Livre;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class StatistiquesController extends Controller
{
    
    public function empruntsParMois()
    {
        $emprunts = DB::table('emprunts')
        ->select(
            DB::raw('COUNT(id) as count'),
            DB::raw('MONTH(created_at) as month')
        )
        ->groupBy('month')
        ->get();

    $data = array_fill(0, 12, 0); 

    foreach ($emprunts as $emprunt) {
        $data[$emprunt->month - 1] = $emprunt->count; 
    }

    return response()->json($data);
    }

    public function empruntsParDiscipline()
    {
        $emprunts = DB::table('emprunts')
            ->join('livres', 'emprunts.livre_id', '=', 'livres.id')
            ->select(
                DB::raw('COUNT(emprunts.id) as count'),
                'livres.discipline'
            )
            ->groupBy('livres.discipline')
            ->get();

        $data = [];
        foreach ($emprunts as $emprunt) {
            $data[$emprunt->discipline] = $emprunt->count;
        }

        return response()->json($data);
    }

    public function empruntsQuotidiens()
{
    $aujourdHui = \Carbon\Carbon::today();
    $nombreEmprunts = Emprunt::whereDate('created_at', $aujourdHui)->count();
    return response()->json($nombreEmprunts);
}


}

