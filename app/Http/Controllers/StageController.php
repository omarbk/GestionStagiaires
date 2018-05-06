<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stage;
use App\Groupe;
use App\Stage_groupe;

class StageController extends Controller
{
    public function addStage(Request $request)
    { 
 
        
        $stage = new Stage();
 
              
                $stage->intitule_stage = $request->stage['intitule_stage'];
                $stage->objectif_stage = $request->stage['objectif_stage'];
                $stage->duree_stage = $request->stage['duree_stage'];
                $stage->dateDebut_stage = $request->stage['dateDebut_stage'];
                $stage->dateFin_stage = $request->stage['dateFin_stage'];
                $stage->fk_hospitalier = $request->stage['fk_hospitalier'];
                $stage->fk_evaluateur = $request->stage['fk_evaluateur'];
               
                $stage->save();
                $id_stage = $stage->id_stage;



               
                $this->addStage_groupes($request,$id_stage);
                 return Response()->json(['etat' => true]);
            
    }
    public function addStage_groupes(Request $request,$id_stage)
    { 
        
           for($i=0;$i<count($request->pushGroupes);$i++) {    
            $stage_groupe = new Stage_groupe();
            $stage_groupe->fk_groupe=$request->pushGroupes[$i]['id_groupe'];
            $stage_groupe->fk_stage=$id_stage;
            $stage_groupe->save();

           }
                // return Response()->json(['etat' => true]);
            
    }

    public function getStages(){

        $listeStages = Stage::paginate(10);
        
        return Response()->json(['stages' => $listeStages ]);
     }

     public function deleteStage($id_stage){

        $stage = Stage::find($id_stage)->delete();
        $stage_groupe = Stage_groupe::where('fk_stage','=',$id_stage)->delete();
        return Response()->json(['delete' => 'true']);
     }

     public function getStage($id_stage){
        $stage= Stage::leftJoin('hospitaliers', 'hospitaliers.id_hospitalier', '=', 'stages.fk_hospitalier')
        ->leftJoin('evaluateurs', 'evaluateurs.id_evaluateur', '=', 'stages.fk_evaluateur')
        ->select('hospitaliers.*','evaluateurs.*','stages.*')
        ->where('stages.id_stage','=',$id_stage)
        ->get();
        $stage_groupes = Stage_groupe::leftJoin('groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
        ->select('groupes.*','stage_groupes.*')
        ->where('stage_groupes.fk_stage','=',$id_stage)->get();
        return Response()->json(['stage' => $stage,'stage_groupes' => $stage_groupes]);
     }
     public function updateStage(Request $request){

        $stage = Stage::find($request->stage['id_stage']);

        $stage->intitule_stage = $request->stage['intitule_stage'];
        $stage->objectif_stage = $request->stage['objectif_stage'];
        $stage->duree_stage = $request->stage['duree_stage'];
        $stage->dateDebut_stage = $request->stage['dateDebut_stage'];
        $stage->dateFin_stage = $request->stage['dateFin_stage'];
        $stage->fk_hospitalier = $request->stage['fk_hospitalier'];
        $stage->fk_evaluateur = $request->stage['fk_evaluateur'];
       
        $stage->save();

        $id_stage = $stage->id_stage;
        $this->updateStageGroupes($request,$id_stage);
        
        return Response()->json(['etat' => true]);
     }

     public function updateStageGroupes(Request $request , $id_stage){

       
        
        for($i=0;$i<count($request->suppGroupes);$i++){
         $stagGroupes = Stage_groupe::where('fk_groupe',$request->suppGroupes[$i]['id_groupe'])->where('fk_stage', $id_stage)->delete();
 
         }
        for($i=0;$i<count($request->stage_groupes);$i++){
             if (!isset($request->stage_groupes[$i]['fk_stage'])) {
                $Stage_groupe = new Stage_groupe();
                $Stage_groupe->fk_groupe=$request->stage_groupes[$i]['id_groupe'];
                $Stage_groupe->fk_stage=$id_stage;
                $Stage_groupe->save();
             }    
         }
      }


}
