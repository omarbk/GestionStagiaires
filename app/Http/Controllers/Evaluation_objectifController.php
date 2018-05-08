<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluation_objectif;

class Evaluation_objectifController extends Controller
{
    public function addObjectif(Request $request){
        //dd($request);
        for($i=0;$i<count($request->objectifs);$i++) {    
            $eval_objectif = new Evaluation_objectif();
     
        $eval_objectif->objectif = $request->objectifs[$i]['objectif'];
        $eval_objectif->fk_type_objectif = $request->objectifs[$i]['fk_type_objectif'];
        $eval_objectif->annee_objectif = $request->objectifs[$i]['annee_objectif'];
        $eval_objectif->coefficient = $request->objectifs[$i]['coefficient'];

        $eval_objectif->save();  
        }
        return Response()->json(['etat' => true ]);
    }

    public function updateObjectif(Request $request){

        $eval_objectif = Evaluation_objectif::find($request->objectif['id_evaluation_objectif']);
        $eval_objectif->objectif = $request->objectif['objectif'];
        $eval_objectif->fk_type_objectif = $request->objectif['fk_type_objectif'];
        $eval_objectif->annee_objectif = $request->objectif['annee_objectif'];
        $eval_objectif->coefficient = $request->objectif['coefficient'];

        $eval_objectif->save();
        return Response()->json(['etat' => true]);
    }

    public function getObjectifs(){
     
        $objectifs =Evaluation_objectif::leftJoin('type_objectifs', 'evaluation_objectifs.fk_type_objectif', '=', 'type_objectifs.id_type')
        ->select('evaluation_objectifs.*', 'type_objectifs.*')
        ->paginate(10);
                 return Response()->json(['objectifs' => $objectifs ]);
    }

    public function getObjectifsAnnee(){
     
        $objectifs = Evaluation_objectif::leftJoin('type_objectifs', 'evaluation_objectifs.fk_type_objectif', '=', 'type_objectifs.id_type')
        ->leftJoin('notes', 'evaluation_objectifs.id_evaluation_objectif', '=', 'notes.fk_objectif')
        ->leftJoin('evaluations', 'evaluations.id_evaluation', '=', 'notes.fk_evaluation')
  
        ->select('evaluation_objectifs.*', 'type_objectifs.*','notes.*','evaluations.*')
        ->where('annee_objectif','=',1)
        ->get();
       // dd($objectifs);
                      return Response()->json(['objectifs' => $objectifs ]);
    }

    public function getObjectif($id_evaluation_objectif){
        $objectif = Evaluation_objectif::leftJoin('type_objectifs', 'evaluation_objectifs.fk_type_objectif', '=', 'type_objectifs.id_type')
        ->select('evaluation_objectifs.*', 'type_objectifs.*')
            ->where('id_evaluation_objectif','=',$id_evaluation_objectif)
                    ->get();
                   // dd($objectif);

                 return Response()->json(['objectif' => $objectif]);
    }

    public function searchObjectif($search_O){
        $objectifs = Evaluation_objectif::leftJoin('type_objectifs', 'evaluation_objectifs.fk_type_objectif', '=', 'type_objectifs.id_type')
        ->select('evaluation_objectifs.*', 'type_objectifs.*')
        ->where('evaluation_objectifs.objectif','like', '%' .$search_O . '%')
        ->orWhere('type_objectifs.type_objectif','like', '%' .$search_O . '%')
        ->paginate(10);
        return Response()->json(['objectifs' => $objectifs ]);
    }

    public function deleteObjectif($id_evaluation_objectif){
        $objectif = Evaluation_objectif::find($id_evaluation_objectif);
        $objectif->delete();
        return Response()->json(['delete' => 'true']);
    }
}
