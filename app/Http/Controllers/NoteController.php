<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluation_objectif;
use App\Evaluation;
use App\Note;

class NoteController extends Controller
{
    public function addEvaluation(Request $request){
      
            $evaluation = new Evaluation();
     
        $evaluation->fk_stagiaire = $request->evaluation['fk_stagiaire'];
        $evaluation->fk_evaluateur = 1;
       

        $evaluation->save();  
        $id=$evaluation->id_evaluation;
        //dd($id);
        $this->addNotes($request,$id);
        return Response()->json(['etat' => true ]);
    }

         // ajouter les commandes de devis
         public function addNotes(Request $request,$id)
         { 
                for($i=0;$i<count($request->objectifs);$i++) {    
             $objectif = new Note();  
             $objectif->fk_evaluation=$id;
             $objectif->fk_objectif=$request->objectifs[$i]['id_evaluation_objectif'];
             $objectif->note=$request->objectifs[$i]['note'];
             //dd($objectif);

                     $objectif->save();
                }
                     // return Response()->json(['etat' => true]);
                 
         }
}
