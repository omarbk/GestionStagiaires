<template>
    <div>
      <notifications group="foo" 
      position="bottom right"/>
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowStages'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
        <div class="text-center pull-right" >
    <h2>Ajouter Stage</h2>
    <hr>   
    </div>


        
        <form @submit.prevent="validateForm('formStage')"  data-vv-scope="formStage">
         <div class="row" > 
         
            <div class="col-md-6">
               

                <div class="form-group row">
                     <label for="nom_compte" class="require col-sm-4">intitule</label>
                  
                    <div class="col-sm-8">
                    <input type="text" v-validate="'required'" name="intitule" class="form-control" id="nom_compte"  v-model="stage.intitule_stage">
                    <div v-show="errors.has('formStage.intitule')" class="text-danger">Champ obligatoire !</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > objectif </label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="stage.objectif_stage">
                    </div>
                </div>
                 <div class="form-group row">
                     <label for="responsable" class="require col-sm-4">date Debut</label>

                    <div class="col-sm-8">
                    <input type="date" class="form-control" v-validate="'required'"  id="responsable" name="dateDebutStage" v-model="stage.dateDebut_stage">
                    <div v-show="errors.has('formStage.dateDebutStage')" class="text-danger">Champ obligatoire !</div>
                    </div>
                </div>
                <div class="form-group row">
                     <label for="responsable" class="require col-sm-4">date Fin</label>
                  
                    <div class="col-sm-8">
                    <input type="date" v-validate="'required'" name="dateFinStage" class="form-control" id="responsable"  v-model="stage.dateFin_stage">
                    <div v-show="errors.has('formStage.dateFinStage')" class="text-danger">Champ obligatoire !</div>
                    </div>
                </div>
                       <div class="form-group row">
                            <label for="responsable" class="require col-sm-4">semestre</label>
                   
                    <div class="col-sm-8">
                    <input type="text" v-validate="'required'" name="semestre" class="form-control" id="responsable"  v-model="stage.semestre_stage">
                    <div v-show="errors.has('formStage.semestre')" class="text-danger">Champ obligatoire !</div>
                    </div>
                     </div>
                   <div class="form-group row">
                        <label for="stagiaire" class="require col-sm-4">niveau d'étude:</label>
            
                    <div class="col-sm-8">
   
                        <select v-validate="'required'"  name="anneeEtude" class="form-control custom-select " id="fk_compte" v-model="stage.annee_universitaire_stage" >
                                    <option selected disabled>Choisir niveau</option>
                                    <option v-for="(anneeEtude,index) of listAnneeEtude" :key="index" :value="anneeEtude"> {{anneeEtude}} </option>
                        </select>  
                        <div v-show="errors.has('formStage.anneeEtude')" class="text-danger">Champ obligatoire !</div>
                    
                            </div>
                        </div> 

 
            </div> 
   <div class="col-md-6">
        
                    <div class="form-group row">
                        <label for="stagiaire" class=" typo__label  require col-sm-4">Groupes:</label>
                   
                    <div class="col-sm-7">
                    <multiselect  name="MultiGroupe" v-validate="'required'"  :custom-label="nameWithLangGroupe" tag-position="bottom" v-model="pushGroupes"
                     tag-placeholder="Add this as new tag" placeholder="cherche un groupe"  track-by="id_groupe" 
                    :optionHeight="30" @remove="removeGroupes" :options="groupes" :multiple="true"  ></multiselect>
                    <div v-show="errors.has('formStage.MultiGroupe')" class="text-danger">Champ obligatoire !</div>
                    </div>

                    </div>
        <div class="form-group row">
             <label for="stagiaire" class=" typo__label  require col-sm-4">Hospitalier:</label>
          
          <div class="col-sm-7">
          <multiselect  name="MultiHospitalier" v-validate="'required'"  v-model="pushHospitalier" :options="hospitaliers"  placeholder="choisir" label="nom_hospitalier" track-by="id_hospitalier"></multiselect>
          <div v-show="errors.has('formStage.MultiHospitalier')" class="text-danger">Champ obligatoire !</div>
          </div>
        </div>
         <div class="form-group row">
               <label for="stagiaire" class=" typo__label  require col-sm-4">Evaluateur:</label>
          <div class="col-sm-7">
          <multiselect name="MultiEvaluateur" v-validate="'required'"  placeholder="choisir"  v-model="pushEvaluateur" :custom-label="nameWithLangEvaluateur"  :options="evaluateurs"    track-by="id_evaluateur"></multiselect>
          <div v-show="errors.has('formStage.MultiEvaluateur')" class="text-danger">Champ obligatoire !</div>
          </div>
        </div>
   </div>              
    </div>
     
     


             
          <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
</form>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
            listAnneeEtude : ["1er annnée","2eme année","3eme année","4eme année","5eme année","6eme année","7eme année"],
            pushEvaluateur:[],
            evaluateurs:[],
            hospitaliers:[],
            suppGroupes:[],
            groupes:[],
            pushGroupes:[],
            pushHospitalier:[],
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
              statut_stage:"",  
              semestre_stage:"", 
              annee_universitaire_stage:"", 
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
                       validateForm(scope) {
      this.$validator.validateAll(scope).then((result) => {
        if (result) {
          // eslint-disable-next-line
          this.addStage();
        }
      });
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
                        this.stage.statut_stage = "En cours"   
                         

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
     
                    




                    },
                    mounted(){
                      this.getAllEvaluateurs();
                      this.getAllHospitaliers();
                      this.getAllStagiaires();
                      this.getAllGroupes();
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
</style>
