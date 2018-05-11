<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Absence;
class AbsenceController extends Controller
{
    public function addAbsence(Request $request)
    { 
        $absence = new Absence();
 
              
                $absence->dateDebut_absence = $request->absence['dateDebut_absence'];
                $absence->dateFin_absence = $request->absence['dateFin_absence'];
                $absence->duree_absence = $request->absence['duree_absence'];
                $absence->cause_absence = $request->absence['cause_absence'];
                $absence->justificatif_absence = $request->absence['justificatif_absence'];
                $absence->fk_stagiaire = $request->absence['fk_stagiaire'];
                $absence->fk_evaluateur = $request->absence['fk_evaluateur'];
                $absence->save();
                 return Response()->json(['etat' => true]);
            
    }

    public function updateAbsence(Request $request){

        $absence = Absence::find($request->absence['id_absence']);

        $absence->dateDebut_absence = $request->absence['dateDebut_absence'];
        $absence->dateFin_absence = $request->absence['dateFin_absence'];
        $absence->duree_absence = $request->absence['duree_absence'];
        $absence->cause_absence = $request->absence['cause_absence'];
        $absence->justificatif_absence = $request->absence['justificatif_absence'];
       
        $absence->save();
        
        return Response()->json(['etat' => true]);
     }
    public function getAbsenceParStagiaire(Request $request){
        $absences= Absence::select('absences.*')
        ->where('absences.fk_stagiaire','=',$request->fk_stagiaire)
        ->where('absences.fk_evaluateur','=',$request->fk_evaluateur)
        ->paginate(10);
        return Response()->json(['absences' => $absences]);
     }
    
     public function deleteAbsence($id_absence){

        $absence = Absence::find($id_absence)->delete();
        return Response()->json(['delete' => 'true']);
     }

     public function getAbsence($id_absence){
        $absence= Absence::where('absences.id_absence','=',$id_absence)
        ->get();
    
        return Response()->json(['absence' => $absence]);
     }


}
