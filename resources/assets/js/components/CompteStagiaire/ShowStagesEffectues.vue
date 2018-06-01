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
        <a class="float-right btn btn-primary" @click="redirect_To_ShowStagiairesStagiaire(stage)"> <i class="fas fa-long-arrow-alt-left"></i> </a>

        </div>
  
    </div>
    <h3>Liste des Stages Effectués</h3>
    <hr>   
    </div> 

    
    
  
    <!-- formulaire pour Ajouter un article -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->
    
  


    <div class="row" id="testdiv">
             <div class="card">
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
 
    <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchGroupes"  class="form-control" v-model="search" placeholder="recherche par nom ou année Universitaire " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>stage</th>
                                        <th>groupe</th>
                                        <th>date Debut</th>
                                        <th>date Fin</th>
                                        <th>durée stage</th>
                                        <th>options</th>
  
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(stage,index) of stages.data" :key="index" >
                                        <td>{{stage.intitule_stage}}</td>
                                        <td>{{stage.nom_groupe}}</td>
                                        <td>{{stage.dateDebut_stage}}</td>
                                        <td>{{stage.dateFin_stage}}</td>
                                        <td>{{stage.duree_stage}}</td>  
                                            <td  class="optionsWidth"> 
                                                 <a href="#"  @click="redirect_To_ShowAbsencesEffectues(stage)"   class="btn btn-primary"   ><i class="fab fa-product-hunt"></i></a>
                            
                  <a href="#"  @click="redirect_To_ShowEvaluationEffectues(stage)"   class="btn btn-success" ><i class="far fa-sticky-note"></i></a>
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
    
    <vue-pagination  :pagination="stages"
                     @paginate="getStagesEffectues()"
                     :offset="4">
    </vue-pagination>
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

//absences 

            stages:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               



             groupe:{
            id_groupe:0,
            nom_groupe: "",
            annee_universitaire_groupe:""     
            },
              test1 : {
                  searchQuery: 0,
                   calculee: 0,
                  },
                 
                     loading: false,
      post: null,
      error: null,
             modalShow: false,
              //search
              search : '',
              //name file 
              nameFile : "Choose file",
              // objet test sur affichage , ajout , recherche
              Testopen:{
                testnotifEdit : false,
                testnotifAdd : false,
                testAjout : false,
                testAffiche : false,
                testmodelArticle : false,
              },
              testEdit : false,
              // tester l ajout si bien fais 
              
      
    fileName : "Choose File",
 

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
    users:[],
            eval:"",
             
             
      }),
 
 methods:{
            redirect_To_ShowAbsencesEffectues(stage){
        console.log('stgiaires')
                      console.log(this.stages)
                     this.$router.push({ name: 'ShowAbsencesEffectues', params: { stage:stage,id_stage:stage.id_stage,fk_evaluateur:stage.fk_evaluateur}});
        //this.$router.push({ name: 'Editstage', params: {stage:this.stage}});
//console.log(stage)
            },
            redirect_To_ShowEvaluationEffectues(stage){
        console.log('stgiaires')
        console.log(stage)
        this.eval ='effectue';
                     this.$router.push({ name: 'ShowEvaluationEffectues', params: { stage:stage,id_stage:stage.id_stage,eval:this.eval}});
        //this.$router.push({ name: 'Editstage', params: {stage:this.stage}});
//console.log(stage)
            },

         redirect_To_ShowStagiairesStagiaire(stage){
        console.log('stage')
                      console.log(this.stage)
                     this.$router.push({ name: 'ShowStagiairesStagiaire', params: { stage:stage}});
        //this.$router.push({ name: 'Editstage', params: {stage:this.stage}});
//console.log(stage)
                          this.loading = false;

          },






           searchGroupes(event){
             console.log(this.search);
             this.groupes.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getStages();}
                else {
                     // console.log('test1');
                axios.get('/searchGroupes/'+this.search+'?page='+this.groupes.current_page+'')
                .then((response) => {
                  console.log('searchhhh ')
                  console.log(response.data.groupes)
                    this.groupes = response.data.groupes;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
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
                      
let statut_stage = 'Achevé';
axios.get('/getStagesEffectues',{ params: {page: this.stages.current_page,currentYear: this.currentYear,statut_stage:statut_stage} })
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

              fetchData () {
                   console.log('====== ok =====')
        console.log(this.$route.params.stage)
       // this.id_stage=this.$route.params.stage.id_stage;
     // this.stage.id_stagiaire=this.$route.params.stage.id_stagiaire;
      //this.error = this.post = null
      this.loading = true
      this.getStagesEffectues(); 
      //this.getStagiaire(this.stage.id_stage);
         
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
     getStagiaire(id_stagiaire){
 axios.get('/getStagiaire/'+id_stagiaire)
                .then((response) => {
                    this.loading = false;
                    this.stagiaires = response.data.stagiaires;
                    console.log('response objectifs')
                    console.log(response)

               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
               redirect_To_ShowGroupe(id_groupe){
                   //  this.$router.push('/ShowGroupe/'+id_groupe);
                   
                      this.$router.push({ name: 'ShowGroupe', params: {id_groupe: id_groupe}});
            },


  },
     mounted(){
         console.log('---- routes ------')
         if(this.$route.params.stage.id_stagiaire == undefined){
              this.$router.push({ name: 'ShowStagiairesStagiaire'});
         }
                                 //  console.log(this.$route.params.fk_evaluateur)
                        console.log(this.$route.params.stage)
   
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

.notifArticle{
    opacity:0.9;
    width: 241px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;
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
/*
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

*/
</style>



