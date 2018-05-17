
<template>
<div>
             <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification error"/> 
    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
     <div v-if="!loading" >
      <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
        <a class="btn btn-primary float-right " @click="redirect_To_ShowEvaluation(stagiaire)"> <i class="fas fa-long-arrow-alt-left"></i> </a>

        </div>
  
    </div>
    <h2>Modifier Evaluation</h2>
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
<div class="text-center pull-right">
    <h2>Modifier Notes</h2>
    <hr>   
    </div>

    <form   @submit.prevent="updateNotes">

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
                                     <input class="form-control"  type="text" v-model="objectif.note"  ></th>
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
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Commentaire </label>
                    <div class="col-sm-8">
                        <textarea class="noteCondition" name="" id="" cols="40" rows="3" v-model="objectif.commentaire"></textarea>

                    </div>
                </div> 
                 <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Nombre des Absences non Justifié (enregistré) : </label>
                    <div class="col-sm-7">
                       <input class="form-control"  type="text" v-model="objectif.nombreAbsence"  disabled>
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Nombre des Absences non Justifié (actuelle) : </label>
                    <div class="col-sm-7">
                       <input class="form-control"  type="text" v-model="totalNote.count"  disabled>

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
                    nombreAbsence:0,
              }, 
              fk_stagiaire:"",
               objectifs:[],
               evaluation:{
                   fk_stagiaire:"",
                   fk_stage:"",
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
                 count:0,
                 etat:"",
                 }, 
                 totalCoeff:0,
                   
               note:{
                   id_note:0,
                   note:0,
                   fk_objectif:0,
                   fk_evaluation:0,
              },
                noteType:[],
               notes:[],
               typeObjectifs:[],
      }),
      computed:{
          
    TotalNote(){   
            let sum=0;
              let sumO=0;
            let sum_coeff=0;
            let total=0;
           console.log('===== note === ')
      console.log(this.notes)
       for (let index1 = 0; index1 < this.typeObjectifs.length; index1++) {
           console.log("boucle ============>")
           //console.log(this.type_objectifs[index].id_type)
          // console.log(this.objectifs[index].fk_type_objectif)
          
                   let sumtype=0;
            for (let index = 0; index < this.objectifs.length; index++) { 
            
                 if(this.typeObjectifs[index1].id_type === this.objectifs[index].fk_type_objectif){ 
                if(this.objectifs[index].note>this.objectifs[index].coefficient || this.objectifs[index].note === ''){
                    //alert("la note doit etre inferieure au coefficient")
                   this.objectifs[index].note=0;
                    this.$notify({
                                      group: 'foo',
                                      title: 'Erreur',
                                      text: 'la note doit être inferieure au coefficient!',
                                      duration: 1500,
                                    });
                }
                 if(this.objectif.noteStage>20 || this.objectif.noteStage === ''){
                    //alert("la note de stage doit etre inferieure a 20")
                   this.objectif.noteStage=0;
                    this.$notify({
                                      group: 'foo',
                                      title: 'Erreur',
                                      text: 'la note de stage doit être inferieure a 20!',
                                      duration: 1500,
                                    });
                }
                            sumtype=this.precisionRound((+sumtype + +parseInt(this.objectifs[index].note)),2);
                sum=this.precisionRound((+sum + +parseInt(this.objectifs[index].note)),2);

            
                total=this.precisionRound((+this.objectif.noteStage + +sum),2);

              let coeff=this.precisionRound((this.objectifs[index].coefficient),2);
                sum_coeff=this.precisionRound(+sum_coeff + +coeff,2);
            }
                  } this.typeObjectifs[index1].note_type=sumtype; 
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
                    //this.noteObejctif;

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

             getStagiairesParEvaluation(stagiaire){
 axios.get('/getStagiairesParEvaluation/',{ params: {id_stagiaire:stagiaire.id_stagiaire,id_stage:this.$route.params.id_stage } })
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
 axios.get('/getObjectifsNotesStage/',{ params: {id_stagiaire:stagiaire.id_stagiaire,id_stage:this.$route.params.id_stage } })
      
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
    getObjectifsNotes(id_stagiaire){
 axios.get('/getObjectifsNotes/'+id_stagiaire)
                .then((response) => {
                    this.loading = false;
                    this.objectifs = response.data.objectifs;
            this.objectif=response.data.objectifs[0];
            
                                this.typeObjectifs = response.data.typeObjectifs;

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
    countAbsence(id_stagiaire){
 axios.get('/countAbsence/'+id_stagiaire)
                .then((response) => {
                   // this.loading = false;
                    this.totalNote.count = response.data.count;
                  
                    console.log('count absences***************')
                    console.log(this.totalNote.count)
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
    updateNotes(){ 
        
          if(this.totalNote.count >= 3 || this.objectif.noteFinal < 10){
this.objectifs[0].etat ='non valide';
console.log('non valideeeeeeeeeee **************')
        }
        else{
this.objectifs[0].etat ='valide';
console.log('************** valideeeeeeeeeee')

        }
              console.log("test")
           console.log(this.objectif);
               
              axios.post('/updateNotes',{objectifs:this.objectifs,typeObjectifs:this.typeObjectifs}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowEvaluation', params: { stagiaire:this.stagiaire,id_stage:this.evaluation.fk_stage,success: "edit"  }});

                  });
            
        },
        redirect_To_ShowEvaluation(stagiaire){
        console.log('stagiaire')
                      console.log(this.stagiaire)
                     this.$router.push({ name: 'ShowEvaluation', params: { stagiaire:stagiaire}});
        //this.$router.push({ name: 'Editstagiaire', params: {stagiaire:this.stagiaire}});
//console.log(stagiaire)
            },
           precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},
    fetchData(){
                         if(this.$route.params.stagiaire.id_stagiaire == undefined){
              this.$router.push({ name: 'ShowStagiairesEva'});
         }
this.evaluation.fk_stage=this.$route.params.id_stage;
console.log(this.evaluation.fk_stage)
        //this.stagiaire.id_stagiaire=this.$route.params.id_stagiaire;
        this.evaluation.fk_stagiaire=this.$route.params.stagiaire.id_stagiaire;
        this.getTypeObjectifs();
        this.getStagiairesParEvaluation(this.$route.params.stagiaire);
       // this.getObjectifsNotes( this.evaluation.fk_stagiaire);
        this.countAbsence(this.evaluation.fk_stagiaire);
        this.getObjectifsNotesStage(this.$route.params.stagiaire);

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

</style>
