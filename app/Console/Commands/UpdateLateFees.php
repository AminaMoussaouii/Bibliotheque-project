<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Emprunt;
use Carbon\Carbon;

class UpdateLateFees extends Command
{
    protected $signature = 'emprunts:update-late-fees';
    protected $description = 'Update the late fees for overdue emprunts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $emprunts = Emprunt::whereNull('date_retour')->where('date_limite', '<', now())->get();

        foreach ($emprunts as $emprunt) {
            $dateLimite = Carbon::parse($emprunt->date_limite);
            $nbrJrsRetard = now()->diffInDays($dateLimite, false);
            $nbrJrsRetard = $nbrJrsRetard > 0 ? 0 : abs($nbrJrsRetard);
            $emprunt->nbr_jrs_retard = $nbrJrsRetard;
            $emprunt->save();
        }

        $this->info('Late fees updated successfully.');
    }
}
