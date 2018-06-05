<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluateur;
use Illuminate\Support\Facades\DB;
use App\Stagiaire;
use App\Responsable;
use App\Stage;
class DashboardController extends Controller
{
   
   public function getCountAllEvaluateurs(){
     
    $countEvaluateurs = Evaluateur::all()->count();
             return Response()->json(['countEvaluateurs' => $countEvaluateurs ]);
}
public function getCountAllStagiaires(){
     
    $countStagiaire = Stagiaire::all()->count();
             return Response()->json(['countStagiaire' => $countStagiaire ]);
}
public function getCountAllResponsables(){
     
    $countResponsable = Responsable::all()->count();
             return Response()->json(['countResponsable' => $countResponsable ]);
}
public function getCountAllStages(){
     
    $countStage = Stage::all()->count();
             return Response()->json(['countStage' => $countStage ]);
}
}
