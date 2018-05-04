<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groupe;
use App\Calendrier;
use App\Groupe_stagiaire;
use App\Stagiaire;
class GroupeController extends Controller
{
    public function addGroupe(Request $request)
    { 
      
        
        $groupe = new Groupe();
 
                $groupe->nom_groupe = $request->groupe['nom_groupe'];
                $groupe->annee_universitaire_groupe = $request->groupe['annee_universitaire_groupe'];                
                $groupe->save();
                $id_groupe = $groupe->id_groupe;
                $this->addCalendrier($request,$id_groupe);
                $this->addGroupe_Stagiaires($request,$id_groupe);
                 return Response()->json(['etat' => true]);
            
    }
   
    public function addGroupe_Stagiaires(Request $request,$id_groupe)
    { 
        
           for($i=0;$i<count($request->pushStagiaire);$i++) {    
            $groupe_stagiaire = new Groupe_stagiaire();
            $groupe_stagiaire->fk_stagiaire=$request->pushStagiaire[$i]['id_stagiaire'];
            $groupe_stagiaire->fk_groupe=$id_groupe;
            $groupe_stagiaire->save();
           }
                // return Response()->json(['etat' => true]);
            
    }










    public function addCalendrier(Request $request,$id_groupe)
    { 
        
           for($i=0;$i<count($request->calendriers);$i++) {    
        $calendrier = new Calendrier();  
        $calendrier->nomMoisDebut=$request->calendriers[$i]['nomMoisDebut'];
        $calendrier->nomMoisFin=$request->calendriers[$i]['nomMoisFin'];
        $calendrier->mois_stage_cal=$request->calendriers[$i]['mois_stage_cal'];
        $calendrier->debut_semaine_cal=$request->calendriers[$i]['debut_semaine_cal'];
        $calendrier->fin_semaine_cal=$request->calendriers[$i]['fin_semaine_cal'];
        $calendrier->NbJours=$request->calendriers[$i]['NbJours'];
        $calendrier->lundi_cal=$request->calendriers[$i]['lundi_cal'];
        $calendrier->mardi_cal=$request->calendriers[$i]['mardi_cal'];
        $calendrier->mercredi_cal=$request->calendriers[$i]['mercredi_cal'];
        $calendrier->jeudi_cal=$request->calendriers[$i]['jeudi_cal'];
        $calendrier->vendredi_cal=$request->calendriers[$i]['vendredi_cal'];
        $calendrier->fk_groupe=$id_groupe;
        
                $calendrier->save();
           }

        

                // return Response()->json(['etat' => true]);
            
    }
    public function getGroupes(){

        $listeGroupes = Groupe::paginate(10);
        
        return Response()->json(['groupes' => $listeGroupes ]);
     }

     public function deleteGroupe($id_groupe){

        $groupe = Groupe::find($id_groupe)->delete();
        $calendrier = Calendrier::where('fk_groupe','=',$id_groupe)->delete();
        return Response()->json(['delete' => 'true']);
     }
     public function getGroupe($id_groupe){
        $groupe= Groupe::find($id_groupe);
        $groupe_stagiaire = Groupe_stagiaire::leftJoin('stagiaires', 'stagiaires.id_stagiaire', '=', 'groupe_stagiaires.fk_stagiaire')
        ->select('stagiaires.*','groupe_stagiaires.*')
        ->where('groupe_stagiaires.fk_groupe','=',$id_groupe)->get();
        return Response()->json(['groupe' => $groupe,'groupe_stagiaire' => $groupe_stagiaire]);
     }
     
     public function getCalendriers($fk_groupe){
        $calendriers= Calendrier::where('fk_groupe', $fk_groupe)->get();
        return Response()->json(['calendriers' => $calendriers ]);
     }

     public function updateGroupe(Request $request){

        $groupe = Groupe::find($request->groupe['id_groupe']);

        $groupe->nom_groupe = $request->groupe['nom_groupe'];
        $groupe->annee_universitaire_groupe = $request->groupe['annee_universitaire_groupe'];
        $groupe->save();
        $id_groupe = $groupe->id_groupe;
        $this->updateCalendrier($request,$id_groupe);
        $this->updateGroupeStagiaire($request,$id_groupe);

        return Response()->json(['etat' => true]);
     }

     public function updateCalendrier(Request $request , $id_groupe){

        for($i=0;$i<count($request->suppCalendriers);$i++){
         $calendrier = Calendrier::find($request->suppCalendriers[$i]['id_calendrier']);
         $calendrier->delete();
 
         }
         for($i=0;$i<count($request->calendriers);$i++){
             if (!isset($request->calendriers[$i]['id_calendrier'])) {
                 $calendrier = new Calendrier();
                 $calendrier->nomMoisDebut=$request->calendriers[$i]['nomMoisDebut'];
                 $calendrier->nomMoisFin=$request->calendriers[$i]['nomMoisFin'];
                 $calendrier->mois_stage_cal=$request->calendriers[$i]['mois_stage_cal'];
                 $calendrier->debut_semaine_cal=$request->calendriers[$i]['debut_semaine_cal'];
                 $calendrier->fin_semaine_cal=$request->calendriers[$i]['fin_semaine_cal'];
                 $calendrier->NbJours=$request->calendriers[$i]['NbJours'];
                 $calendrier->lundi_cal=$request->calendriers[$i]['lundi_cal'];
                 $calendrier->mardi_cal=$request->calendriers[$i]['mardi_cal'];
                 $calendrier->mercredi_cal=$request->calendriers[$i]['mercredi_cal'];
                 $calendrier->jeudi_cal=$request->calendriers[$i]['jeudi_cal'];
                 $calendrier->vendredi_cal=$request->calendriers[$i]['vendredi_cal'];
                 $calendrier->fk_groupe=$id_groupe;
                 $calendrier->save();
             }    
         }
         for($i=0;$i<count($request->calendriers);$i++){
             if (isset($request->calendriers[$i]['id_calendrier'])) {
         Calendrier::where('id_calendrier','=', $request->calendriers[$i]['id_calendrier'])->update([
         "nomMoisDebut" => $request->calendriers[$i]['nomMoisDebut'],
         "nomMoisFin" => $request->calendriers[$i]['nomMoisFin'],
         "mois_stage_cal" => $request->calendriers[$i]['mois_stage_cal'],
         "debut_semaine_cal" => $request->calendriers[$i]['debut_semaine_cal'],
         "fin_semaine_cal" => $request->calendriers[$i]['fin_semaine_cal'],
         "NbJours" => $request->calendriers[$i]['NbJours'],
         "lundi_cal" => $request->calendriers[$i]['lundi_cal'],
         "mardi_cal" => $request->calendriers[$i]['mardi_cal'],
         "mercredi_cal" => $request->calendriers[$i]['mercredi_cal'],
         "jeudi_cal" => $request->calendriers[$i]['jeudi_cal'],
         "vendredi_cal" => $request->calendriers[$i]['vendredi_cal'], 
         ]);
             }
         }
  
      }

      public function updateGroupeStagiaire(Request $request , $id_groupe){

       
        
        for($i=0;$i<count($request->suppStagiaires);$i++){
         $calendrier = Groupe_stagiaire::where('fk_stagiaire',$request->suppStagiaires[$i]['id_stagiaire'])->where('fk_groupe', $id_groupe)->delete();
 
         }
        for($i=0;$i<count($request->pushStagiaire);$i++){
             if (!isset($request->pushStagiaire[$i]['fk_groupe'])) {
                $groupe_stagiaire = new Groupe_stagiaire();
                $groupe_stagiaire->fk_stagiaire=$request->pushStagiaire[$i]['id_stagiaire'];
                $groupe_stagiaire->fk_groupe=$id_groupe;
                $groupe_stagiaire->save();
             }    
         }
         
 
  
      }
}
