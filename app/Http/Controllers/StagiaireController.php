<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Stagiaire;
use App\Evaluation;
use App\Stage;
use App\User;
use App\Evaluateur;

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
                $stagiaire = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')
                            ->select('stagiaires.*', 'users.*')
                            ->where('stagiaires.id_stagiaire','=',$id_stagiaire)
                            
                            ->get();
                           // dd($stagiaire);

                         return Response()->json(['stagiaire' => $stagiaire]);
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
                      ->select('stagiaires.*','stages.intitule_stage','stages.fk_evaluateur','groupes.nom_groupe')
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
                      ->select('stagiaires.*','stages.intitule_stage','stages.fk_evaluateur','groupes.nom_groupe')
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


}
