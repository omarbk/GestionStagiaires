<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluation_objectif;
use App\Evaluation;
use App\Note;
use App\Total_note;
use App\Note_type;
// 
class NoteController extends Controller
{
    public function addEvaluation(Request $request){
      //dd($request->evaluation);
            $evaluation = new Evaluation();
     
        $evaluation->fk_stagiaire = $request->evaluation['fk_stagiaire'];
        $evaluation->fk_evaluateur = $request->evaluation['fk_evaluateur'];
       

        $evaluation->save();  
        $id=$evaluation->id_evaluation;
        //dd($id);
        $this->addNotes($request,$id);
        $this->addTotalNotes($request,$id);
        $this->addTotalNoteType($request,$id);
        return Response()->json(['etat' => true ]);
    }

    public function addNotes(Request $request,$id)
    { 
           for($i=0;$i<count($request->objectifs);$i++) { 
        $objectif = new Note();

        $objectif->fk_evaluation=$id;
        $objectif->fk_objectif=$request->objectifs[$i]['id_evaluation_objectif'];
        $objectif->note=$request->notes[$i];
        //dd($objectif);

                $objectif->save();
               
           }
         //  $id=$objectif->fk_evaluation;
          // dd($id);
                // return Response()->json(['etat' => true]);

    }

    public function addTotalNoteType($request,$id){
//dd($request);
        for($i=0;$i<count($request->type_objectifs);$i++) { 
            $noteType = new Note_type();
    
            $noteType->fk_evaluation=$id;
            $noteType->fk_type_objectif=$request->type_objectifs[$i]['id_type'];
            $noteType->note_type=$request->noteType[$i];
            //dd($objectif);
    
                    $noteType->save();
                   
               }
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
                     $this->updateTotalNoteType($request,$id);
         }

         public function addTotalNotes(Request $request,$id)
         { 
               
             $total_note = new Total_note();  
             $total_note->fk_evaluation=$id;
             $total_note->totalNotes=$request->totalNote['totalNotes'];
             $total_note->noteStage=$request->totalNote['noteStage'];
             $total_note->noteFinal=$request->totalNote['noteFinal'];
             $total_note->commentaire=$request->totalNote['commentaire'];
             $total_note->nombreAbsence=$request->totalNote['count'];
             $total_note->etat=$request->totalNote['etat'];

             //dd($objectif);

                     $total_note->save();
                
                     // return Response()->json(['etat' => true]);
                 
         }

         public function updateTotalNotes(Request $request,$id)
         {         
                 //dd($request);        
            $total_note = Total_note::find($request->objectifs[0]['id_total_note']);

             $total_note->fk_evaluation=$id;
             $total_note->totalNotes=$request->objectifs[0]['totalNotes'];
             $total_note->noteStage=$request->objectifs[0]['noteStage'];
             $total_note->noteFinal=$request->objectifs[0]['noteFinal'];
             $total_note->commentaire=$request->objectifs[0]['commentaire'];
             $total_note->nombreAbsence=$request->objectifs[0]['nombreAbsence'];
             $total_note->etat=$request->objectifs[0]['etat'];

             //dd($objectif);

                     $total_note->save();
                 
                     
                     // return Response()->json(['etat' => true]);
                 
         }
         public function updateTotalNoteType($request,$id){
            //dd($request);
                    for($i=0;$i<count($request->typeObjectifs);$i++) { 
                        $noteType = Note_type::find($request->typeObjectifs[$i]['id_note_type']);
                
                        $noteType->fk_evaluation=$id;
                        $noteType->fk_type_objectif=$request->typeObjectifs[$i]['id_type'];
                        $noteType->note_type=$request->typeObjectifs[$i]['note_type'];
                        //dd($objectif);
                
                                $noteType->save();
                               
                           }
                }
}
