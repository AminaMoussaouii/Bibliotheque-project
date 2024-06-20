<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Emprunt;
use Carbon\Carbon;

class UpdateLateFees extends Command
{
    protected $signature = 'emprunts:update-late-fees';
    protected $description = 'Mettre à jour le nombre de jours de retard des emprunts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $emprunts = Emprunt::whereNull('date_retour')->where('date_limite', '<', now())->get();

        foreach ($emprunts as $emprunt) {
            $dateLimite = Carbon::parse($emprunt->date_limite);
            $nbrJrsRetard = $dateLimite->diffInDays(now(), false);
            $nbrJrsRetard = $nbrJrsRetard > 0 ? $nbrJrsRetard : 0;
            $emprunt->nbr_jrs_retard = $nbrJrsRetard;
            $emprunt->save();
        }

        $this->info('Les frais de retard ont été mis à jour.');
    }
}
