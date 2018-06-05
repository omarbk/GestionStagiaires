<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Facture;
use App\Commande;

use App\Total_note;
use App\Evaluateur;
use Illuminate\Support\Facades\DB;
use App\Stagiaire;
use App\Responsable;
use App\Stage;
class DashboardController extends Controller
{
   public function getArticlePlusVente(){

    $listeArticles = Article::leftJoin('commandes','commandes.fk_article','=','articles.id_article')
    ->select('articles.designation',DB::raw("SUM(commandes.quantite_cmd) as count"))
    ->where('commandes.fk_document','like', '%' .'F'. '%')
    ->groupBy('articles.designation')->orderBy('count', 'desc')->limit(6)->get();
    
    return Response()->json(['articles' => $listeArticles ]);



    //,Commande::raw("SUM(commandes.quantite_cmd) as count")
   }//where('designation','like', '%' .$desig . '%')


   public function getEtatNotes(){
    $etatNotes = Total_note::leftJoin('evaluations', 'evaluations.id_evaluation', '=', 'total_notes.fk_evaluation')
    ->select('total_notes.etat',DB::raw("SUM(evaluations.fk_stagiaire) as total"))
   // ->where('status.type_status','=','validé')
    ->groupBy('total_notes.etat')
    ->get();
    //dd($etatNotes);
    return Response()->json(['etatNotes' => $etatNotes ]);
   }
   
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
