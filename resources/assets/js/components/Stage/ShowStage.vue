<template>
  <div>


    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    

<div v-if="!loading">
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowStages'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
     <div class=" container colBackround">


<div class="row">
    <div class="col">
        <br>
    <h5><i class="fas fa-address-book"></i> Stage : {{stage.intitule_stage}}  </h5>
    </div>
</div>
<hr>
    
        <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                
                <p class="card-text">
                   
                   <span>Intitule : </span>{{stage.intitule_stage}}
                    <hr>
                    <span>Objectif :  </span>{{stage.objectif_stage}}
                    <hr> 
                    <span>DateDebut :  </span>{{stage.dateDebut_stage}}
                    <hr> 
                    <span>DateFin :  </span>{{stage.dateFin_stage}}
                    <hr>              
                     
                    <span>nom hospitalier :  </span>{{stage.nom_hospitalier}}
                    <hr>            
                     <span>nom evaluateur :  </span>{{stage.nom_evaluateur}}
                    <hr>                               
                                     
                </p>
                
            </div>
            </div>
        </div>
        <div class="col-sm-6">
           <ul class="list-group">
            <li class="list-group-item active">Liste des Groupes</li>
            <li class="list-group-item" v-for="(stage_groupe,index) in stage_groupes" :key="index">[ {{stage_groupe.annee_universitaire_groupe}} ] {{stage_groupe.nom_groupe}}</li>
           
            </ul>
        </div>
   
        </div>
    


  </div>
   <br>
 
   </div>
  </div>
</template>
<script>



      export default{ 
    
          data: () => ({
               loading: false,
              groupe:{
            id_groupe:0,
            nom_groupe: "",
            annee_universitaire_groupe:""     
            },
            stage:{
              id_stage:0,
              intitule_stage:"",
              objectif_stage:"",
              duree_stage:"",
              dateDebut_stage:"",
              dateFin_stage:"",
              fk_hospitalier:0,
              fk_evaluateur:0,      
              },

calendriers: [],
groupe_stagiaire: [],
stage_groupes:[],

          }),
  
          methods:{
 fetchData () {
                    


              //  console.log(this.$route.params.id_groupe)
                this.getStage(this.$route.params.id_stage);

              // this.getGroupe(this.$route.params.id_groupe);
              // this.getCalendriers(this.$route.params.id_groupe);
             
 },
      
       
           getGroupe:function(id_groupe){
                            axios.get('/getGroupe/'+id_groupe).then(
                            response => {
                                

                                this.groupe= response.data.groupe;
                                this.groupe_stagiaire = response.data.groupe_stagiaire;
                                console.log('liste stagiaire')
                                console.log(this.groupe_stagiaire)
                                console.log('grouppppe')
                                console.log(this.groupe);
                            });     
                    },
           getStage:function(id_stage){
                            axios.get('/getStage/'+id_stage).then(
                            response => {
                                

                                this.stage= response.data.stage[0];
                                this.stage_groupes = response.data.stage_groupes;
                                console.log('liste groupes')
                                console.log(this.stage_groupes)
                                console.log('stage')
                                console.log(this.stage);
                            });     
                    },                
            getCalendriers:function(id_groupe){
                    console.log('-------------------idGroupe-----------');
                                console.log(id_groupe);
                            axios.get('/getCalendriers/'+id_groupe).then(
                            response => {
                                
                                this.calendriers= response.data.calendriers;
                                
                                console.log('-------------------calendriers-----------');
                                console.log(response);
                            });     
                    },
        
        
          },

          created(){
              this.fetchData()
          },

      }
</script>
<style scoped>
.card-header{
    background-color: #cac8c8;
}
span{
    color:#007ee4;
}
.fontsize{

    font-size: 1.30rem;
}
a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}


.colBackround2{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.colBackround3{
    background-color: #d8edff;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.badgeSize{
    font-size: 14px;
}
.trJour{

    background-color: #b6dfff;

}
.sizeJour{
    width: 42px;
    min-width: 70px;
 }
 .list-group-item.active{

     background-color:#d4eddb;
     border-color:#d4eddb;
     color:#272727;
 }
</style>
