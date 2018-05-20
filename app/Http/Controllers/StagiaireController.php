<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Type_objectif; 
use App\Stagiaire;
use App\Evaluation;
use App\Stage;
use App\User;
use App\Evaluateur;
use App\Evaluation_objectif;
use PDF;
class StagiaireController extends Controller
{
    public function countUser(){
        $count = User::withTrashed()->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }
    
    public function addUserStagiaire(Request $request){
       // dd($request);
    $user = new User();
    $user->id = $request->user['id'];
    $user->email=$request->user['email'];
    $user->role=$request->user['role'];
    $user->password =  Hash::make($request->password);
    $user->save();
    $id=$user->id;
    $this->addStagiaire($request,$id);
    return Response()->json(['etat'=>true]);
    }
    
    public function updateUser(Request $request){

        $user = User::find($request->stagiaire['id']);
        $user->id = $request->stagiaire['id'];
        $user->email=$request->stagiaire['email'];
        $user->role=$request->stagiaire['role'];
        $user->password =  Hash::make($request->password);

        $user->save();
        //$id = $user->id;
       // $this->updatestagiaire($request,$id);
        return Response()->json(['etat' => true]);
    }

    public function addStagiaire(Request $request,$id){
        $stagiaire = new Stagiaire();

        if($request->stagiaire['photo_stagiaire'])
        {  
            if(strlen($request->stagiaire['photo_stagiaire']) < 40 ){
             $stagiaire->photo_stagiaire = $request->stagiaire['photo_stagiaire'];
            }
            else {
           $image = $request->stagiaire['photo_stagiaire'];
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          $image2 = \Image::make($request->stagiaire['photo_stagiaire']);     
           Storage::put('images/'.$name, (string) $image2->encode());
           $stagiaire->photo_stagiaire = $name;}
         }
         else  {
             $stagiaire->photo_stagiaire = "";
         }


        $stagiaire->nom_stagiaire = $request->stagiaire['nom_stagiaire'];
        $stagiaire->prenom_stagiaire = $request->stagiaire['prenom_stagiaire'];
        $stagiaire->adresse_stagiaire = $request->stagiaire['adresse_stagiaire'];
        $stagiaire->tel_stagiaire = $request->stagiaire['tel_stagiaire'];
        $stagiaire->dateNaissance_stagiaire = $request->stagiaire['dateNaissance_stagiaire'];
        $stagiaire->specialite_stagiaire = $request->stagiaire['specialite_stagiaire'];
        $stagiaire->annee_universitaire_stagiaire = $request->stagiaire['annee_universitaire_stagiaire'];
        $stagiaire->niveau_etude_stagiaire = $request->stagiaire['niveau_etude_stagiaire'];

        
        $stagiaire->fk_user = $request->stagiaire['fk_user'];

        $stagiaire->save();

        $user = User::find($id);
        $user->photo =$stagiaire->photo_stagiaire;
        $user->save();      
      
        
        return Response()->json(['etat' => true ]);
        

    }

    public function updateStagiaire(Request $request){     
         $stagiaire = Stagiaire::find($request->stagiaire['id_stagiaire']);

         
         if($request->stagiaire['photo_stagiaire'])
        {  
            if(strlen($request->stagiaire['photo_stagiaire']) < 40 ){
             $stagiaire->photo_stagiaire = $request->stagiaire['photo_stagiaire'];
            }
            else {
           $image = $request->stagiaire['photo_stagiaire'];
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           if( $stagiaire->photo_stagiaire !=""){
           Storage::disk('local')->delete('images/'.$stagiaire->photo_stagiaire);
           }
 
           $image2 = \Image::make($request->stagiaire['photo_stagiaire']);     
           Storage::put('images/'.$name, (string) $image2->encode());
           $stagiaire->photo_stagiaire = $name;}
         }
         else  {
             $stagiaire->photo_stagiaire = "";
         }
                 
 
         
         $stagiaire->nom_stagiaire = $request->stagiaire['nom_stagiaire'];
         $stagiaire->prenom_stagiaire = $request->stagiaire['prenom_stagiaire'];
         $stagiaire->adresse_stagiaire = $request->stagiaire['adresse_stagiaire'];
         $stagiaire->tel_stagiaire = $request->stagiaire['tel_stagiaire'];
         $stagiaire->specialite_stagiaire = $request->stagiaire['specialite_stagiaire'];
         $stagiaire->annee_universitaire_stagiaire = $request->stagiaire['annee_universitaire_stagiaire'];
         $stagiaire->niveau_etude_stagiaire = $request->stagiaire['niveau_etude_stagiaire'];
         $stagiaire->fk_user =  $request->stagiaire['fk_user'];
                 $stagiaire->save();

        $user = User::find($stagiaire->fk_user);
        $user->photo =$stagiaire->photo_stagiaire;
        $user->save(); 
                  return Response()->json(['etat' => true]);
    }


    public function getStagiaires(){
     
        $stagiaires = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')
                    ->select('stagiaires.*', 'users.*')
                    ->where('users.role','=','stagiaire')
                    ->paginate(6);
                 return Response()->json(['stagiaires' => $stagiaires ]);
    }
    
    public function getAllStagiaires(){
     
        $stagiaires = Stagiaire::all();
                 return Response()->json(['stagiaires' => $stagiaires ]);
    }
              
    public function getStagiaire($id_stagiaire){    
                $stagiaires = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')
                      ->leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
                      ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
                      ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
                      ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
                
                            ->select('stagiaires.*', 'users.*','stages.*','groupes.*')
                            ->where('stagiaires.id_stagiaire','=',$id_stagiaire)
                            ->get();
                           // dd($stagiaire);

                         return Response()->json(['stagiaires' => $stagiaires]);
    }
     
    public function searchStagiaire($search_S){
        $stagiaires = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')->where('nom_stagiaire','like', '%' .$search_S . '%')->orWhere('prenom_stagiaire','like', '%' .$search_S . '%')->paginate(6);
        return Response()->json(['stagiaires' => $stagiaires ]);
     }





    public function deleteStagiaire($fk_user){
        $stagiaire = Stagiaire::where('fk_user','=',$fk_user)->first();
        if( $stagiaire->photo_stagiaire !=""){
            Storage::disk('local')->delete('images/'.$stagiaire->photo_stagiaire);
            }
             $stagiaire->delete(); 
        $user = User::where('id','=',$fk_user)->delete(); 
        return Response()->json(['delete' => 'true']);
    }

    public function getAllStagiairesEval(){
     
        $stagiaires = Stagiaire::all();
        $evaluations = Evaluation::all();
                 return Response()->json(['stagiaires' => $stagiaires ,'evaluations'=>$evaluations]);
    }

    
    public function getStagiairesParEvaluateur(){
        $evaluateurs = Evaluateur::select('evaluateurs.*')
                      ->where('evaluateurs.fk_user', '=', Auth::user()->id)->get();
                    
        
      $stagiaires  = Stagiaire::leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
                      ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
                      ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
                      ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
                      ->select('stagiaires.*','stages.intitule_stage','stages.fk_evaluateur','groupes.nom_groupe','stages.*')
                      ->where('stages.fk_evaluateur', '=',$evaluateurs[0]->id_evaluateur)
                      ->where('stages.statut_stage','=','En cours')
                      ->paginate(6);

                 return Response()->json(['stagiaires' => $stagiaires]);
                 
    }

    
      // pour responsable
    public function getStagiairesParResponsable(){
       // $evaluateurs = Evaluateur::select('evaluateurs.*')
                     // ->where('evaluateurs.fk_user', '=', Auth::user()->id)->get();
                    
        
      $stagiaires  = Stagiaire::leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
                      ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
                      ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
                      ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
                      ->select('stagiaires.*','stages.intitule_stage','stages.*','groupes.nom_groupe')
                      ->paginate(6);

                 return Response()->json(['stagiaires' => $stagiaires]);
                 
    }

    public function searchStagiaireParStageGroupe(Request $request){
    //    $stagiaires = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')->where('nom_stagiaire','like', '%' .$search_SG . '%')->orWhere('prenom_stagiaire','like', '%' .$search_SG . '%')->paginate(6);
        
                $evaluateurs = Evaluateur::select('evaluateurs.*')
                      ->where('evaluateurs.fk_user', '=', Auth::user()->id)->get();
                    
        
      $stagiaires  = Stagiaire::leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
                      ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
                      ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
                      ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
                      ->select('stagiaires.*','stages.intitule_stage','stages.fk_evaluateur','groupes.nom_groupe','stages.*')
                      ->where('stages.fk_evaluateur', '=',$evaluateurs[0]->id_evaluateur)
                      ->where('stages.statut_stage','=','En cours')
                      ->where('stages.intitule_stage','like', '%' .$request->searchStage . '%')
                      ->where('groupes.nom_groupe','like', '%' .$request->searchGroupe . '%')
                      ->where('stagiaires.niveau_etude_stagiaire','like', '%' .$request->searchNiveauE . '%')
                      ->paginate(6);
                      //->orWhere('groupes.nom_groupe','like', '%' .$search_groupe . '%')
                      //->orWhere('stagiaires.niveau_etude_stagiaire','like', '%' .$search_niveau . '%')
                      

                 return Response()->json(['stagiaires' => $stagiaires]);
     }
    // pour responsable
    public function searchStagiaireParStageGroupePrResp(Request $request){
        //    $stagiaires = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')->where('nom_stagiaire','like', '%' .$search_SG . '%')->orWhere('prenom_stagiaire','like', '%' .$search_SG . '%')->paginate(6);
            
                //    $evaluateurs = Evaluateur::select('evaluateurs.*')
                        //  ->where('evaluateurs.fk_user', '=', Auth::user()->id)->get();
                        
            
          $stagiaires  = Stagiaire::leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
                          ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
                          ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
                          ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
                          ->select('stagiaires.*','stages.intitule_stage','stages.fk_evaluateur','groupes.nom_groupe')
                          //->where('stages.fk_evaluateur', '=',$evaluateurs[0]->id_evaluateur)
                          //->where('stages.statut_stage','=','En cours')
                          ->where('stages.intitule_stage','like', '%' .$request->searchStage . '%')
                          ->where('groupes.nom_groupe','like', '%' .$request->searchGroupe . '%')
                          ->where('stagiaires.niveau_etude_stagiaire','like', '%' .$request->searchNiveauE . '%')
                          ->paginate(6);
                          //->orWhere('groupes.nom_groupe','like', '%' .$search_groupe . '%')
                          //->orWhere('stagiaires.niveau_etude_stagiaire','like', '%' .$search_niveau . '%')
                          
    
                     return Response()->json(['stagiaires' => $stagiaires]);
         }





// pour evaluationnnnn
public function getStagiairesParEvaluation(Request $request){
    $stagiaires  = Stagiaire::leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
    ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
    ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
    ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
    ->leftJoin('hospitaliers', 'stages.fk_hospitalier', '=', 'hospitaliers.id_hospitalier')
    ->leftJoin('evaluateurs', 'stages.fk_evaluateur', '=', 'evaluateurs.id_evaluateur')
    ->select('stagiaires.*','groupes.*','stages.*','hospitaliers.*','evaluateurs.*')
    ->where('stagiaires.id_stagiaire','=',$request->id_stagiaire)
    ->where('stages.id_stage','=',$request->id_stage)
    ->get();
    
return Response()->json(['stagiaires' => $stagiaires]);

}
public function PDFevaluation($s,$st){
    $stagiaires  = Stagiaire::leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
    ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
    ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
    ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
    ->leftJoin('hospitaliers', 'stages.fk_hospitalier', '=', 'hospitaliers.id_hospitalier')
    ->leftJoin('evaluateurs', 'stages.fk_evaluateur', '=', 'evaluateurs.id_evaluateur')
    ->select('stagiaires.*','groupes.*','stages.*','hospitaliers.*','evaluateurs.*')
    ->where('stagiaires.id_stagiaire','=',$s)
    ->where('stages.id_stage','=',$st)
    ->get();
    $objectifs = Evaluation_objectif::leftJoin('type_objectifs', 'evaluation_objectifs.fk_type_objectif', '=', 'type_objectifs.id_type')
    ->leftJoin('notes', 'evaluation_objectifs.id_evaluation_objectif', '=', 'notes.fk_objectif')
    ->leftJoin('evaluations', 'evaluations.id_evaluation', '=', 'notes.fk_evaluation')
    ->leftJoin('total_notes', 'evaluations.id_evaluation', '=', 'total_notes.fk_evaluation')
    ->leftJoin('stagiaires', 'evaluations.fk_stagiaire', '=', 'stagiaires.id_stagiaire')
    ->leftJoin('stages', 'evaluations.fk_stage', '=', 'stages.id_stage')

    ->select('evaluation_objectifs.*', 'type_objectifs.*','notes.*','evaluations.*','total_notes.*','stages.*')
    ->where('stagiaires.id_stagiaire','=',$s)
    ->where('stages.id_stage','=',$st)
    ->get();
    //dd($stagiaires);

    $typeObjectifs = Type_objectif::leftJoin('note_types', 'type_objectifs.id_type', '=', 'note_types.fk_type_objectif')
    ->leftJoin('evaluations', 'evaluations.id_evaluation', '=', 'note_types.fk_evaluation')
    ->leftJoin('stages', 'evaluations.fk_stage', '=', 'stages.id_stage')

    ->select( 'type_objectifs.*','evaluations.*','note_types.*','stages.*')
    ->where('evaluations.fk_stagiaire','=',$s)
    ->where('stages.id_stage','=',$st)

    ->get();

    
//return Response()->json(['stagiaires' => $stagiaires,'objectifs' =>$objectifs,'typeObjectifs',$typeObjectifs ]);
  // dd($stagiaires);

   // 
   PDF::setFooterCallback(function($pdf) {
    //dd($infoComp);
   // dd($this->template);
     // Position at 15 mm from bottom
    // $pdf->SetY(-15);
     // Set font
     $pdf->SetFont('helvetica', 'I', 10);
     // Page number
     PDF::writeHTMLCell(0, 0, '',250,'Cachet et signature du chef de service', 0, 1, 0, true, '', true);
     PDF::writeHTMLCell(0, 0, 130,250,'Cachet et signature des maitres de stage', 0, 1, 0, true, '', true);
     PDF::writeHTMLCell(0, 0,'',285,'<hr>', 0, 1, 0, true, '', true);
     PDF::writeHTMLCell(0, 0, '',290,'<span style="color:blue;text-align:right"> Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages().'</span>', 0, 1, 0, true, '', true);

    // $pdf->Cell(0, 10, $this->template.'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

 });
    PDF::SetTitle('Evaluation');

    PDF::AddPage();

    $headTop = '<h2 style="color:red"> Fiche d évaluation du stage </h2>';
    $numStage = '<h2 style="color:red">'.$stagiaires[0]->intitule_stage.'</h2>';


   

    $commandesHtml ='<table  style="padding: 3px 0px;" cellpadding="2">
    <thead>
    <tr>
           <th></th>
           <th></th>
           <th></th>
           <th></th>
    </tr>
            </thead>';
     $commandesHtml.='<tbody>';
    foreach ( $typeObjectifs as $typeObjectif ){
        $commandesHtml.='
       
        <tr>                   
                <th align="center" style="width:450px;color:blue"><h3>'.$typeObjectif->type_objectif.'</h3></th>
                
         </tr>
         ';
        foreach ( $objectifs as $objectif){ 
            if($objectif->fk_type_objectif===$typeObjectif->id_type){
        $commandesHtml.='
             <tr>             
                <th style="
                border-left:1px solid black;
                border-bottom: 1px solid black;
                border-top: 1px solid black;width:400px;
                ">'.$objectif->objectif.'</th>
                <th align="center" style="
                border-right:1px solid black;
                border-bottom: 1px solid black;
                border-top: 1px solid black;
                border-left:1px solid black;
                ">'.$objectif->note.'/'.$objectif->coefficient.'</th>
                
                
         </tr> '; }
        }
    
    
        $commandesHtml.='
       
        <tr>    
        <th style="
        border-left:1px solid black;
        border-bottom: 1px solid black;
        border-top: 1px solid black;width:400px;
        ">Note </th>
        <th align="center" style="
        border-right:1px solid black;
        border-bottom: 1px solid black;
        border-top: 1px solid black;
        border-left:1px solid black;
        ">'.$typeObjectif->note_type.'/20</th>

                
         </tr>
         ';}
        $commandesHtml.='</tbody> </table>';
        
        $valide= '<table>
       
            <tr>
            <td>Score totale sur 60 :</td>
            <td>Note finale '.$objectifs[0]->noteFinal.' /20</td>';
            if($objectifs[0]->etat === "non valide"){
                $valide.='<td style="color:red">non valide</td>'; }
             else {
                    $valide.='<td style="color:green">valide</td>'; }    
                    $valide.= '</tr>
        
        </table>';

        PDF::writeHTMLCell(0, 0,63, 4,$headTop,0, 1, 0, true, '', true);    
        PDF::writeHTMLCell(0, 0,88, 11,$numStage,0, 1, 0, true, '', true); 
        PDF::writeHTMLCell(0, 0,'', 24,'<hr>',0, 1, 0, true, '', true); 
        PDF::writeHTMLCell(0, 0,'', 30,'Année Universitaire :'.$stagiaires[0]->annee_universitaire_stagiaire.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,130, 30,''.$stagiaires[0]->niveau_etude_stagiaire.' de medecine',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 40,'Nom : '.$stagiaires[0]->nom_stagiaire.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,70, 40,'Prénom : '.$stagiaires[0]->prenom_stagiaire.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,140, 40,'N° : '.$stagiaires[0]->id_stagiaire.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 50,'Période du stage du : ',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,70, 50,$stagiaires[0]->dateDebut_stage,0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,120, 50,'au : ',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,150, 50,$stagiaires[0]->dateFin_stage,0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 60,'Hospital : '.$stagiaires[0]->nom_hospitalier.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 70,'Service : '.$stagiaires[0]->service_evaluateur.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,80, 70,'Nom du MS : '.$stagiaires[0]->service_evaluateur.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 79,'<hr>',0, 1, 0, true, '', true); 
        PDF::writeHTMLCell(0, 0,'', 82,$commandesHtml,0, 1, 0, true, '', true);   
        $y = PDF::getY()+8; 
        PDF::writeHTMLCell(0, 0,73, $y,'<h3 style="color:blue">Examin de fin de stage</h3>',0, 1, 0, true, '', true); 
        PDF::writeHTMLCell(0, 0,130, $y+0.5,'note : '.$objectifs[0]->noteStage.' / 20',0, 1, 0, true, '', true); 
        $y = PDF::getY()+8; 
        PDF::writeHTMLCell(0, 0,'', $y,$valide,1, 1, 0, true, '', true);
        
    PDF::Output('hello_world.pdf');

}
public function testf(){}


}
