<template>
    <div class="post" >
      <!-- au cas ajout bien passé afficher ce message -->   
             <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/>       
           
    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
      <div class="text-center">
        <div class=" btnMarge">
        <div class="col">
        <a class="float-left btn btn-primary" @click="redirect_To_ShowAbsencesActuel()"> Stage Actuel </a>
                <a class="float-left btn btn-primary" style="background-color:beige" @click="pdfStageAnnee"> <i class="far fa-file-pdf"></i> Stages de l'année courant</a>

        <a class="float-right btn btn-primary" @click="redirect_To_ShowStagesEffectues(stage)"> Stages Effectués </a>

        </div>
  
    </div>
    <h2>Liste des Stages</h2>
  

 
    </div> 
   <hr>
  
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
     <br>

   <div class="row">
  <div class="col-12"> <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Stage</th>
                                        <th>Groupe</th>
                                        <th>Date Debut</th>
                                        <th>Date Fin</th>
                                        <th>Durée</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(stage,index) of stages.data" :key="index" >
                                        <td>{{stage.intitule_stage}}</td>
                                        <td>{{stage.nom_groupe}}</td>
                                        <td>{{stage.dateDebut_stage}}</td>
                                        <td>{{stage.dateFin_stage}}</td>
                                        <td>{{stage.duree_stage}}</td>  
                                                                     
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div></div>
</div>
    
    <!-- fin formulaire -->
    <!-- afficher les stagiaires sous formes des cards  -->
   


 
    
    <vue-pagination  :pagination="stages"
                     @paginate="getStagesParStagiaire()"
                     :offset="4">
    </vue-pagination>
    </div>  
    </div>
    <!-- fin affiche -->
</template>

<script>
import  Pagination from '../Pagination.vue';

    export default{
         components:{
            'vue-pagination':Pagination,
         },

          data: () => ({
               listAnneeEtude : ["1er annnée","2eme année","3eme année","4eme année","5eme année","6eme année","7eme année"],
             
                 
                     loading: false,
      post: null,
      error: null,
             modalShow: false,
              //search
              searchNiveauE:'',
              searchStage : '',
              searchGroupe: '',
              //name file 
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testAjout : false,
                testEdit : false,
              },
              
              // tester l ajout si bien fais 
              
              // tester  si affiche stagiaires  ou afficher ajouter stagiaire 
              
              // initialisation d un stagiaire 
         stage: { 
                    id_stagiaire : 0,
                    nom_stagiaire : "",
                    prenom_stagiaire : "",
                    photo_stagiaire : "",
                    adresse_stagiaire : "",
                    email_stagiaire : "",
                    tel_stagiaire : "",
                    dateNaissance_stagiaire : "",
                    specialite_stagiaire: "",
                    annee_universitaire_stagiaire: "",	
                    fk_user : 0,
                    niveau_etude_stagiaire:"",
                    id_stage:0,
                
              }, 
             stages:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,


          
    fileName : "Choose File",
    user: {
      id:0,
      email:"",
      password:"",
      role:"Stagiaire",
    
      
    },
currentYear:"",
    users:[],
            
             
             
      }),
                  created () {
    this.fetchData()
  },
 
 methods:{
     pdfStageAnnee(){
         window.open('/getStageAnnee','_blank');
    
     },
     fetchData () {
          var today = new Date();
           // var dd = today.getDate();
           // var mm = today.getMonth() +1; 
            var yyyy = today.getFullYear();
           /*  if(dd<10) 
                {
                    dd='0'+dd;
                } 

                if(mm<10) 
                {
                    mm='0'+mm;
                } */
            this.currentYear  = yyyy;
      //this.error = this.post = null
       this.loading = true
       this.countUser();
       this.getStagesParStagiaire();


      },
      onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.fileName=files[0].name;

                if (!files.length)
                    return;
                this.createImage(files[0]);
    },

    createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.stage.photo_stagiaire = e.target.result;
                };
                reader.readAsDataURL(file);
    },
    countUser(){

                axios.get('/countUser')
                .then((response) => {
                    console.log(response.data.count)
                    this.user.id=response.data.count;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },

    getStagesParStagiaire(){

axios.get('/getStagesParStagiaire',{ params: {page: this.stages.current_page,currentYear: this.currentYear} })
              
                .then((response) => {
                    console.log("stag=====")
                    this.loading = false;
                    if(response.data.stages.data.length !=0){
                    this.stages = response.data.stages;
                    this.stage = response.data.stages.data[0];
                    console.log(response.data.stages.data[0])}
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },



    getStagiaire(stagiaire){
                  axios.get('/getStagiaire/'+stagiaire.id_stagiaire).then(
                  response => {
                       
                    this.stagiaire= response.data.stagiaire[0];
                                  console.log(this.stagiaire)

                    this.modalShow = !this.modalShow
                  });         
    },

            redirect_To_ShowStagesEffectues(stage){
        console.log('stgiaires')
        console.log(stage)
                     this.$router.push({ name: 'ShowStagesEffectues', params: { stage:stage}});
       
            },

             redirect_To_ShowAbsencesActuel(){
                   axios.get('/getStagesActuel/',{params:{currentYear: this.currentYear}}).then(
                  response => {
                       
                  this.stagesA = response.data.stages[0];
        console.log('stgiaires')
        console.log(this.stagesA)
                     this.$router.push({ name: 'ShowAbsencesActuel', params: { stage:this.stagesA}});
       
            })
},

              getStageAnnee(){

console.log("niveau d etude ")
console.log()
/*axios.get('/getStageAnnee',{ params: {page: this.stages.current_page,currentYear: this.currentYear} })
              
                .then((response) => {
                    console.log("stag=====")
                    this.loading = false;
                    if(response.data.stages.data.length !=0){
                    this.stages = response.data.stages;
                    this.stage = response.data.stages.data[0];
                    console.log(response.data.stages.data[0])}
               })
                .catch(() => {
                    console.log('handle server error from here');
                });*/

    },

 
    


  },
 
    }
    
</script>

<style scoped>
.shadawTr:hover {
  box-shadow: 1px 1px 1px 1px #888888;
    }
thead{
    background-color: #efefef;
}
.optionsWidth{
width : 171px;

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
span {
    color: #42a5f5;
}
thead{
    background-color: #e9ecef;
}
table{
    background-color: white;
}
.card-body{
    background-color: #f8f9fa
}

.notifstagiaire{
    opacity:0.9;
    width: 241px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;
}
.show{
     opacity:0.9;
    width: 270px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;}
label{
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
.searchHight{
    height: 30px;
}

</style>



