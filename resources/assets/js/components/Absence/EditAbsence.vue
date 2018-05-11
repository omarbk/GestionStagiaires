<template>
    <div>
      <notifications group="foo" 
      position="bottom right"/>
    <div class="row">
        <div class="col">
        <button class="btn btn-primary mb-3  float-right " @click="redirect_To_ShowAbsences"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </button>
        </div>
    </div>   

         <div class=" container colBackround">
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





     <div class="row" > 
         
            <div class="col-md-6">
               


                 <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Prenom :  </label>
                    <div class="col-sm-8">
                    <label for="responsable" class="col-sm-4" >{{stagiaire.prenom_stagiaire}} </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Nom : </label>
                    <div class="col-sm-8">
                    <label for="responsable" class="col-sm-4" >{{stagiaire.nom_stagiaire}} </label>
                    </div>
                </div>
            
            

 
            </div> 
   <div class="col-md-6">
                   <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Niveau d étude  : </label>
                    <div class="col-sm-8">
                    <label for="responsable" class="col-sm-4" >{{stagiaire.niveau_etude_stagiaire}} </label>
                    </div>
                </div>
            
   </div>              
    </div>

    <hr>
        <div class="text-center pull-right">
    <h2>Ajouter Absence</h2>
    <hr>   
    </div>


        <form @submit.prevent="updateAbsence">
         <div class="row" > 
         
            <div class="col-md-6">
               


                 <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > date Debut </label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="responsable"  v-model="absence.dateDebut_absence">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > date Fin </label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="responsable"  v-model="absence.dateFin_absence">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nom_compte" class="col-sm-4"> cause</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="nom_compte"  v-model="absence.cause_absence">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nom_compte" class="col-sm-4"></label>
                    <div class="col-sm-8">
                    <input type="checkbox" v-model="absence.justificatif_absence"  class="" id="exampleCheck1">  Justificatif
                    </div>
                </div>
            

 
            </div> 
   <div class="col-md-6">
   
            
   </div>              
    </div>
     
     


             
          <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
</form>
<br>
         </div>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
                //absence 
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
                stagiaire:{},
      
      }),
 
        
                                        methods:{
               redirect_To_ShowAbsences(){
                     this.$router.push({ name: 'ShowAbsences', params: { stagiaire:this.$route.params.stagiaire,fk_evaluateur:this.$route.params.fk_evaluateur}});
            },



                      updateAbsence(){
           
                  axios.post('/updateAbsence',{absence: this.absence})
                  .then( response => {             
                            this.$router.push({ name: 'ShowAbsences', params: { stagiaire:this.$route.params.stagiaire,fk_evaluateur:this.$route.params.fk_evaluateur}});
                  
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
                       getAbsence(id_absence){
                            axios.get('/getAbsence/'+id_absence).then(
                            response => {
                                

                                this.absence= response.data.absence[0];
                             console.log(response);
                                 //this.loading = false;
                            });     
                    },  
     
                    




                    },
                    mounted(){
                                 if(this.$route.params.fk_evaluateur == undefined){
              this.$router.push({ name: 'ShowStagiairesEva'});
         }
                        this.getAbsence(this.$route.params.id_absence)
                        console.log('add absence')
                        console.log(this.$route.params.fk_evaluateur)
                        console.log(this.$route.params.stagiaire)
                        this.stagiaire = this.$route.params.stagiaire;
                
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
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.tailleImage{
    height:62px;
}
</style>
