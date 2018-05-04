<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Hospitalier;
use App\Service_hospitalier;

class HospitalierController extends Controller
{
    public function addHospitalier(Request $request){
        // dd($request);
     $hospitalier = new Hospitalier();
     $hospitalier->id_hospitalier = $request->hospitalier['id_hospitalier'];
     $hospitalier->nom_hospitalier=$request->hospitalier['nom_hospitalier'];
     $hospitalier->adresse_hospitalier=$request->hospitalier['adresse_hospitalier'];
     $hospitalier->tel_hospitalier=$request->hospitalier['tel_hospitalier'];

     $hospitalier->save();
     $id_hospitalier=$hospitalier->id_hospitalier;
     $this->addService_Hospitalier($request,$id_hospitalier);
     return Response()->json(['etat'=>true]);
    }

    public function updateHospitalier(Request $request){

        $hospitalier = Hospitalier::find($request->hospitalier['id_hospitalier']);
        $hospitalier->nom_hospitalier=$request->hospitalier['nom_hospitalier'];
        $hospitalier->adresse_hospitalier=$request->hospitalier['adresse_hospitalier'];
        $hospitalier->tel_hospitalier=$request->hospitalier['tel_hospitalier'];

        $hospitalier->save();
        $id_hospitalier=$hospitalier->id_hospitalier;
        $this->updateService_Hospitalier($request,$id_hospitalier);
        return Response()->json(['etat' => true]);
    }


//id_service_hospitalier
     public function addService_Hospitalier(Request $request,$id_hospitalier){
         //dd($request);
        for($i=0;$i<count($request->service_hospitaliers);$i++) {  
     $service_hospitalier = new Service_hospitalier();
     $service_hospitalier->fk_service = $request->service_hospitaliers[$i]['id_service'];
     $service_hospitalier->fk_hospitalier=$id_hospitalier;

     $service_hospitalier->save();
        }
     return Response()->json(['etat'=>true]);
     }

     public function updateService_Hospitalier(Request $request , $id_hospitalier){

        for($i=0;$i<count($request->suppServices);$i++){
         $serviceHospitalier = Service_Hospitalier::find($request->suppServices[$i]['id_service_hospitalier']);
         $serviceHospitalier->delete();
 
         }
         for($i=0;$i<count($request->service_hospitaliers);$i++){
             if (!isset($request->service_hospitaliers[$i]['id_service_hospitalier'])) {
                $serviceHospitalier = new Service_Hospitalier();  
                $serviceHospitalier->fk_service=$request->service_hospitaliers[$i]['id_service'];
                $serviceHospitalier->fk_hospitalier=$id_hospitalier;
               
                $serviceHospitalier->save();
             }    
         }
         for($i=0;$i<count($request->service_hospitaliers);$i++){
             if (isset($request->service_hospitaliers[$i]['id_service_hospitalier'])) {
                Service_Hospitalier::where('id_service_hospitalier','=', $request->service_hospitaliers[$i]['id_service_hospitalier'])->update([
            "fk_service" => $request->service_hospitaliers[$i]['fk_service'],
            "fk_hospitalier" => $request->service_hospitaliers[$i]['fk_hospitalier'],

            ]);
             }
         }
  
      }
     
    public function getHospitaliers(){
     
        $hospitaliers = Hospitalier::paginate(10);
                   
                 return Response()->json(['hospitaliers' => $hospitaliers ]);
    }
    public function getHospitaliersH(){
     
        $hospitaliers = Hospitalier::get();
                   
                 return Response()->json(['hospitaliers' => $hospitaliers ]);
    }
    public function getHospitalier($id_hospitalier){
        // $devi= Devi::find($id_devis);
       /*  $hospitalier= Hospitalier::leftJoin('service_hospitaliers', 'hospitaliers.id_hospitalier', '=', 'service_hospitaliers.fk_hospitalier')
               ->select('hospitaliers.*', 'service_hospitaliers.*')
               ->where('id_hospitalier', $id_hospitalier)->get();*/
               $hospitalier= Hospitalier::where('id_hospitalier', $id_hospitalier)->get();
         return Response()->json(['hospitalier' => $hospitalier]);
    } 

    public function searchHospitalier($search_H){
        $hospitaliers = Hospitalier::where('nom_hospitalier','like', '%' .$search_H . '%')->paginate(10);
        return Response()->json(['hospitaliers' => $hospitaliers ]);
    }

    public function getService_Hospitalier($id_hospitalier){
        // $devi= Devi::find($id_devis);
         $serviceHospitalier= Service_Hospitalier::leftJoin('services', 'service_hospitaliers.fk_service', '=', 'services.id_service')
         ->select('services.*', 'service_hospitaliers.*')
         ->where('fk_hospitalier', $id_hospitalier)->get();
         return Response()->json(['serviceHospitalier' => $serviceHospitalier]);
    } 
    
    public function deleteHospitalier($id_hospitalier){

        $hospitalier = Hospitalier::find($id_hospitalier);
        $hospitalier->delete();
        $serviceHospitalier = Service_Hospitalier::where('fk_hospitalier','=',$id_hospitalier);  
        $serviceHospitalier->delete();   
        return Response()->json(['delete' => 'true']);
    }
}
