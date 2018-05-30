<template>
    <div>
      <notifications group="foo" 
      position="bottom right"/>

          <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
 

<div v-if="!loading">
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowStages'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
        <div class="text-center pull-right" >
    <h2>Modifier Stage</h2>
    <hr>   
    </div>


        <form @submit.prevent="updateStage">
         <div class="row" > 
         
            <div class="col-md-6">
               

                <div class="form-group row">
                    <label for="nom_compte" class="col-sm-4"> intitule</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="nom_compte"  v-model="stage.intitule_stage">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > objectif </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="stage.objectif_stage">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > date Debut </label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="responsable"  v-model="stage.dateDebut_stage">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > date Fin </label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="responsable"  v-model="stage.dateFin_stage">
                    </div>
                </div>
                   <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > semestre </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="stage.semestre_stage">
                    </div>
                     </div>
                               <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" >niveau d'étude:</label>
                    <div class="col-sm-8">
   
                        <select class="form-control custom-select " id="fk_compte" v-model="stage.annee_universitaire_stage" >
                                    <option selected disabled>Choisir niveau</option>
                                    <option v-for="(anneeEtude,index) of listAnneeEtude" :key="index" :value="anneeEtude"> {{anneeEtude}} </option>
                        </select>  

                    
                            </div>
                        </div> 



            </div> 
   <div class="col-md-6">
   
                    <div class="form-group row">
                    <label class="typo__label col-sm-4">Groupes</label>
                    <div class="col-sm-7">
                    <multiselect   :custom-label="nameWithLangGroupe" tag-position="bottom" v-model="stage_groupes"
                     tag-placeholder="Add this as new tag" placeholder="cherche un groupe"  track-by="id_groupe" 
                    :optionHeight="30" @remove="removeGroupes" :options="groupes" :multiple="true"  ></multiselect>
                    </div>

                    </div>
        <div class="form-group row">
          <label class="typo__label col-sm-4">Hospitalier</label>
          <div class="col-sm-7">
          <multiselect v-model="pushHospitalier" :options="hospitaliers"  placeholder="choisir" label="nom_hospitalier" track-by="id_hospitalier"></multiselect>
          </div>
        </div>
         <div class="form-group row">
          <label class="typo__label col-sm-4">Evaluateur</label>
          <div class="col-sm-7">
          <multiselect placeholder="choisir"  v-model="pushEvaluateur" :custom-label="nameWithLangEvaluateur"  :options="evaluateurs"    track-by="id"></multiselect>
          </div>
        </div>
   </div>              
    </div>
     
     


             
          <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
</form>
    </div>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
                          listAnneeEtude : ["1er annnée","2eme année","3eme année","4eme année","5eme année","6eme année","7eme année"],

              loading: false,
              stage_groupes:[],
            pushEvaluateur:{
                id_evaluateur:0,
                nom_evaluateur:"",
            },
            evaluateurs:[],
            hospitaliers:[],
            suppGroupes:[],
            groupes:[],
            pushGroupes:[],
            pushHospitalier:{
                id_hospitalier:0,
                nom_hospitalier:"",
            },
            hospitaliers:[],
              stage:{
              id_stage:0,
              intitule_stage:"",
              objectif_stage:"",
              duree_stage:"",
              dateDebut_stage:"",
              dateFin_stage:"",
              fk_hospitalier:0,
              fk_evaluateur:0, 
              semestre_stage:"",    
              annee_universitaire_stage:"" 
              },
            

            pushStagiaire:[],
            stagiaires:[],
              
             Mois:['jan','fév','mar','avr','mai','jun','juil','aoû','sep','oct','nov','déc'],
             groupe:{
            id_groupe:0,
            nom_groupe: "",
            annee_universitaire_groupe:""     
            },
           
        
           
             groupe_stagiaire:[],
             
      }),
 
        
                    methods:{
                         fetchData () {
                                this.loading=true;
                        this.stage.id_stage = this.$route.params.id_stage;
                        this.getStage(this.$route.params.id_stage);
                      this.getAllEvaluateurs();
                      this.getAllHospitaliers();
                      this.getAllStagiaires();
                      this.getAllGroupes();

                         },
                     
                 
                   
                   
            getAllStagiaires(){//type_status
                axios.get('/getAllStagiaires')
                .then((response) => {
                    this.loading = false;
                    this.stagiaires = response.data.stagiaires;
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
           removeStagiaire(removedOption,id){
                console.log('---remove')
                console.log(removedOption)
          },
            removeGroupes(removedOption,id){
              this.suppGroupes.push(removedOption);

              console.log('---remove')
              console.log(this.suppGroupes)
          },
           nameWithLangGroupe ({ nom_groupe, annee_universitaire_groupe }) {
      return `[${annee_universitaire_groupe}]-${nom_groupe}`
    },
            nameWithLangEvaluateur ({ nom_evaluateur, prenom_evaluateur }) {
      return `${nom_evaluateur}-${prenom_evaluateur}`
    },
    getAllGroupes(){
                axios.get('/getAllGroupes')
                .then((response) => {
                 // console.log('shit');
                    this.groupes = response.data.groupes;
                    console.log('groupes')
                    console.log(this.groupes)
                    this.loading=false;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
   getAllHospitaliers(){
                axios.get('/getAllHospitaliers')
                .then((response) => {
                    console.log(response)
                    this.hospitaliers = response.data.hospitaliers;
                    console.log
                    this.loading = false;

               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
   getAllEvaluateurs(){//type_status
                axios.get('/getAllEvaluateurs')
                .then((response) => {
                    console.log(response)
                     this.evaluateurs = response.data.evaluateurs;
                    this.loading = false;
                   
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
     addStage(){

                        this.stage.fk_hospitalier = this.pushHospitalier.id_hospitalier;
                        this.stage.fk_evaluateur = this.pushEvaluateur.id_evaluateur;

                         

                        console.log('add stage ')
                        console.log('----stage---');console.log(this.stage)
                        console.log('--- groupes---');console.log(this.pushGroupes)
                         axios.post('/addStage',{stage:this.stage,pushGroupes:this.pushGroupes})
                        .then(response => {         
                                
                            this.$router.push({ name: 'ShowStages', params: { success: "addsuccess"  }});
                        })
                        .catch(() => {
                                console.log('handle server error from here');
                        });
                  },
    updateStage: function(){
                 console.log('----- fk hospitalier ')
                 console.log(this.pushHospitalier.id_hospitalier)
                 this.stage.fk_hospitalier = this.pushHospitalier.id_hospitalier;
                 this.stage.fk_evaluateur = this.pushEvaluateur.id_evaluateur;     
                  axios.post('/updateStage',{stage: this.stage, stage_groupes: this.stage_groupes,suppGroupes: this.suppGroupes})
                  .then( response => {             
                    this.$router.push({ name: 'ShowStages', params: { success: "editsuccess"  }});
                  
                  });

                  },

     getStage:function(id_stage){
                            axios.get('/getStage/'+id_stage).then(
                            response => {
                                

                                this.stage= response.data.stage[0];
                                this.pushHospitalier.id_hospitalier = this.stage.fk_hospitalier;
                                this.pushHospitalier.nom_hospitalier = this.stage.nom_hospitalier;
                                this.pushEvaluateur.id_evaluateur = this.stage.fk_evaluateur;
                                this.pushEvaluateur.nom_evaluateur = this.stage.nom_evaluateur;
                                this.pushEvaluateur.prenom_evaluateur = this.stage.prenom_evaluateur;

                                this.stage_groupes = response.data.stage_groupes;
                                console.log('liste groupes')
                                console.log(this.stage_groupes)
                                console.log('stage')
                                console.log(this.stage);
                            });     
                    }, 
     
                    




                    },
 created () {
    this.fetchData()
  },
                    mounted(){

                    }
                 

     
       
        
      

    }
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
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

</style>
