<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Facture;
use App\Commande;

use App\Total_note;
use Illuminate\Support\Facades\DB;
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
}
