
<template>
<div>

    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
     <div v-if="!loading" >
    <div class="row">
                <div class="col ">
      
    <h3 class=""> Evaluation</h3>
    </div>
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowEvaluations'"> 
        <i class="fas fa-long-arrow-alt-left fontsize"></i> 
        </router-link>
            <a href="#" class="float-right btn btn-success"><i class="fas fa-edit d-inline-block"/> Modifier</a>

    <b-btn class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>

        </div>
   
    </div>     

<hr>
<div class="row ">
            
                   
                        <div class="col">
                <div class="form-group row part">
                    <div class="col-md-6">
                        <strong> Année Universitaire: </strong>{{stagiaire.annee_universitaire_stagiaire}} 
                    </div>
                   <div class="col-md-6">
                   <strong> {{stagiaire.niveau_etude_stagiaire}} </strong>de médecine
                   </div>
                </div>
                        </div>
                  
                    <div class="col">
                <div class="form-group row part">
                    <div class="col-md-5">
                    <strong> Nom: </strong>{{stagiaire.nom_stagiaire}} 
                    </div>
                                        <div class="col-md-5">

                    <strong> Prénom: </strong>{{stagiaire.prenom_stagiaire}} 
                                        </div>
                                        <div class="col-md-2">
                    <strong> N°: </strong>{{stagiaire.id_stagiaire}} 
                     </div>
                </div>
                        </div>
                       <div class="col">
                <div class="form-group row part">
                    <div class="col-md-4">
                    <strong> Période de Stage: du</strong>
                    </div>
                     <div class="col-md-4">
                     {{stagiaire.dateDebut_stage}} <strong> au    </strong>
                         </div>
                         <div class="col-md-4">
                      {{stagiaire.dateFin_stage}}
                          </div>
                                             </div>
              
                        </div>
                   
                     <div class="col">
                <div class="form-group row part">
                    <div class="col-md-2">
                    <strong> Hospital: </strong>
                    </div>
                    <div class="col-md-10">
                    {{stagiaire.nom_hospitalier}} 
                      </div>
                                             </div>
              
                        </div>
                   
                       <div class="col">
                <div class="form-group row part">
                    <div class="col-md-6">
                    <strong> Service: </strong>{{stagiaire.service_evaluateur}} 
                    </div>
                    <div class="col-md-6">
                    <strong> Nom du MS: </strong>

                       </div>
                                             </div>
              
                        </div>
                                      
          
</div>
<hr>
<div class=" container colBackround">

    <form   @submit.prevent="addEvaluation">

<div class="row"> 
    <div class="col">
       <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <div v-for="(type_objectif,index) in type_objectifs" :key="index" >
                  <h3> Type Objectif :<strong>  {{type_objectif.type_objectif}}</strong></h3>

                                    <tr>
                                    <th>objectifs</th>
                                    <th>coefficient</th>
                                    <th>note</th>
                                    </tr> 
  
                              <tr v-for="(objectif,index) in objectifs" v-if="objectif.fk_type_objectif===type_objectif.id_type" :key="index" >
                               
                               <input class="form-control"  type="text" v-model="objectif.fk_type_objectif" disabled hidden>
                              
                                 <th>{{objectif.objectif}} </th>
                              
                                <th> {{objectif.coefficient}}    </th>
                         
                                <th>{{objectif.note}}</th>
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
<div class="row">
<div class="col-md-6 col-sm-12">

                <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Commentaire </label>
                    <div class="col-sm-8">
                        {{objectif.commentaire}}

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
                       <button  class="btn mb-3  btn-success">Enregister</button>

   </form>
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
      }),
    
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
      

methods: { 

      getStagiairesParEvaluation(id_stagiaire){
 axios.get('/getStagiairesParEvaluation/'+id_stagiaire)
                .then((response) => {
                    this.stagiaire = response.data.stagiaires[0];
                    console.log('response objectifs')
                    console.log(response)
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },   
    getObjectifsNotes(id_stagiaire){
 axios.get('/getObjectifsNotes/'+id_stagiaire)
                .then((response) => {
                    this.loading = false;
                    this.objectifs = response.data.objectifs;
                    this.objectif = response.data.objectifs[0];

                    console.log('response objectifs')
                    console.log(response)
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
     getTypeObjectifs(){
           axios.get('/getTypeObjectifs')
            .then((response) => {
                console.log(response.data.listeTypeObjectifs);
                    this.type_objectifs = response.data.listeTypeObjectifs;
                  this.loading= false;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
 },

 
    fetchData(){
        //this.stagiaire.id_stagiaire=this.$route.params.id_stagiaire;
        this.evaluation.fk_stagiaire=2;
        this.getTypeObjectifs();
        this.getStagiairesParEvaluation(this.evaluation.fk_stagiaire);
        this.getObjectifsNotes( this.evaluation.fk_stagiaire);
    }

},

}
</script>
<style scoped>
.part {
    width: 800px;
}
</style>
