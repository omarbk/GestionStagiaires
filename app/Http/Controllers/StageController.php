<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stage;
use App\Groupe;
use App\Stage_groupe;
use App\Stagiaire;
use Auth;
use PDF;

class StageController extends Controller
{
        public function updateStatutStage(Request $request){
            $stage = Stage::find($request->stage['id_stage']);

            $stage->statut_stage = $request->stage['statut_stage'];
          
           
            $stage->save();
            
            return Response()->json(['etat' => true]);
        }

    public function searchStages($search_Sg){
        $stages = Stage::where('intitule_stage','like', '%' .$search_Sg . '%')->orWhere('objectif_stage','like', '%' .$search_Sg . '%')->paginate(6);
        return Response()->json(['stages' => $stages ]);
     }
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
                $stage->statut_stage = $request->stage['statut_stage'];
                $stage->semestre_stage = $request->stage['semestre_stage'];
                $stage->annee_universitaire_stage = $request->stage['annee_universitaire_stage'];

                
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
        
       
        $stage_groupe = Stage_groupe::where('fk_stage','=',$id_stage)->forceDelete();
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
        $stage->semestre_stage = $request->stage['semestre_stage'];
        $stage->annee_universitaire_stage = $request->stage['annee_universitaire_stage'];

        
        $stage->save();

        $id_stage = $stage->id_stage;
        $this->updateStageGroupes($request,$id_stage);
        
        return Response()->json(['etat' => true]);
     }

     public function updateStageGroupes(Request $request , $id_stage){

       
        
        for($i=0;$i<count($request->suppGroupes);$i++){
         $stagGroupes = Stage_groupe::where('fk_groupe',$request->suppGroupes[$i]['id_groupe'])->where('fk_stage', $id_stage)->forceDelete();
 
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
     public function getStageAnnee(){
        $stagiaire = Stagiaire::select('stagiaires.niveau_etude_stagiaire','stagiaires.annee_universitaire_stagiaire')
        ->where('stagiaires.fk_user', '=', Auth::user()->id)->get();
      // dd($stagiaire[0]->niveau_etude_stagiaire);
        $stages = Stage::select('stages.*')
        ->where('stages.annee_universitaire_stage','=',$stagiaire[0]->niveau_etude_stagiaire)
        ->where('stages.statut_stage','=','En cours')
        ->orderBy('stages.dateDebut_stage')
        ->get();

        PDF::SetTitle('stages');
        
        PDF::AddPage();
        $commandesHtml ='<table  border="1" style="padding: 3px 0px;" cellpadding="2">
     ';
             $commandesHtml.='<tbody>';
             for ($i=0; $i<count($stages); $i++) { 
                 if(isset($stages[$i+1]->semestre_stage)){
            if($stages[$i]->semestre_stage != $stages[$i+1]->semestre_stage){
                $commandesHtml.='
            
                <tr>               
                        <th style="
                        
                        border-bottom: 1px solid black;
                        border-top: 1px solid black;
                        border-left:1px solid black;
                        " align="right">'.$stages[$i]->semestre_stage.'</th>
                        <th style="
                        border-right:1px solid black;
                        border-bottom: 1px solid black;
                        border-top: 1px solid black;
                      
                        " align="center"></th>
                        
                 </tr>
                 <tr>               
                 <th style="
                 border-right:1px solid black;
                 border-bottom: 1px solid black;
                 border-top: 1px solid black;
                 border-left:1px solid black;
                 " align="center">Stage</th>
                 <th style="
                 border-right:1px solid black;
                 border-bottom: 1px solid black;
                 border-top: 1px solid black;
                 border-left:1px solid black;
                 " align="center">Période</th>
                 
                 </tr>
                 ';}}
                $commandesHtml.='
            
                <tr>               
                        <th style="
                        border-right:1px solid black;
                        border-bottom: 1px solid black;
                        border-top: 1px solid black;
                        border-left:1px solid black;
                        " align="center">'.$stages[$i]->intitule_stage.'</th>
                        <th style="
                        border-right:1px solid black;
                        border-bottom: 1px solid black;
                        border-top: 1px solid black;
                        border-left:1px solid black;
                        " align="center">'.$stages[$i]->dateDebut_stage.' au '.$stages[$i]->dateFin_stage.'</th>
                        
                 </tr>
                 ';}
                $commandesHtml.='</tbody> </table>';
                PDF::writeHTMLCell(0, 0, 70,5,'Année universitaire : '.$stagiaire[0]->annee_universitaire_stagiaire, 0, 1, 0, true, '', true);
                PDF::writeHTMLCell(0, 0, 73,11,'Année d\'étude : '.$stagiaire[0]->niveau_etude_stagiaire, 0, 1, 0, true, '', true);
                PDF::writeHTMLCell(0, 0, '',40,'<span style="color:red"> Calendrier des Stage : </span>', 0, 1, 0, true, '', true);




        PDF::writeHTMLCell(0, 0, '',50,$commandesHtml, 0, 1, 0, true, '', true);
        $y = PDF::getY()+8; 
        PDF::writeHTMLCell(0, 0, '',$y,'<span style="color:blue"> la note du stage : </span> La note du stage est composée de : <br>
        1/ la note proposée par le maitre de stage en se basant sur : <br>
        l\'assiduité <br>
        Le comportement général (vis a vis des parients , du personnel et ses camarades) <br>
        La participation au cours du stage (visites ,staff,...) <br>
        La capacité de s\'autoformer <br>
        La progression durant le stage <br>
        La validation des objectifs <br>
        2/ l\'examen de fin de  stage <br>
        3/ l\'examen stage de simulation et cas cliniques', 0, 1, 0, true, '', true);
        PDF::Output('stages.pdf');
       // return Response()->json(['stage' => $stage]);
      }


}
