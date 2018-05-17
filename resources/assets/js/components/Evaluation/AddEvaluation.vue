
<template>
<div>
 <!-- au cas ajout bien passé afficher ce message -->   
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
    <h2>Ajouter Evaluation</h2>
    <hr>   
    </div> 

<div class=" container colBackround total size">
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
    <h2>Ajouter Notes</h2>
    <hr>   
    </div>


    <form   @submit.prevent="addEvaluation">

<div class="row center"> 
    <div class="col">
       <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <div v-for="(type_objectif,index) in type_objectifs" :key="index" >
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
                                     <input class="form-control"  type="text" v-model="notes[index]"  ></th>
                             </tr>
                             <tr>
                                 <th>
                           Moyenne de type</th>
                           <th>:</th>
          <th>

            {{noteType[index]}} /20  
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
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Commentaire : </label>
                    <div class="col-sm-8">
                        <textarea class="noteCondition" name="" id="" cols="40" rows="3" v-model="totalNote.commentaire"></textarea>

                    </div>
                </div>

                 <div class="form-group row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Nombre des Absences non Justifié : </label>
                   <div class="col-sm-7">
                       <input class="form-control"  type="text" v-model="totalNote.count"  disabled>
                    </div>
                </div>  

    </div>
      <div class="col-md-6 col-sm-12">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Note Fin de Stage </label>
            <div class="col-sm-8">
            <input type="text" class="form-control" id="staticEmail" v-model="totalNote.noteStage">
            </div>
         </div>
       <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total </label>
            <div class="col-sm-8">
            {{totalNote.totalNotes}} /{{totalCoeff}}
            </div>
         </div>
     
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Moyenne de Stage </label>
            <div class="col-sm-8">
            {{totalNote.noteFinal}} /20
            </div>
         </div>
      
    </div>
</div>
                       <button  class="btn mb-3  btn-success">Enregister</button>

   </form>
</div>
     </div>
     <br>
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
      }),
      computed:{
          
    TotalNote(){   
            let sum=0;
              let sumO=0;
            let sum_coeff=0;
            let total=0;
      console.log('===== note === ')
      console.log(this.notes)
       for (let index1 = 0; index1 < this.type_objectifs.length; index1++) {
           console.log("boucle ============>")
           //console.log(this.type_objectifs[index].id_type)
          // console.log(this.objectifs[index].fk_type_objectif)
          
                   let sumtype=0;
            for (let index = 0; index < this.objectifs.length; index++) { 
            
                 if(this.type_objectifs[index1].id_type === this.objectifs[index].fk_type_objectif){           
                if(this.notes[index]>this.objectifs[index].coefficient || this.notes[index] === ''){
                    //alert("la note doit etre inferieure au coefficient")
                   this.notes[index]=0;
                   this.$notify({
                                      group: 'foo',
                                      title: 'Erreur',
                                      text: 'la note doit être inferieure au coefficient!',
                                      duration: 1500,
                                    });
                }
                 if(this.totalNote.noteStage>20 || this.totalNote.noteStage === ''){
                    //alert("la note de stage doit etre inferieure a 20")
                   this.totalNote.noteStage=0;
                     this.$notify({
                                      group: 'foo',
                                      title: 'Erreur',
                                      text: 'la note de stage doit être inferieure a 20!',
                                      duration: 1500,
                                    });
                }
              sumtype=this.precisionRound((+sumtype + +parseInt(this.notes[index])),2);
                sum=this.precisionRound((+sum + +parseInt(this.notes[index])),2);

            
                total=this.precisionRound((+this.totalNote.noteStage + +sum),2);

              let coeff=this.precisionRound((this.objectifs[index].coefficient),2);
                sum_coeff=this.precisionRound(+sum_coeff + +coeff,2);
            }

       
           }    this.noteType[index1]=sumtype; 
       }
                //console.log(total)

                // let coeff_final=this.precisionRound(sum_coeff+20,2);
                this.totalCoeff=this.precisionRound(sum_coeff+20,2);
                this.totalNote.totalNotes=this.precisionRound(total,2);
                //console.log("suuuum   " +coeff_final )
                this.totalNote.noteFinal= this.precisionRound( total*20/this.totalCoeff,2);
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
  redirect_To_ShowEvaluation(stagiaire){
        console.log('stagiaire')
                      console.log(this.stagiaire)
                     this.$router.push({ name: 'ShowEvaluation', params: { stagiaire:stagiaire}});
            },
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
        getObjectif(){
 axios.get('/getObjectif/1er annnée')
                .then((response) => {
                    this.loading = false;
                    this.objectifs = response.data.objectifs;
                   // for(let i=0;this.objectifs.length;i++)
                   this.notes=response.data.notes;
                    console.log('response objectifs .............')
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
                   // for(let i=0;this.objectifs.length;i++)
                   this.notes=response.data.notes;
                    console.log('response objectifs')
                    console.log(this.notes)
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
    addEvaluation(){ 
        if(this.totalNote.count >= 3 || this.totalNote.noteFinal < 10){
this.totalNote.etat ='non valide';
console.log('non valideeeeeeeeeee **************')
        }
        else{
this.totalNote.etat ='valide';
console.log('************** valideeeeeeeeeee')

        }
              console.log("test")
           console.log(this.objectif);
              // this.redirect_To_ShowEvaluation(stagiaire);
              axios.post('/addEvaluation',{evaluation:this.evaluation,objectifs:this.objectifs,type_objectifs:this.type_objectifs,notes:this.notes,totalNote:this.totalNote,noteType:this.noteType}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowEvaluation', params: { stagiaire:this.stagiaire,success: "add"  }});

                  });
            
        },
           precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
},
    fetchData(){
                       if(this.$route.params.stagiaire.id_stagiaire == undefined){
              this.$router.push({ name: 'ShowStagiairesEva'});
         }
         console.log('====== ok =====')
        console.log(this.$route.params.stagiaire)
        //this.stagiaire.id_stagiaire=this.$route.params.id_stagiaire;
                this.evaluation.fk_stagiaire=this.$route.params.stagiaire.id_stagiaire;
                 this.evaluation.fk_evaluateur=this.$route.params.stagiaire.fk_evaluateur;
        this.getTypeObjectifs();
        this.getObjectif()
        this.getStagiairesParEvaluation(this.evaluation.fk_stagiaire);
        this.countAbsence(this.evaluation.fk_stagiaire);
       // this.getObjectifsNotes( this.evaluation.fk_stagiaire);
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
