<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Stagiaire;

use App\User;

class StagiaireController extends Controller
{
    public function countUser(){
        $count = User::withTrashed()->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }
    
    public function addUser(Request $request){
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
        $stagiaire->fk_user = $request->stagiaire['fk_user'];

        $stagiaire->save();
      
        
        return Response()->json(['etat' => true ]);
        

    }

    public function updateStagiaire(Request $request){     
         $stagiaire = Sesponsable::find($request->stagiaire['id_stagiaire']);

         
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
         $stagiaire->dateNaissance_stagiaire = $request->stagiaire['dateNaissance_stagiaire'];
         $stagiaire->service_stagiaire = $request->stagiaire['service_stagiaire'];
         $stagiaire->fk_user =  $request->stagiaire['fk_user'];;
                 $stagiaire->save();
                  return Response()->json(['etat' => true]);
    }


    public function getStagiaires(){
     
        $stagiaires = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')
                    ->select('stagiaires.*', 'users.*')
                    ->where('users.role','=','stagiaire')
                    ->paginate(6);
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
     
    public function searchStagiaire($search_R){
        $stagiaires = Stagiaire::leftJoin('users', 'stagiaires.fk_user', '=', 'users.id')->where('service_stagiaire','like', '%' .$search_R . '%')->orWhere('nom_stagiaire','like', '%' .$search_R . '%')->paginate(6);
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
}
