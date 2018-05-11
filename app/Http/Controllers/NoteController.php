<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluation_objectif;
use App\Evaluation;
use App\Note;
use App\Total_note;

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
        $this->addTotalNotes($request,$id);
        return Response()->json(['etat' => true ]);
    }

        
         public function updateNotes(Request $request)
         { 
                for($i=0;$i<count($request->objectifs);$i++) { 
             $objectif = Note::find($request->objectifs[$i]['id_note']);

             $objectif->fk_evaluation=$request->objectifs[$i]['fk_evaluation'];
             $objectif->fk_objectif=$request->objectifs[$i]['id_evaluation_objectif'];
             $objectif->note=$request->objectifs[$i]['note'];
             //dd($objectif);

                     $objectif->save();
                    
                }
                $id=$objectif->fk_evaluation;
               // dd($id);
                     // return Response()->json(['etat' => true]);
                     $this->updateTotalNotes($request,$id);

         }

         public function addTotalNotes(Request $request,$id)
         { 
               
             $total_note = new Total_note();  
             $total_note->fk_evaluation=$id;
             $total_note->totalNotes=$request->totalNote['totalNotes'];
             $total_note->noteStage=$request->totalNote['noteStage'];
             $total_note->noteFinal=$request->totalNote['noteFinal'];
             $total_note->commentaire=$request->totalNote['commentaire'];

             //dd($objectif);

                     $total_note->save();
                
                     // return Response()->json(['etat' => true]);
                 
         }

         public function updateTotalNotes(Request $request,$id)
         {                 
            $total_note = Total_note::find($request->objectifs[0]['id_total_note']);

             $total_note->fk_evaluation=$id;
             $total_note->totalNotes=$request->objectifs[0]['totalNotes'];
             $total_note->noteStage=$request->objectifs[0]['noteStage'];
             $total_note->noteFinal=$request->objectifs[0]['noteFinal'];
             $total_note->commentaire=$request->objectifs[0]['commentaire'];

             //dd($objectif);

                     $total_note->save();
                
                     // return Response()->json(['etat' => true]);
                 
         }
}
