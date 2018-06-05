<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use PDF;
use App\Stage;
use App\Hospitalier;

class ModuleController extends Controller
{
    public function addModule(Request $request){
        //dd($request);
        for($i=0;$i<count($request->modules);$i++) {    
            $module = new Module();
            $module->type_module = $request->modules[$i]['type_module'];
            $module->niveau_etude = $request->modules[$i]['niveau_etude'];
            $module->titre_module = $request->modules[$i]['titre_module'];
            $module->nom_module = $request->modules[$i]['nom_module'];
 
        $module->save();  
        }
        return Response()->json(['etat' => true ]);
    }

    public function updateModule(Request $request){
        for($i=0;$i<count($request->suppModules);$i++){
            $module = Module::find($request->suppModules[$i]['id_module']);
            $module->delete();
    
            }
            for($i=0;$i<count($request->modules);$i++){
                if (!isset($request->modules[$i]['id_module'])) {
                    $module = new Module();
                    $module->type_module = $request->modules[$i]['type_module'];
                    $module->niveau_etude = $request->modules[$i]['niveau_etude'];
                    $module->titre_module = $request->modules[$i]['titre_module'];
                    $module->nom_module = $request->modules[$i]['nom_module'];
         
                    $module->save();
                }    
            }
            
                for($i=0;$i<count($request->modules);$i++){
                    if (isset($request->modules[$i]['id_module'])) {
                        Module::where('id_module','=', $request->modules[$i]['id_module'])->update([
                "nom_module" => $request->modules[$i]['nom_module'],
                "type_module" => $request->modules[$i]['type_module'],
                "titre_module" => $request->modules[$i]['titre_module'],
                "niveau_etude" => $request->modules[$i]['niveau_etude'],
               ]);
                    }
                }
     
        return Response()->json(['etat' => true]);
    }

    public function getModules(){
     
        $modules =Module::select('modules.*')
        ->groupBy('modules.niveau_etude')
        ->paginate(10);


       // dd($modules);
                 return Response()->json(['modules' => $modules]);
    }

    public function getModule($niveau_etude){
        $modules = Module::select('modules.*')
            ->where('niveau_etude','=',$niveau_etude)
                    ->get();
                    //dd($module);
                 
                 return Response()->json(['modules' => $modules ]);
    }
    function  getTypeModules($niveau_etude){
        $listeTypeModules = Module::where('niveau_etude','=',$niveau_etude)
        ->groupBy('modules.type_module')->get();
            return Response()->json(['listeTypeModules' => $listeTypeModules ]);
       }

       public function searchModule($search_M){
        $modules = Module::select('modules.*')
        ->where('acitivites.nom_module','like', '%' .$search_M . '%')
        ->orWhere('acitivites.type_module','like', '%' .$search_M . '%')
        ->paginate(10);
        return Response()->json(['modules' => $modules ]);
    }

    public function deleteModule($niveau_etude){
       // dd($niveau_etude);

        $module = Module::where('niveau_etude','=',$niveau_etude);
        $module->delete();
        return Response()->json(['delete' => 'true']);
    }


    



    public function PDFModule($niveau_etude,$annee){
        $typeModules = Module::where('niveau_etude','=',$niveau_etude)
        ->groupBy('modules.type_module')->get();

        $modules = Module::select('modules.*')
        ->where('niveau_etude','=',$niveau_etude)
        ->get();

        $hospitaliers= Stage::leftJoin('hospitaliers', 'hospitaliers.id_hospitalier', '=', 'stages.fk_hospitalier')
        ->select('hospitaliers.*','stages.*')
        ->where('stages.annee_universitaire_stage','=',$niveau_etude)
        ->where(function($query)use ($annee)
        {
            $query ->where('stages.dateDebut_stage','like',$annee.'-%')      
            ->orwhere('stages.dateFin_stage','like',$annee.'-%');
        })->groupBy('hospitaliers.nom_hospitalier')->get();

   // dd($hospitaliers);
        //dd($hospital);
    
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
        PDF::SetTitle('Modules');
    
        PDF::AddPage();
    
        $headTop = '<h2 style="color:red"> Fiche d\'Modules </h2>';
       // $numStage = '<h2 style="color:red">'.$hospitaliers[0]->annee_universitaire_stage.'</h2>';
    
    


        $commandesHtml ='<table  style="padding: 3px 0px;" cellpadding="2">
        <thead>
        <tr>
               <th></th>
               <th></th>
               <th></th>
               <th></th>
        </tr>
                </thead>';
         $commandesHtml.='<tbody>
           
             <tr>                   
             <th 
             style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:100px;
             border-right:1px solid black;
             "><h2> <b> Hospital </b></h2></th>
              <th 
             style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:350px;
             border-right:1px solid black;
             "><h2> <b> Adresse </b></h2></th>

             <td 
style="
border-right:1px solid black;
border-top: 1px solid black;
border-bottom: 1px solid black;
width:100px;
"><h2> <b> Téléphone </b></h2> </td>
</tr>

              ';
              if(count($hospitaliers) != 0){

             // dd("fffff");
              foreach ( $hospitaliers as $hospitalier ){
            $commandesHtml.='
                 <tr>             
                 <th style="
                 border-left:1px solid black;
                 border-bottom: 1px solid black;
                 border-top: 1px solid black;width:100px;
                 ">'.$hospitalier->nom_hospitalier.'</th>
                 <th style="
                 border-left:1px solid black;
                 border-bottom: 1px solid black;
                 border-top: 1px solid black;width:350px;
                 ">'.$hospitalier->adresse_hospitalier.'</th>
                    <th style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:100px;
             border-right: 1px solid black;
             ">'.$hospitalier->tel_hospitalier.'</th>
            
                  
                    
                    
             </tr> '
           
             ;}
              }
            $commandesHtml.='</tbody>
            <span style="color:red"><u> Sites des Stages:</u></span>

            </table>';











       
    
        $commandesHtml.='
        
        <table  style="padding: 3px 0px;" cellpadding="2">
        
        <thead>
        <tr>
        
               <th></th>
               <th></th>
               <th></th>
               <th></th>
        </tr>
                </thead>';
         $commandesHtml.='<tbody>';
        foreach ( $typeModules as $typeModule ){
            $commandesHtml.='
           <br>
           
             ';
             $commandesHtml.='
           
             <tr>                   
             <th rowspan="2" colspan="1" align="center"
             style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:50px;
             ';
                if($typeModule->type_module==="Modules Obligatoires"){
            $commandesHtml.='
             border-right:1px solid black;
             '; }
            
        
        
            $commandesHtml.='
             "><h2> <b>  </b></h2></th>
              <th rowspan="2" colspan="1" align="center"
             style="
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:300px;
             border-right:1px solid black;
             "><h2> <b>' .$typeModule->type_module. '</b></h2></th>

             <td  rowspan="1" colspan="1" align="center"
style="
border-right:1px solid black;
border-top: 1px solid black;
border-bottom: 1px solid black;
width:200px;
"><h2> <b> Validation </b></h2> </td>
</tr>
<tr>
             <th style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:200px;
             border-right: 1px solid black;
             text-align: center;
             ">Encadrant       (Nom,Signature et date)</th>
                               
              </tr>
              ';
            foreach ( $modules as $module){ 
                if($module->type_module===$typeModule->type_module){
            $commandesHtml.='
                 <tr>             
                 <th style="
                 border-left:1px solid black;
                 border-bottom: 1px solid black;
                 ';
                 if($module->type_module==="Modules Obligatoires"){
             $commandesHtml.='
              border-right:1px solid black;
              '; }
             
         
         
             $commandesHtml.='
                 border-top: 1px solid black;width:50px;
                 color:blue;
                 ">'
                 ;
                 if($module->type_module==="Modules Obligatoires"){
             $commandesHtml.=
                 
                 
                 ''.$module->nom_module.''
                 ; }
             
         
         
                 $commandesHtml.='</th>
                 <th style="
                 border-bottom: 1px solid black;
                 border-top: 1px solid black;width:300px;
                 ">'.$module->titre_module.'</th>
                    <th style="
             border-left:1px solid black;
             border-bottom: 1px solid black;
             border-top: 1px solid black;width:200px;
             border-right: 1px solid black;
             "></th>
            
                  
                    
                    
             </tr> '; }
            }
        
        
            $commandesHtml.='
           
             ';}
            $commandesHtml.='</tbody> </table>';
            $hosp="";
            if(count($hospitaliers) != 0){
                    $hosp=$hospitaliers[0]->annee_universitaire_stage;
            }
        
            PDF::writeHTMLCell(0, 0,79, 4,$headTop,0, 1, 0, true, '', true);    
            //PDF::writeHTMLCell(0, 0,88, 11,$numStage,0, 1, 0, true, '', true); 
            PDF::writeHTMLCell(0, 0,'', 24,'<hr>',0, 1, 0, true, '', true); 
            PDF::writeHTMLCell(0, 0, '',28,'<span style="color:red"><u> Sites des Stages:</u> ('.$hosp.') </span>', 0, 1, 0, true, '', true);
            PDF::writeHTMLCell(0, 0,'', 30,$commandesHtml,0, 1, 0, true, '', true);   
    
        PDF::Output('evaluation.pdf');
    
    }
}
