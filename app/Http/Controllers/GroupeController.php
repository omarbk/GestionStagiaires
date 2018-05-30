<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groupe;
use App\Calendrier;
use App\Groupe_stagiaire;
use App\Stagiaire;
use PDF;
class GroupeController extends Controller
{
    public function searchGroupes($search_G){
        $groupes = Groupe::where('nom_groupe','like', '%' .$search_G . '%')->orWhere('annee_universitaire_groupe','like', '%' .$search_G . '%')->paginate(6);
        return Response()->json(['groupes' => $groupes ]);
     }
    public function addGroupe(Request $request)
    { 
      
        
        $groupe = new Groupe();  
 
                $groupe->nom_groupe = $request->groupe['nom_groupe'];
                $groupe->annee_universitaire_groupe = $request->groupe['annee_universitaire_groupe'];                
                $groupe->save();
                $id_groupe = $groupe->id_groupe;
                $this->addCalendrier($request,$id_groupe);
                $this->addGroupe_Stagiaires($request,$id_groupe);
                 return Response()->json(['etat' => true]);
            
    }
   
    public function addGroupe_Stagiaires(Request $request,$id_groupe)
    { 
        
           for($i=0;$i<count($request->pushStagiaire);$i++) {    
            $groupe_stagiaire = new Groupe_stagiaire();
            $groupe_stagiaire->fk_stagiaire=$request->pushStagiaire[$i]['id_stagiaire'];
            $groupe_stagiaire->fk_groupe=$id_groupe;
            $groupe_stagiaire->save();
           }
                // return Response()->json(['etat' => true]);
            
    }










    public function addCalendrier(Request $request,$id_groupe)
    { 
        
           for($i=0;$i<count($request->calendriers);$i++) {    
        $calendrier = new Calendrier();  
        $calendrier->nomMoisDebut=$request->calendriers[$i]['nomMoisDebut'];
        $calendrier->nomMoisFin=$request->calendriers[$i]['nomMoisFin'];
        $calendrier->mois_stage_cal=$request->calendriers[$i]['mois_stage_cal'];
        $calendrier->debut_semaine_cal=$request->calendriers[$i]['debut_semaine_cal'];
        $calendrier->fin_semaine_cal=$request->calendriers[$i]['fin_semaine_cal'];
        $calendrier->NbJours=$request->calendriers[$i]['NbJours'];
        $calendrier->lundi_cal=$request->calendriers[$i]['lundi_cal'];
        $calendrier->mardi_cal=$request->calendriers[$i]['mardi_cal'];
        $calendrier->mercredi_cal=$request->calendriers[$i]['mercredi_cal'];
        $calendrier->jeudi_cal=$request->calendriers[$i]['jeudi_cal'];
        $calendrier->vendredi_cal=$request->calendriers[$i]['vendredi_cal'];
        $calendrier->fk_groupe=$id_groupe;
        
                $calendrier->save();
           }

        

                // return Response()->json(['etat' => true]);
            
    }
    public function getGroupes(){

        $listeGroupes = Groupe::paginate(10);
        
        return Response()->json(['groupes' => $listeGroupes ]);
     }

     public function getAllGroupes(){

        $listeGroupes = Groupe::all();
        
        return Response()->json(['groupes' => $listeGroupes ]);
     }
     

     public function deleteGroupe($id_groupe){

        $groupe = Groupe::find($id_groupe)->delete();
        $groupe_stagiaires = Groupe_stagiaire::where('fk_groupe','=',$id_groupe)->forceDelete();
        $calendrier = Calendrier::where('fk_groupe','=',$id_groupe)->delete();
        return Response()->json(['delete' => 'true']);
     }
     public function getGroupe($id_groupe){
        $groupe= Groupe::find($id_groupe);
        $groupe_stagiaire = Groupe_stagiaire::leftJoin('stagiaires', 'stagiaires.id_stagiaire', '=', 'groupe_stagiaires.fk_stagiaire')
        ->select('stagiaires.*','groupe_stagiaires.*')
        ->where('groupe_stagiaires.fk_groupe','=',$id_groupe)->get();
        return Response()->json(['groupe' => $groupe,'groupe_stagiaire' => $groupe_stagiaire]);
     }
     
     public function getCalendriers($fk_groupe){
        $calendriers= Calendrier::where('fk_groupe', $fk_groupe)->get();
        return Response()->json(['calendriers' => $calendriers ]);
     }

     public function updateGroupe(Request $request){

        $groupe = Groupe::find($request->groupe['id_groupe']);

        $groupe->nom_groupe = $request->groupe['nom_groupe'];
        $groupe->annee_universitaire_groupe = $request->groupe['annee_universitaire_groupe'];
        $groupe->save();
        $id_groupe = $groupe->id_groupe;
        $this->updateCalendrier($request,$id_groupe);
        $this->updateGroupeStagiaire($request,$id_groupe);

        return Response()->json(['etat' => true]);
     }

     public function updateCalendrier(Request $request , $id_groupe){

        for($i=0;$i<count($request->suppCalendriers);$i++){
         $calendrier = Calendrier::find($request->suppCalendriers[$i]['id_calendrier']);
         $calendrier->delete();
 
         }
         for($i=0;$i<count($request->calendriers);$i++){
             if (!isset($request->calendriers[$i]['id_calendrier'])) {
                 $calendrier = new Calendrier();
                 $calendrier->nomMoisDebut=$request->calendriers[$i]['nomMoisDebut'];
                 $calendrier->nomMoisFin=$request->calendriers[$i]['nomMoisFin'];
                 $calendrier->mois_stage_cal=$request->calendriers[$i]['mois_stage_cal'];
                 $calendrier->debut_semaine_cal=$request->calendriers[$i]['debut_semaine_cal'];
                 $calendrier->fin_semaine_cal=$request->calendriers[$i]['fin_semaine_cal'];
                 $calendrier->NbJours=$request->calendriers[$i]['NbJours'];
                 $calendrier->lundi_cal=$request->calendriers[$i]['lundi_cal'];
                 $calendrier->mardi_cal=$request->calendriers[$i]['mardi_cal'];
                 $calendrier->mercredi_cal=$request->calendriers[$i]['mercredi_cal'];
                 $calendrier->jeudi_cal=$request->calendriers[$i]['jeudi_cal'];
                 $calendrier->vendredi_cal=$request->calendriers[$i]['vendredi_cal'];
                 $calendrier->fk_groupe=$id_groupe;
                 $calendrier->save();
             }    
         }
         for($i=0;$i<count($request->calendriers);$i++){
             if (isset($request->calendriers[$i]['id_calendrier'])) {
         Calendrier::where('id_calendrier','=', $request->calendriers[$i]['id_calendrier'])->update([
         "nomMoisDebut" => $request->calendriers[$i]['nomMoisDebut'],
         "nomMoisFin" => $request->calendriers[$i]['nomMoisFin'],
         "mois_stage_cal" => $request->calendriers[$i]['mois_stage_cal'],
         "debut_semaine_cal" => $request->calendriers[$i]['debut_semaine_cal'],
         "fin_semaine_cal" => $request->calendriers[$i]['fin_semaine_cal'],
         "NbJours" => $request->calendriers[$i]['NbJours'],
         "lundi_cal" => $request->calendriers[$i]['lundi_cal'],
         "mardi_cal" => $request->calendriers[$i]['mardi_cal'],
         "mercredi_cal" => $request->calendriers[$i]['mercredi_cal'],
         "jeudi_cal" => $request->calendriers[$i]['jeudi_cal'],
         "vendredi_cal" => $request->calendriers[$i]['vendredi_cal'], 
         ]);
             }
         }
  
      }

      public function updateGroupeStagiaire(Request $request , $id_groupe){

       
        
        for($i=0;$i<count($request->suppStagiaires);$i++){
         $calendrier = Groupe_stagiaire::where('fk_stagiaire',$request->suppStagiaires[$i]['id_stagiaire'])->where('fk_groupe', $id_groupe)->forceDelete();
 
         }
        for($i=0;$i<count($request->pushStagiaire);$i++){
             if (!isset($request->pushStagiaire[$i]['fk_groupe'])) {
                $groupe_stagiaire = new Groupe_stagiaire();
                $groupe_stagiaire->fk_stagiaire=$request->pushStagiaire[$i]['id_stagiaire'];
                $groupe_stagiaire->fk_groupe=$id_groupe;
                $groupe_stagiaire->save();
             }    
         }
      }
      public function PdfCalendriersParStagiaire($id_stagiaire,$id_stage){
        
       // $calendriers= Calendrier::where('fk_groupe', $fk_groupe)->get();
       // return Response()->json(['calendriers' => $calendriers ]);
        $stagiaires  = Stagiaire::
        leftJoin('groupe_stagiaires','stagiaires.id_stagiaire','=','groupe_stagiaires.fk_stagiaire')
        ->leftJoin('groupes', 'groupe_stagiaires.fk_groupe', '=', 'groupes.id_groupe')
        ->leftJoin('stage_groupes', 'groupes.id_groupe', '=', 'stage_groupes.fk_groupe')
        ->leftJoin('stages', 'stage_groupes.fk_stage', '=', 'stages.id_stage')
        ->leftJoin('hospitaliers', 'stages.fk_hospitalier', '=', 'hospitaliers.id_hospitalier')
        ->leftJoin('evaluateurs', 'stages.fk_evaluateur', '=', 'evaluateurs.id_evaluateur')
        //->leftJoin('calendriers', 'calendriers.fk_groupe', '=', 'groupes.id_groupe')
        ->select('stagiaires.*','groupes.*','stages.*','hospitaliers.*','evaluateurs.*')
        ->where('stagiaires.id_stagiaire','=',$id_stagiaire)
        ->where('stages.id_stage','=',$id_stage)
        ->get();
        PDF::setFooterCallback(function($pdf) {
            //dd($infoComp);
           // dd($this->template);
             // Position at 15 mm from bottom
            // $pdf->SetY(-15);
             // Set font
             $pdf->SetFont('helvetica', 'I', 10);
             // Page number
             PDF::writeHTMLCell(0, 0, '',250,'Cachet et signature du chef de service', 0, 1, 0, true, '', true);
             PDF::writeHTMLCell(0, 0, 130,250,'Cachet et signature des maitres de stage', 0, 1, 0, true, '', true);
             PDF::writeHTMLCell(0, 0,'',285,'<hr>', 0, 1, 0, true, '', true);
             PDF::writeHTMLCell(0, 0, '',290,'<span style="color:blue;text-align:right"> Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages().'</span>', 0, 1, 0, true, '', true);
        
            // $pdf->Cell(0, 10, $this->template.'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
         });

        $calendriers= Calendrier::where('fk_groupe', $stagiaires[0]->id_groupe)->get();

       // return Response()->json(['stagiaires' => $stagiaires ,'calendriers' => $calendriers]);
       $logo = public_path().'/storage/images/Um6ss_logo.png';
       $headerHtml =  '<div>
       <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
  
        </div>
       <br>
        ';
        $month = array(
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
           '10'=> 'Octobre',
           '11' => 'Novembre',
           '12' => 'Décembre'
       );
      //dd($month['01']);
      $dateDebutStage=date_create($stagiaires[0]->dateDebut_stage);
      $annee = date_format($dateDebutStage,"Y");
      $moisD = date_format($dateDebutStage,"m");
      $jourD = date_format($dateDebutStage,"d");
      $dateFinStage=date_create($stagiaires[0]->dateFin_stage);
      $moisF = date_format($dateFinStage,"m");
      $jourF = date_format($dateFinStage,"d");

      $dateFin; 
     foreach ($month as $i => $value) {
         $j = (string)$i;
         if($j === $moisD){
            $dateFin = $month[$j];}
    }

      $dateDebut; 
     foreach ($month as $i => $value) {
         $j = (string)$i;
         if($j === $moisD){
            $dateDebut = $month[$j];}
    }


    $commandesHtml ='<table  border="1" style="padding: 3px 0px;" cellpadding="2">
            <thead>
            <tr>
                   <th align="center"></th>
                   <th align="center">Semaine</th>
                   <th align="center">Lundi</th>
                   <th align="center">Mardi</th>
                   <th align="center">Mercredi</th>
                   <th align="center">jeudi</th>
                   <th align="center">vendredi</th>
            </tr>
                    </thead>';
             $commandesHtml.='<tbody>';
            foreach ( $calendriers as $calendrier ){
                $commandesHtml.='
               
                <tr>                   
                <th align="center">'.$calendrier->nomMoisDebut.'</th>
                <th align="center">Du '.$calendrier->debut_semaine_cal.' '.$calendrier->nomMoisDebut.' au '.$calendrier->fin_semaine_cal.' '.$calendrier->nomMoisFin.'</th>
                <th align="center">'.$calendrier->lundi_cal.' </th>
                <th align="center">'.$calendrier->mardi_cal.'</th>
                <th align="center">'.$calendrier->mercredi_cal.'</th>
                <th align="center">'.$calendrier->jeudi_cal.'</th>
                <th align="center">'.$calendrier->vendredi_cal.'</th>
                        
                 </tr>
                 ';}
                $commandesHtml.='</tbody> </table>';
        
        PDF::SetTitle('calendrier');

        PDF::AddPage();
        PDF::writeHTMLCell(0, 0, 10,'',$headerHtml ,0, 1, 0, true, 'left', true);
        PDF::writeHTMLCell(0, 0,80, 50,'Année Universitaire : '.$stagiaires[0]->annee_universitaire_groupe.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,77, 57,'Faculté de médecine : '.$stagiaires[0]->niveau_etude_stagiaire.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,74, 64,$stagiaires[0]->intitule_stage.' Du '.$jourD.' '.$dateDebut.' au '.$jourF.' '.$dateFin.' '.$annee,0, 1, 0, true, '', true);
        PDF::writeHTMLCell(190, 0,'',75,'<center><h3>Fcihe de Présence  '.$stagiaires[0]->nom_hospitalier.' '.$stagiaires[0]->nom_groupe.'</h3></center>',1, 1, 0, true, 'C', true);
        PDF::writeHTMLCell(0, 0,'', 85,'Nom de l\'étudiant : '.$stagiaires[0]->nom_stagiaire.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 91,'Prénom de l\'étudiant : '.$stagiaires[0]->nom_stagiaire.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 97,'Groupe de stage : '.$stagiaires[0]->nom_groupe.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 103,'Site de stage : '.$stagiaires[0]->nom_hospitalier.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 109,'Discipline : Médecine',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 115,'Affectation : '.$stagiaires[0]->nom_hospitalier.'',0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 121,'Maitre de stage : '.$stagiaires[0]->nom_evaluateur,0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0,'', 130,$commandesHtml,0, 1, 0, true, '', true); 
        PDF::Output('calendrier.pdf');

//writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)



     }

  
}
