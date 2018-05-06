<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Evaluateur;
use App\User;

class EvaluateurController extends Controller
{
    public function countUser(){
        $count = User::withTrashed()->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }
    public function addUserEvaluateur(Request $request){
        // dd($request);
     $user = new User();
     $user->id = $request->user['id'];
     $user->email=$request->user['email'];
     $user->role=$request->user['role'];
     $user->password =  Hash::make($request->password);
     $user->save();
     $id=$user->id;
     $this->addEvaluateur($request,$id);
     return Response()->json(['etat'=>true]);
    }

   /* public function updateUser_E(Request $request){

        $user = User::find($request->evaluateur['id']);
        $user->id = $request->evaluateur['id'];
        $user->email=$request->evaluateur['email'];
        $user->role=$request->evaluateur['role'];
        $user->password =  Hash::make($request->password);

        $user->save();
        //$id = $user->id;
       // $this->updateEvaluateur($request,$id);
        return Response()->json(['etat' => true]);
    }*/
    public function addEvaluateur(Request $request,$id){
        $evaluateur = new Evaluateur();

        if($request->evaluateur['photo_evaluateur'])
        {  
            if(strlen($request->evaluateur['photo_evaluateur']) < 40 ){
             $evaluateur->photo_evaluateur = $request->evaluateur['photo_evaluateur'];
            }
            else {
           $image = $request->evaluateur['photo_evaluateur'];
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          $image2 = \Image::make($request->evaluateur['photo_evaluateur']);     
           Storage::put('images/'.$name, (string) $image2->encode());
           $evaluateur->photo_evaluateur = $name;}
         }
         else  {
             $evaluateur->photo_evaluateur = "";
         }
         


        $evaluateur->nom_evaluateur = $request->evaluateur['nom_evaluateur'];
        $evaluateur->prenom_evaluateur = $request->evaluateur['prenom_evaluateur'];
        $evaluateur->adresse_evaluateur = $request->evaluateur['adresse_evaluateur'];
        $evaluateur->tel_evaluateur = $request->evaluateur['tel_evaluateur'];
        $evaluateur->dateNaissance_evaluateur = $request->evaluateur['dateNaissance_evaluateur'];
        $evaluateur->service_evaluateur = $request->evaluateur['service_evaluateur'];
        $evaluateur->specialite_evaluateur = $request->evaluateur['specialite_evaluateur'];
        $evaluateur->type_evaluateur = $request->evaluateur['type_evaluateur'];
        $evaluateur->fk_user = $request->evaluateur['fk_user'];
        $evaluateur->fk_hospitalier =$request->hospitalier['id_hospitalier'];

        $evaluateur->save();
      
        
        return Response()->json(['etat' => true ]);
        

    }

    public function updateEvaluateur(Request $request){  
       // dd($request->hospitalier['id_hospitalier']);   
        $evaluateur = Evaluateur::find($request->evaluateur['id_evaluateur']);

        
        if($request->evaluateur['photo_evaluateur'])
       {  
           if(strlen($request->evaluateur['photo_evaluateur']) < 40 ){
            $evaluateur->photo_evaluateur = $request->evaluateur['photo_evaluateur'];
           }
           else {
          $image = $request->evaluateur['photo_evaluateur'];
          $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          if( $evaluateur->photo_evaluateur !=""){
          Storage::disk('local')->delete('images/'.$evaluateur->photo_evaluateur);
          }

          $image2 = \Image::make($request->evaluateur['photo_evaluateur']);     
          Storage::put('images/'.$name, (string) $image2->encode());
          $evaluateur->photo_evaluateur = $name;}
        }
        else  {
            $evaluateur->photo_evaluateur = "";
        }
                

        
        $evaluateur->nom_evaluateur = $request->evaluateur['nom_evaluateur'];
        $evaluateur->prenom_evaluateur = $request->evaluateur['prenom_evaluateur'];
        $evaluateur->adresse_evaluateur = $request->evaluateur['adresse_evaluateur'];
        $evaluateur->tel_evaluateur = $request->evaluateur['tel_evaluateur'];
        $evaluateur->dateNaissance_evaluateur = $request->evaluateur['dateNaissance_evaluateur'];
        $evaluateur->service_evaluateur = $request->evaluateur['service_evaluateur'];
        $evaluateur->specialite_evaluateur = $request->evaluateur['specialite_evaluateur'];
        $evaluateur->type_evaluateur = $request->evaluateur['type_evaluateur'];
        $evaluateur->fk_hospitalier=$request->hospitalier['id_hospitalier'];
        $evaluateur->fk_user = $request->evaluateur['fk_user'];

       /* $test=$request->evaluateur['value'];
        $evaluateur->fk_hospitalier = $test['id_hospitalier'];*/
        $evaluateur->save();
                 return Response()->json(['etat' => true]);
    }

    public function getEvaluateurs(){
     
        $evaluateurs = Evaluateur::leftJoin('users', 'evaluateurs.fk_user', '=', 'users.id')
                    ->select('evaluateurs.*', 'users.*')
                    ->where('users.role','=','Evaluateur')
                    ->paginate(6);
                 return Response()->json(['evaluateurs' => $evaluateurs ]);
    }
    public function getAllEvaluateurs(){
     
        $evaluateurs = Evaluateur::all();
                 return Response()->json(['evaluateurs' => $evaluateurs ]);
    }

    public function getEvaluateur($id_evaluateur){
        
        $evaluateur = Evaluateur::leftJoin('users', 'evaluateurs.fk_user', '=', 'users.id')
        ->leftJoin('hospitaliers', 'evaluateurs.fk_hospitalier', '=', 'hospitaliers.id_hospitalier')
                    ->select('evaluateurs.*', 'users.*','hospitaliers.*')
                    ->where('evaluateurs.id_evaluateur','=',$id_evaluateur)
                    ->get();
                   // dd($evaluateur);

                 return Response()->json(['evaluateur' => $evaluateur]);
    }

    public function searchEvaluateur($search_E){
        $evaluateurs = Evaluateur::leftJoin('users', 'evaluateurs.fk_user', '=', 'users.id')->where('service_evaluateur','like', '%' .$search_E . '%')->orWhere('nom_evaluateur','like', '%' .$search_E . '%')->paginate(6);
        return Response()->json(['evaluateurs' => $evaluateurs ]);
    }

    public function deleteEvaluateur($fk_user){
        $evaluateur = Evaluateur::where('fk_user','=',$fk_user)->first();
        if( $evaluateur->photo_evaluateur !=""){
            Storage::disk('local')->delete('images/'.$evaluateur->photo_evaluateur);
            }
             $evaluateur->delete(); 
        $user = User::where('id','=',$fk_user)->delete(); 
        return Response()->json(['delete' => 'true']);
    }
}
