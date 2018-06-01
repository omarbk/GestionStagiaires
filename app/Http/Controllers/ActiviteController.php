<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activite;
use PDF;

class ActiviteController extends Controller
{
    public function addActivite(Request $request){
        //dd($request);
        for($i=0;$i<count($request->activites);$i++) {    
            $activite = new Activite();
            $activite->type_activite = $request->activites[$i]['type_activite'];
            $activite->niveau_etude = $request->activites[$i]['niveau_etude'];

            $activite->nom_activite = $request->activites[$i]['nom_activite'];
 
        $activite->save();  
        }
        return Response()->json(['etat' => true ]);
    }

    

    public function updateActivite(Request $request){
        for($i=0;$i<count($request->suppActivites);$i++){
            $activite = Activite::find($request->suppActivites[$i]['id_activite']);
            $activite->delete();
    
            }
            for($i=0;$i<count($request->activites);$i++){
                if (!isset($request->activites[$i]['id_activite'])) {
                    $activite = new Activite();
                    $activite->type_activite = $request->activites[$i]['type_activite'];
                    $activite->niveau_etude = $request->activites[$i]['niveau_etude'];
        
                    $activite->nom_activite = $request->activites[$i]['nom_activite'];
         
                    $activite->save();
                }    
            }
            
                for($i=0;$i<count($request->activites);$i++){
                    if (isset($request->activites[$i]['id_activite'])) {
                        Activite::where('id_activite','=', $request->activites[$i]['id_activite'])->update([
                "nom_activite" => $request->activites[$i]['nom_activite'],
                "type_activite" => $request->activites[$i]['type_activite'],
                "niveau_etude" => $request->activites[$i]['niveau_etude'],
               ]);
                    }
                }
     
        return Response()->json(['etat' => true]);
    }

    public function getActivites(){
     
        $activites =Activite::select('activites.*')
        ->groupBy('activites.niveau_etude')
        ->paginate(10);

        $typeA =Activite::All();

       // dd($activites);
                 return Response()->json(['activites' => $activites, 'typeA' => $typeA ]);
    }

    public function getActivite($niveau_etude){
        $activites = Activite::select('activites.*')
            ->where('niveau_etude','=',$niveau_etude)
                    ->get();
                    //dd($activite);
                 
                 return Response()->json(['activites' => $activites ]);
    }
    function  getTypeActivites($niveau_etude){
        $listeTypeActivites = Activite::where('niveau_etude','=',$niveau_etude)
        ->groupBy('activites.type_activite')->get();
            return Response()->json(['listeTypeActivites' => $listeTypeActivites ]);
       }
    public function searchActivite($search_A){
        $activites = Activite::select('activites.*')
        ->where('acitivites.nom_activite','like', '%' .$search_A . '%')
        ->orWhere('acitivites.type_activite','like', '%' .$search_A . '%')
        ->paginate(10);
        return Response()->json(['activites' => $activites ]);
    }

    public function deleteActivite($niveau_etude){
       // dd($niveau_etude);

        $activite = Activite::where('niveau_etude','=',$niveau_etude);
        $activite->delete();
        return Response()->json(['delete' => 'true']);
    }





    public function PDFActivite($niveau_etude){
        $typeActivites = Activite::where('niveau_etude','=',$niveau_etude)
        ->groupBy('activites.type_activite')->get();

        $activites = Activite::select('activites.*')
        ->where('niveau_etude','=',$niveau_etude)
        ->get();
    
        
    
       // 
       PDF::setFooterCallback(function($pdf) {
        //dd($infoComp);
       // dd($this->template);
         // Position at 15 mm from bottom
        // $pdf->SetY(-15);
         // Set font
         $pdf->SetFont('helvetica', 'I', 10);
         // Page number
         PDF::writeHTMLCell(0, 0,'',285,'<hr>', 0, 1, 0, true, '', true);
         PDF::writeHTMLCell(0, 0, '',290,'<span style="color:blue;text-align:right"> Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages().'</span>', 0, 1, 0, true, '', true);
    
        // $pdf->Cell(0, 10, $this->template.'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    
     });
        PDF::SetTitle('Activites');
    
        PDF::AddPage();
    
        $headTop = '<h2 style="color:red"> Fiche d\'Activités </h2>';
        $numStage = '<h2 style="color:red">'.$activites[0]->niveau_etude.'</h2>';
    
    
       
    
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
        foreach ( $typeActivites as $typeActivite ){
            $commandesHtml.='
           <br>
            <tr>                   
            <th align="center" style="width:450px;color:blue;"><h3>'.$typeActivite->type_activite.'</h3></th>
                    
             </tr>
             ';
             $commandesHtml.='
           
             <tr>                   
             <th rowspan="2" colspan="1" align="center"
             style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:250px;
             border-right:1px solid black;
             "><h2> <b> Activité </b></h2></th>
             <td  rowspan="1" colspan="2" align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
border-bottom: 1px solid black;
width:260px;
"><h2> <b> Validation </b></h2> </td>
</tr>
<tr>
             <th style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:150px;
             text-align: center;
             ">Maitre de Stage (Nom,Signature et date)</th>
             <th style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;
             border-right: 1px solid black;width:110px;
             text-align: center;
             ">Hospital</th>                     
              </tr>
              ';
            foreach ( $activites as $activite){ 
                if($activite->type_activite===$typeActivite->type_activite){
            $commandesHtml.='
                 <tr>             
                    <th style="
                    border-left:1px solid black;
                    border-bottom: 1px solid black;
                    border-top: 1px solid black;width:250px;
                    ">'.$activite->nom_activite.'</th>
                    <th style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:150px;
             "></th>
             <th style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;
             border-right: 1px solid black;width:110px;
             "></th>
                  
                    
                    
             </tr> '; }
            }
        
        
            $commandesHtml.='
           
             ';}
            $commandesHtml.='</tbody> </table>';
            
        
            PDF::writeHTMLCell(0, 0,79, 4,$headTop,0, 1, 0, true, '', true);    
            PDF::writeHTMLCell(0, 0,88, 11,$numStage,0, 1, 0, true, '', true); 
            PDF::writeHTMLCell(0, 0,'', 24,'<hr>',0, 1, 0, true, '', true); 
            PDF::writeHTMLCell(0, 0,'', 30,$commandesHtml,0, 1, 0, true, '', true);   
    
        PDF::Output('evaluation.pdf');
    
    }
}
