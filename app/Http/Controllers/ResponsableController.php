<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Responsable;

use App\User;

class ResponsableController extends Controller
{
    public function countUser(){
        $count = User::withTrashed()->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }
    
    public function addUserResponsable(Request $request){
       // dd($request);
    $user = new User();
    $user->id = $request->user['id'];
    $user->email=$request->user['email'];
    $user->role=$request->user['role'];
    $user->password =  Hash::make($request->user['password']);
    $user->save();
    $id=$user->id;
    $this->addResponsable($request,$id);
    return Response()->json(['etat'=>true]);
    }
    
    public function updateUser(Request $request){

        $user = User::find($request->responsable['id']);
        $user->id = $request->responsable['id'];
        $user->email=$request->responsable['email'];
        $user->role=$request->responsable['role'];
        $user->password =  Hash::make($request->password);

        $user->save();
        //$id = $user->id;
       // $this->updateResponsable($request,$id);
        return Response()->json(['etat' => true]);
    }

    public function addResponsable(Request $request,$id){
        $responsable = new Responsable();

        if($request->responsable['photo_responsable'])
        {  
            if(strlen($request->responsable['photo_responsable']) < 40 ){
             $responsable->photo_responsable = $request->responsable['photo_responsable'];
            }
            else {
           $image = $request->responsable['photo_responsable'];
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          $image2 = \Image::make($request->responsable['photo_responsable']);     
           Storage::put('images/'.$name, (string) $image2->encode());
           $responsable->photo_responsable = $name;}
         }
         else  {
             $responsable->photo_responsable = "";
         }


        $responsable->nom_responsable = $request->responsable['nom_responsable'];
        $responsable->prenom_responsable = $request->responsable['prenom_responsable'];
        $responsable->adresse_responsable = $request->responsable['adresse_responsable'];
        $responsable->tel_responsable = $request->responsable['tel_responsable'];
        $responsable->dateNaissance_responsable = $request->responsable['dateNaissance_responsable'];
        $responsable->service_responsable = $request->responsable['service_responsable'];
        $responsable->fk_user = $request->responsable['fk_user'];

        $responsable->save();
        $user = User::find($id);
        $user->photo =$responsable->photo_responsable;
        $user->save();  
      
        
        return Response()->json(['responsable' => $responsable ]);
        

    }

    public function updateResponsable(Request $request){     
         $responsable = Responsable::find($request->responsable['id_responsable']);

         
         if($request->responsable['photo_responsable'])
        {  
            if(strlen($request->responsable['photo_responsable']) < 40 ){
             $responsable->photo_responsable = $request->responsable['photo_responsable'];
            }
            else {
           $image = $request->responsable['photo_responsable'];
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           if( $responsable->photo_responsable !=""){
           Storage::disk('local')->delete('images/'.$responsable->photo_responsable);
           }
 
           $image2 = \Image::make($request->responsable['photo_responsable']);     
           Storage::put('images/'.$name, (string) $image2->encode());
           $responsable->photo_responsable = $name;}
         }
         else  {
             $responsable->photo_responsable = "";
         }
                 
 
         
         $responsable->nom_responsable = $request->responsable['nom_responsable'];
         $responsable->prenom_responsable = $request->responsable['prenom_responsable'];
         $responsable->adresse_responsable = $request->responsable['adresse_responsable'];
         $responsable->tel_responsable = $request->responsable['tel_responsable'];
         $responsable->dateNaissance_responsable = $request->responsable['dateNaissance_responsable'];
         $responsable->service_responsable = $request->responsable['service_responsable'];
         $responsable->fk_user =  $request->responsable['fk_user'];;
                 $responsable->save();

                 $user = User::find($responsable->fk_user);
                 $user->photo =$responsable->photo_responsable;
                 $user->save();          
                  return Response()->json(['etat' => true]);
    }


    public function getResponsables(){
     
        $responsables = Responsable::leftJoin('users', 'responsables.fk_user', '=', 'users.id')
                    ->select('responsables.*', 'users.*')
                    ->where('users.role','=','Responsable')
                    ->paginate(6);
                 return Response()->json(['responsables' => $responsables ]);
    }
              
    public function getResponsable($id_responsable){
                $responsable = Responsable::leftJoin('users', 'responsables.fk_user', '=', 'users.id')
                            ->select('responsables.*', 'users.*')
                            ->where('responsables.id_responsable','=',$id_responsable)
                            ->get();
                           // dd($responsable);

                         return Response()->json(['responsable' => $responsable]);
    }
     
    public function searchResponsable($search_R){
        $responsables = Responsable::leftJoin('users', 'responsables.fk_user', '=', 'users.id')->where('service_responsable','like', '%' .$search_R . '%')->orWhere('nom_responsable','like', '%' .$search_R . '%')->paginate(6);
        return Response()->json(['responsables' => $responsables ]);
     }





    public function deleteResponsable($fk_user){
        $responsable = Responsable::where('fk_user','=',$fk_user)->first();
        if( $responsable->photo_responsable !=""){
            Storage::disk('local')->delete('images/'.$responsable->photo_responsable);
            }
             $responsable->delete(); 
        $user = User::where('id','=',$fk_user)->delete(); 
        return Response()->json(['delete' => 'true']);
    }
}
