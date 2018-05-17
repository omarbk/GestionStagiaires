
<template>
<div>

   <!-- au cas ajout bien passé afficher ce message -->   
             <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/>   


    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
     <div v-if="!loading" >
               <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
        <a class="float-right btn btn-primary" @click="redirect_To_ShowEvaluationStage(stagiaire)"> <i class="fas fa-long-arrow-alt-left"></i> </a>

        </div>
  
    </div>
    <h2>Affichage Evaluation</h2>
    <hr>   
    </div> 
<div class=" container colBackround size">
      <br>
    <div class="row align-items-center">
    <div class="col-1">
             <img v-if="stagiaire.photo_stagiaire != ''" class="card-img-top tailleImage" :src="'storage/images/'+stagiaire.photo_stagiaire" alt="Card image cap" width="100px" height="150px">
            <img v-if="stagiaire.photo_stagiaire === ''" class="card-img-top tailleImage" :src="'storage/images/user0.jpg'" alt="Card image cap" width="100px" height="150px">
    
    </div>
    <div class="col">
            <br>
                 <h5>Information du Stagiaire</h5>
        
        </div>
</div>

<hr>  

<!-- stagiaire --> 
<div class="row ">
     
                    
                    <div class="col-md-5 col-sm-10">

                <div class="form-group row">  
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Année Universitaire : </label>
                        <div class="col-sm-5">
                        {{stagiaire.annee_universitaire_stagiaire}} 
                    </div>
                         </div> 

    </div>
  <div class="col-md-5 col-sm-10">

                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Niveau d'Etude : </label> 
                        <div class="col-sm-5">
                             {{stagiaire.niveau_etude_stagiaire}}
                        </div>

                   </div>
                               </div> 

    </div>

<div class="row ">
                     <div class="col-md-5 col-sm-10">

                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Nom : </label> 
                        <div class="col-sm-5">
                   {{stagiaire.nom_stagiaire}} 
                    </div>
                    </div>
                               </div> 
                                       <div class="col-md-5 col-sm-10">

                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Prénom : </label> 
                        <div class="col-sm-5">
                    {{stagiaire.prenom_stagiaire}} 
                                        </div>
                                         </div>
                               </div> 
                     <div class="col-md-2 col-sm-4">
                                         <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >N° : </label> 
                        <div class="col-sm-5">
                   {{stagiaire.id_stagiaire}} 
                     </div>
                        </div>
                               </div> 
                </div>
            
<div class="row ">
                      <div class="col-md-5 col-sm-10">

                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Période de Stage : </label> 
                        <div class="col-sm-5">
                    <strong>du </strong>
                    
                     {{stagiaire.dateDebut_stage}} <strong> au </strong>
                        
                      {{stagiaire.dateFin_stage}}
                        
                                             </div>
              
                        </div>
                      </div>

                                <div class="col-md-5 col-sm-10">

                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Hospital : </label> 
                        <div class="col-sm-5">
                    {{stagiaire.nom_hospitalier}} 
                      </div>
                                             </div>
              
                        </div>
            </div> 
            <div class="row ">      
                     <div class="col-md-5 col-sm-10">

                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Service : </label> 
                    {{stagiaire.service_evaluateur}} 
                    </div>
                              </div>
              
                       <div class="col-md-5 col-sm-10">

                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5 col-form-label" >Nom du MS : </label> 
                   

                       </div>
                                             </div>
              
                        </div>
<hr>
<div v-if="test==true">
<div class="text-center pull-right">
    <h2> Notes</h2>
    <hr>   
    </div>
    <form  >

<div class="row center"> 
    <div class="col">
       <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <div v-for="(type_objectif,index) in typeObjectifs" :key="index" >
                 <br>
                  <h3> Type Objectif :<strong>  {{type_objectif.type_objectif}}</strong></h3>

                                    <tr>
                                    <th>objectifs</th>
                                    <th>coefficient</th>
                                    <th>note</th>
                                    </tr> 
      <tr v-for="(objectif,index) in objectifs" v-if="objectif.fk_type_objectif===type_objectif.id_type" :key="index" >
                               
                               <input class="form-control"  type="text" v-model="objectif.fk_type_objectif" disabled hidden>
                              
                                 <th> <input class="form-control"  type="text" v-model="objectif.objectif" disabled ></th>
                              
                                <th> <input class="form-control ThWidth"  type="text" v-model="objectif.coefficient" disabled>
                                 </th>
                         
                                <th>
                                     <input class="form-control"  type="text" v-model="objectif.note" disabled ></th>
                             </tr>
                       <tr>
                                 <th>
                           Moyenne de type</th>
                           <th>:</th>
          <th>

            {{type_objectif.note_type}} /20  
          </th>
                             </tr>
           
                                        </div>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                                                
                            </div>
             </div>
     </div>

    
    
    </div>
</div>
<hr>
<hr>
<div class="row">
<div class="col-md-6 col-sm-12">

                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-6 col-form-label" >Commentaire : </label>
                    <div class="col-sm-6">
                        {{objectif.commentaire}}

                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-6 col-form-label" >Nombre des Absences non Justifié : </label>
                    <div class="col-sm-6">
                        {{objectif.nombreAbsence}}

                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-6 col-form-label" >Etat : </label>
                   
                    <div class="col-sm-6 etat" v-if="objectif.etat == 'valide'" style="color:rgb(146, 239, 7);" >
                        {{objectif.etat}}
                  
                    </div>
                      <div class="col-sm-6 etat" v-if="objectif.etat == 'non valide'" style="color:red" >
                        {{objectif.etat}}
                  
                    </div>
                </div> 

    </div>
      <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Note Fin de Stage </label>
            <div class="col-sm-8">
            {{objectif.noteStage}}/20
            </div>
         </div>
       <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total </label>
            <div class="col-sm-8">
            {{objectif.totalNotes}} 
            </div>
         </div>
     
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Moyenne de Stage </label>
            <div class="col-sm-8">
            {{objectif.noteFinal}} /20
            </div>
         </div>
      
    </div>
</div>

   </form>
</div>
</div>
     </div>
</div>
</template>

<script>

   
    export default{ 
        
          data: () => ({
                TestConvertDevis:false,
                loading: false,
                error:false,
                stagiaire:{
                    id_stagiaire:0,
                    nom_stagiaire : "",
                    prenom_stagiaire : "",

                },
        stagiaires:[],
        objectif: { 
                    id_evaluation_objectif : 0,
                    objectif : "",
                    fk_type_objectif : "",
                    annee_objectif:"",
                    coefficient : "",

                    
              }, 
              fk_stagiaire:"",
               objectifs:[],
               evaluation:{
                   fk_stagiaire:"",
               },
             type_objectifs:[],
             type_objectif:{
                 id_type:0,
             },
             totalNote:{
                 commentaire:"",
                 noteStage:0,
                 totalNotes:0,
                 noteFinal:0,
                 }, 
                 totalCoeff:0,
                   
               note:{
                   id_note:0,
                   note:0,
                   fk_objectif:0,
                   fk_evaluation:0,
              },
                noteType:0,
               notes:[],
                typeObjectifs:[],
               test:false,
      }),
    
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
      

methods: { 

       getStagiairesParEvaluation(stagiaire){
 axios.get('/getStagiairesParEvaluation/',{ params: {id_stagiaire:stagiaire.id_stagiaire,id_stage:this.id_stage } })
                .then((response) => {
                                                            this.loading = false;
                    this.stagiaire = response.data.stagiaires[0];
                    console.log('response objectifs')
                    console.log(response)

               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },   
    getObjectifsNotesStage(stagiaire){
 axios.get('/getObjectifsNotesStage/',{ params: {id_stagiaire:stagiaire.id_stagiaire,id_stage:stagiaire.id_stage } })
                .then((response) => {
                                                           this.loading = false;

                    console.log(response.data.objectifs.length)
                    if(response.data.objectifs.length == 0){
                        this.test =false;
                        console.log('emptyyyyyyy')
                    }
                   else{
                        this.test =true;
                    this.objectifs = response.data.objectifs;
                    this.objectif = response.data.objectifs[0];
                    this.typeObjectifs = response.data.typeObjectifs;

                   }

                    console.log('response objectifs note')
                    console.log(response.data.objectifs)
               })
                .catch(() => {
                    console.log('handle server error from here11111');
                });
    },
     getTypeObjectifs(){
           axios.get('/getTypeObjectifs')
            .then((response) => {
                console.log(response.data.listeTypeObjectifs);
                    this.type_objectifs = response.data.listeTypeObjectifs;
                  //this.loading= false;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
 },


              redirect_To_ShowEvaluationStage(stagiaire){
        console.log('stagiaire')
                      console.log(this.stagiaire)
                     this.$router.push({ name: 'ShowEvaluationStage', params: { stagiaire:stagiaire,id_stage:this.id_stage}});
       
                          this.loading = false;

          },

    fetchData(){
                this.loading = true

                     console.log('====== ok =====')
        console.log(this.$route.params.stagiaire.id_stage)
        this.id_stage=this.$route.params.stagiaire.id_stage;
        
        console.log('====== xxxxx =====')
        console.log(this.$route.params.stagiaire.fk_evaluation)
        this.evaluation.fk_stagiaire=this.$route.params.stagiaire.id_stagiaire;
        this.getTypeObjectifs();
        this.getStagiairesParEvaluation(this.$route.params.stagiaire);
        this.getObjectifsNotesStage(this.$route.params.stagiaire);
    }

},

        mounted(){
             if(this.$route.params.stagiaire.id_stagiaire == undefined){
              this.$router.push({ name: 'ShowStagiairesResp'});
         }
   
           if( this.$route.params.success == "add"){
             
                       // this.Testopen.testnotifAdd = true;                  
                                   this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Evaluation bien ajouter!',
                                      duration: 1500,
                                    });
          }
                    if( this.$route.params.success == "edit"){
             
                             this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Evaluation bien modifier!',
                                      duration: 1500,
                                    });
          }
        },
     
}
</script>
<style scoped>
.part {
    width: 800px;
}

 .thSmaine{
    width: 147px;
 }
  .sizeSmaine{
    width: 42px;
    min-width: 59px;
 }
  .sizeJour{
    width: 42px;
    min-width: 70px;
 }
 .sizeMoisFin{
         width: 42px;
    min-width: 42px;
 }
 .sizeMois{
   width: 155px;
 }
 .btnMarge{
     padding-bottom: 10px;
 }
 .widthCard{
     width: 270px;
     height: 350px;
     
 }
 .widthTextCard{
     width  : 236px;
     height: 13px;
 }
 a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.current {
  color: red;
}
ul {
  padding: 0;
  list-style-type: none;
}
li {
  display: inline;
  margin: 5px 5px;
}

a.first::after {
  content:'...'
}

a.last::before {
  content:'...'
}
.cardbox:hover{
 box-shadow: 1px 2px 2px 2px #c9ced2;
}
ul{
  margin: 0;
  padding: 0;
  list-style: none;
}
a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.fontsize{

    font-size: 1.30rem;
}
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.tailleImage{
    height:62px;
}
.size{
    width: 1000px;
}
.total{
    margin-left: 140px;
}
label{
    font-weight: bold;
}
.center{
margin-left:180px; 
}
.etat{
        font-size: medium;
    font-weight: bold;
}


.lds-hourglass {
  display: inline-block;
  position: relative;
  width: 0px;
  height: 20px;
}
.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  margin: 6px;
  box-sizing: border-box;
  border: 15px solid #fff;
  border-color: rgb(0, 0, 0) transparent rgb(0, 0, 0) transparent;
  animation: lds-hourglass 1.2s infinite;
}
@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}
.ThWidth{

    min-width: 59px;

}
</style>
