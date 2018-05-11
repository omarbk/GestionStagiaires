
<template>
<div>

    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
     <div v-if="!loading" >
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowEvaluations'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>     
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Evaluation</h5>
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

    <form   @submit.prevent="updateNotes">

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
                              
                                 <th> <input class="form-control"  type="text" v-model="objectif.objectif" disabled ></th>
                              
                                <th> <input class="form-control ThWidth"  type="text" v-model="objectif.coefficient" disabled>
                                 </th>
                         
                                <th>
                                     <input class="form-control"  type="text" v-model="objectif.note"  ></th>
                             </tr>
                       <!--          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Moyenne de type:</label>
            <div class="col-sm-8">
            {{noteType}} /20
            </div>
         </div>-->
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
                        <textarea class="noteCondition" name="" id="" cols="40" rows="3" v-model="objectif.commentaire"></textarea>

                    </div>
                </div> 

    </div>
      <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Note Fin de Stage </label>
            <div class="col-sm-8">
            <input type="text" class="form-control" id="staticEmail" v-model="objectif.noteStage">
            </div>
         </div>
       <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total </label>
            <div class="col-sm-8">
            {{objectif.totalNotes}} /{{totalCoeff}}
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
                 id_total_note:0,
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
      computed:{
          
    TotalNote(){   
            let sum=0;
              let sumO=0;
            let sum_coeff=0;
            let total=0;
     
            for (let index = 0; index < this.objectifs.length; index++) {            
                if(this.notes[index]>this.objectifs[index].coefficient || this.notes[index] === ''){
                    alert("la note doit etre inferieure au coefficient")
                   this.notes[index]=0;
                }
                 if(this.objectif.noteStage>20 || this.objectif.noteStage === ''){
                    alert("la note de stage doit etre inferieure a 20")
                   this.objectif.noteStage=0;
                }
              
                sum=this.precisionRound((+sum + +parseInt(this.objectifs[index].note)),2);

            
                total=this.precisionRound((+this.objectif.noteStage + +sum),2);

              let coeff=this.precisionRound((this.objectifs[index].coefficient),2);
                sum_coeff=this.precisionRound(+sum_coeff + +coeff,2);
            }
                //console.log(total)

                // let coeff_final=this.precisionRound(sum_coeff+20,2);
                this.totalCoeff=this.precisionRound(sum_coeff+20,2);
                this.objectif.totalNotes=this.precisionRound(total,2);
                //console.log("suuuum   " +coeff_final )
                this.objectif.noteFinal= this.precisionRound( total*20/this.totalCoeff,2);
    },

      },
      watch:{
  objectifs:{
            handler: function(){
                   // console.log('objectif watch')
                    this.TotalNote;
                    //this.noteObejctif;

            },
                deep : true
  },
    type_objectifs:{
            handler: function(){
                    this.noteObejctif;

            },
                deep : true
  },
   notes:{
            handler: function(){
                    console.log('objectif watch')
                    this.TotalNote;
                   // this.noteObejctif;

            },
                deep : true
  },
 'totalNote.noteStage':{
            handler: function(){
                   
                    this.TotalNote;

            },
    
    },
      },
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
            this.objectif=response.data.objectifs[0];
                    console.log('response objectifs')
                    console.log(this.objectif)
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
    updateNotes(){ 
              console.log("test")
           console.log(this.objectif);
               
              axios.post('/updateNotes',{objectifs:this.objectifs}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowEvaluation', params: { success: "edit"  }});

                  });
            
        },
           precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
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
