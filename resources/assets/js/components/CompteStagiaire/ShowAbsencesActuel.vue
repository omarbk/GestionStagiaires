<template>
    <div class="post" >
        <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/>
      <!-- au cas ajout bien passé afficher ce message -->   
            
           
    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">


        <div class="text-center pull-right" >
        <div class=" btnMarge">
        <div class="col">
                    <a href="#"    @click="PdfCalendriersParStagiaire"  class="btn btn-secondary mb-3  float-right" ><i class="far fa-file-pdf"></i></a>
                    <a class="float-right btn btn-primary" @click="redirect_To_ShowStagiairesStagiaire(stage)"> <i class="fas fa-long-arrow-alt-left"></i> </a>
<div v-if="empty == false">
        <a href="#"  @click="redirect_To_ShowEvaluationActuel(stage)"   class="float-right btn btn-success" ><i class="far fa-sticky-note"></i> Evaluation</a>
</div>

        </div>
  
    </div>
    <h2>Liste des Absences</h2>
    <hr>   
    </div> 
<div v-if="empty == true" class="text-center">
  <h1 style="color:red"> <strong> aucun stage en cours</strong></h1>
</div>
<div v-if="empty == false">
       
    
    
  
    <!-- formulaire pour Ajouter un article -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->
    
  
   <div class=" container colBackround size">
<br>

<div class="row align-items-center">
    <div class="col-1">
             <img v-if="stage.photo_stagiaire != ''" class="card-img-top tailleImage" :src="'storage/images/'+stage.photo_stagiaire" alt="Card image cap" width="100px" height="150px">
            <img v-if="stage.photo_stagiaire === ''" class="card-img-top tailleImage" :src="'storage/images/user0.jpg'" alt="Card image cap" width="100px" height="150px">
    
    </div>
    <div class="col">
            <br>
                 <h5>Information du Stagiaire</h5>
        
        </div>
</div>

<hr>



 <div class="row" style="border-style: solid" v-if="objectifs.length > 0"> 
         
           

     <div class="col-md-6 col-sm-12" >
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 ">Note Final : </label>
            <div class="col-sm-8">
        {{objectif.noteFinal}} /20
            </div>
         </div>
     </div>
          <div class="col-md-6 col-sm-12" >
 
            <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 ">Etat : </label>
            <div class="col-sm-8">

                     <span class="etat" v-if="objectif.etat == 'valide'" style="color:rgb(146, 239, 7);" > {{objectif.etat}} </span> 
                   
                    <span  class="etat" v-if="objectif.etat == 'non valide'" style="color:red"  > {{objectif.etat}} </span>
                      
            </div>
         </div>  
     </div> 
 </div>

    
<div class="row ">
 <div class="col-md-4 col-sm-8">
                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5" >Nom : </label> 
                        <div class="col-sm-5">
                   {{stage.nom_stagiaire}} 
                    </div>
                    </div>
                               </div> 
 <div class="col-md-4 col-sm-8">
                <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5" >Prénom : </label> 
                        <div class="col-sm-5">
                    {{stage.prenom_stagiaire}} 
                                        </div>
                                         </div>
                               </div> 
                     <div class="col-md-4 col-sm-8">
                                         <div class="form-group row"> 
                        <label for="reference_paiement"  class="col-sm-5" >Niveau d'étude : </label> 
                        <div class="col-sm-5">
                  {{stage.niveau_etude_stagiaire}} 
                     </div>
                        </div>
                               </div> 
                </div>

    <hr>
        <div class="text-center pull-right">
    <h2>Absences</h2>
    <hr>   
    </div>

    <div class="row center">
             <div class="card">
                      

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>date Debut</th>
                                        <th>date Fin</th> 
                                        <th>cause absence</th>  
                                        <th>justificatif</th>   
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="absence of absences.data" :key="absence.id_absence" >
                                        <td>{{absence.dateDebut_absence}}</td>
                                        <td>{{absence.dateFin_absence}}</td> 
                                        <td>{{absence.cause_absence}}</td>
                                        <td v-if="absence.justificatif_absence == 1">
                                             <span class="badge badge-pill" style="background-color:#3ede01;color:white;font-size:14px"> <b>Justifié</b></span> 
                                        </td>
                                        <td v-else>
                                            <span class="badge badge-pill" style="background-color:red;color:white;font-size:14px"> <b> Non Justifié</b></span> 
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
              
            </div>
            </div>  
    </div>
   <!-- 
    <vue-pagination  :pagination="absences"
                     @paginate="getAbsenceParStagiaire()"
                     :offset="4">
    </vue-pagination>
    -->
</div>
    </div>
    <!-- fin affiche -->
    </div> 
</template>

<script>
//import  Pagination from '../Pagination.vue';

    export default{
       /*  components:{
            'vue-pagination':Pagination,
         },*/

          data: () => ({

//absences 
            objectifs:[],
            objectif:{},
            absences:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
                absence:{
                id_absence:0,
                dateDebut_absence:"",
                dateFin_absence:"",
                duree_absence:"",
                cause_absence:"",
                justificatif_absence:false,
                fk_stagiaire:0,
                fk_evaluateur:0                     
                },




             groupe:{
            id_groupe:0,
            nom_groupe: "",
            annee_universitaire_groupe:""     
            },
          
                 
                     loading: false,
      post: null,
      error: null,
         
              //name file 
              nameFile : "Choose file",
         
                 offset: 4,

            
                         eval:"",
statut_stage:"",
empty :false,
             
      }),
 
 methods:{
     
      getObjectifsNotesStage(stage){
 axios.get('/getObjectifsNotesStage/',{ params: {id_stagiaire:stage.id_stagiaire,id_stage:this.id_stage } })
      
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
        getGroupes(){
                axios.get('/getGroupes?page='+this.groupes.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.groupes = response.data.groupes;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },

    getStagesEffectues(){
                      
let statut_stage = 'En cours';
axios.get('/getStagesEffectues',{ params: {page: this.absences.current_page,currentYear: this.currentYear,statut_stage:statut_stage} })
                .then((response) => {
                 // console.log('shit');
                
                     this.stages = response.data.stages;
                   // this.stage = response.data.stages.data[0];
                                        console.log("all stages ")
                    console.log(this.stages)
                    this.loading =  false
                     
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                  getAbsenceParStagiaireS(){
                      
this.statut_stage="En cours";
                axios.get('/getAbsenceParStagiaireS?page='+this.absences.current_page+'',{ params: {fk_stagiaire:this.id_stagiaire,fk_evaluateur:this.$route.params.stage.fk_evaluateur,fk_stage:this.$route.params.stage.id_stage,statut_stage:this.statut_stage} })
                .then((response) => {
                  console.log('shit');
                  console.log(response.data.absences.data.length);
                               this.absences = response.data.absences;
                               this.stage=response.data.stage;
                               console.log('absence =============')
                               console.log(this.stage)
                                 if(this.stage.data.statut_stage === "En cours"){
                         this.empty =false;
console.log("en cours")
                } 
                                else{
                                 this.empty=true; 
                                  console.log("noooo")
                }
                  

                    console.log("all absence ")
                    console.log(this.absences)
                    console.log(this.empty);
                    this.loading =  false
                     
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
          // calendrier ---------------------
PdfCalendriersParStagiaire(){
          window.open('/PdfCalendriersParStagiaire/'+this.id_stagiaire
+'/'+this.id_stage
+'','_blank');
},
  

             redirect_To_ShowEvaluationActuel(stage){
        console.log('stgiaires')
        console.log(stage)
                     this.$router.push({ name: 'ShowEvaluationEffectues', params: { stage:stage,id_stage:this.id_stage}});
        //this.$router.push({ name: 'Editstage', params: {stage:this.stage}});
//console.log(stage)
            },

              fetchData () {
      
      //this.error = this.post = null
      this.loading = true
       console.log('====== ok =====')
        this.stage = this.$route.params.stage;
        console.log(this.$route.params.fk_evaluateur)
        this.id_stage=this.$route.params.stage.id_stage;
             //   this.fk_evaluateur=this.$route.params.stage.fk_evaluateur;

        console.log('====== nnnnnnnnnnnnnnnn =====')
        console.log(this.$route.params.stage)
        this.id_stagiaire=this.$route.params.stage.id_stagiaire;
      this.getAbsenceParStagiaireS();    
                     this.getObjectifsNotesStage(this.$route.params.stage);
           // this.getStagesEffectues(); 

      // replace `getPost` with your data fetching util / API wrapper
   
  /* axios.get('/getGroupes?page='+this.groupes.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.groupes = response.data.groupes;
                    this.loading =  false
                })
                .catch(() => {
                    console.log('handle server error from here');
                });*/
    },

                redirect_To_ShowStagiairesStagiaire(stage){
        console.log('stage')
                      console.log(this.stage)

                     this.$router.push({ name: 'ShowStagiairesStagiaire', params: { stage:stage}});
        //this.$router.push({ name: 'Editstage', params: {stage:this.stage}});
//console.log(stage)
                          this.loading = false;

          },

         redirect_To_ShowStagesEffectues(stage){
        console.log('stage')
                      console.log(this.stage)
                                                    this.eval ='actuel';

                     this.$router.push({ name: 'ShowStagesEffectues', params: { stage:stage,id_stage:this.id_stage,eval:this.eval}});
       
                          this.loading = false;

          },
  },
     mounted(){
         console.log('---- routes ------')
         if(this.$route.params.stage.fk_evaluateur == undefined){
              this.$router.push({ name: 'ShowStagiairesStagiaire'});
         }
                                   console.log(this.$route.params.fk_evaluateur)
                        console.log(this.$route.params.stage)
                       
          if( this.$route.params.success == "addsuccess"){
             
                       // this.Testopen.testnotifAdd = true;                  
                                   this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Groupe bien ajouter!',
                                      duration: 1500,
                                    });
          }
                    if( this.$route.params.success == "editsuccess"){
             
                             this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Groupe bien modifier!',
                                      duration: 1500,
                                    });
          }
        },
      updated(){
          if( this.$route.params.success == "addsuccess"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testnotifAdd = false }, 1500);
               }
          if( this.$route.params.success == "editsuccess"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testnotifEdit = false }, 1500);}               
            
      },
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
  watch:{
      '$route': 'fetchData',
  }
 
   
     

      
       
        
      

    }
    
</script>

<style scoped>

 .btnMarge{
     padding-bottom: 10px;
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

.center{
margin-left:240px; 
}
.etat{
        font-size: medium;
    font-weight: bold;
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



.shadawTr:hover {
  box-shadow: 1px 1px 1px 1px #888888;
    }
thead{
    background-color: #efefef;
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
.vue-notification {
  padding: 10px;
  margin: 0 5px 5px;

  font-size: 12px;

  color: #ffffff;
  background: #44A4FC;
  border-left: 5px solid #187FE7;

  &.warn {
    background: #ffb648;
    border-left-color: #f48a06;
  }

  &.error {
    background: #E54D42;
    border-left-color: #B82E24;
  }

  &.success {
    background: #68CD86;
    border-left-color: #42A85F;
  }
}


</style>



