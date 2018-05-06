<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluation_objectif;

class Evaluation_objectifController extends Controller
{
    public function addObjectif(Request $request){
        $eval_objectif = new Evaluation_objectif();
     
        $eval_objectif->objectif = $request->evaluationObjectif['objectif'];
        $eval_objectif->type_objectif = $request->evaluationObjectif['type_objectif'];
        $eval_objectif->coefficient = $request->evaluationObjectif['coefficient'];

        $eval_objectif->save();  
        return Response()->json(['etat' => true ]);
    }

    public function updateObjectif(Request $request){

        $eval_objectif = Evaluation_objectif::find($request->evaluationObjectif['id_evaluation_objectif']);
        $eval_objectif->objectif = $request->evaluationObjectif['objectif'];
        $eval_objectif->type_objectif = $request->evaluationObjectif['type_objectif'];
        $eval_objectif->coefficient = $request->evaluationObjectif['coefficient'];

        $eval_objectif->save();
        return Response()->json(['etat' => true]);
    }

    public function getObjectifs(){
     
        $objectifs = Evaluation_objectif::paginate(10);
                 return Response()->json(['objectifs' => $objectifs ]);
    }

    public function getObjectif($id_evaluation_objectif){
        $objectif = Evaluation_objectif::where('id_evaluation_objectif','=',$id_evaluation_objectif)
                    ->get();
                   // dd($objectif);

                 return Response()->json(['objectif' => $objectif]);
    }

    public function searchObjectif($search_O){
        $objectifs = Evaluation_objectif::where('objectif','like', '%' .$search_O . '%')
        ->orWhere('type_objectif','like', '%' .$search_O . '%')
        ->paginate(10);
        return Response()->json(['objectifs' => $objectifs ]);
    }

    public function deleteObjectif($id_evaluation_objectif){
        $objectif = Evaluation_objectif::find($id_evaluation_objectif);
        $objectif->delete();
        return Response()->json(['delete' => 'true']);
    }
}
