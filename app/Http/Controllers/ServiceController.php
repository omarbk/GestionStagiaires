<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

use App\Events\NewComment;
class ServiceController extends Controller
{
    public function addService(Request $request){

     $service = new Service();
     $service->nom_service = $request->service['nom_service'];
     $service->besoin_service=$request->service['besoin_service'];
     $service->duree_service=$request->service['duree_service'];
     event(new NewComment());
     $service->save();

     return Response()->json(['etat'=>true]);
    }

    public function updateService(Request $request){

        $service = Service::find($request->service['id_service']);
        $service->nom_service = $request->service['nom_service'];
        $service->besoin_service=$request->service['besoin_service'];
        $service->duree_service=$request->service['duree_service'];

        $service->save();
        return Response()->json(['etat' => true]);
    }

    public function getServices(){
     
        $services = Service::paginate(10);
                 return Response()->json(['services' => $services ]);
    }
    public function getServicesS(){
     
        $services = Service::get();
                 return Response()->json(['services' => $services ]);
    }
    public function getService($id_service){
        $service = Service::where('services.id_service','=',$id_service)
                    ->get();
                   // dd($service);

                 return Response()->json(['service' => $service]);
    }

    public function searchService($search_S){
        $services = Service::where('services.nom_service','like', '%' .$search_S . '%')->paginate(10);
        return Response()->json(['services' => $services ]);
    }

    public function deleteService($id_service){
        $service = Service::find($id_service);
             $service->delete(); 
        return Response()->json(['delete' => 'true']);
    }
}
