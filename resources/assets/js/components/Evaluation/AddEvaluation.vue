
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

<div class=" container colBackround">

    <form   @submit.prevent="addEvaluation">
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Evaluation</h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">stagiaire: </label>
                    <div class="col-sm-10">
         <select class="form-control custom-select " id="fk_stagiaire" v-model="evaluation.fk_stagiaire" @change="getObjectifsAnnee()">
                    <option selected disabled>Choisir stagiaire</option>
                    <option v-for="stagiaire of stagiaires" :key="stagiaire.id_stagiaire" :value="stagiaire.id_stagiaire"> {{stagiaire.nom_stagiaire}} </option>
                </select>  

                
                </div>
            </div> 
   
          
    </div>
</div>
<hr>
<div class="row"> 
    <div class="col">
       <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                    <th>objectifs</th>
                                    <th>type objectif</th>
                                    <th>coefficient</th>
                                    <th>note</th>
                                    </tr> 
                                     <tr v-for="(objectif,index) in objectifs" :key="index" >
                               <input class="form-control"  type="text" v-model="objectif.fk_type_objectif" disabled hidden>
                                 <th> <input class="form-control"  type="text" v-model="objectif.objectif" disabled ></th>
                                <th><input class="form-control ThWidth"  type="text" v-model="objectif.type_objectif" disabled>
                                </th>
                                <th> <input class="form-control ThWidth"  type="text" v-model="objectif.coefficient" disabled>
                                 </th>
                                 <th> <input class="form-control"  type="number" v-model="objectif.note"  ></th>
                            </tr> 
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                                                
                            </div>
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
                    note:"",
                  
                
              }, 
              fk_stagiaire:"",
               objectifs:[],
               evaluation:{
                   fk_stagiaire:"",
               }
             
      }),
        created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
      

methods: { 
getAllStagiairesEval(){//type_status
                axios.get('/getAllStagiairesEval')
                .then((response) => {
                    this.loading = false;
                    this.stagiaires = response.data.stagiaires;
                 /*   this.evaluations = response.data.evaluations;
                   this.stagiaires.forEach(function(stagiaire) {
                       console.log("stagiaire")
                       this.evaluations.forEach(function(evaluation) {
                            console.log("eval")
               if(stagiaire.id_stagiaire != evaluation.fk_stagiaire){
                    console.log("yeeees")
               }
               
               });
               });*/
               }) .catch(() => {
                    console.log('handle server error from here');
                });
    },
    getObjectifsAnnee(){
 axios.get('/getObjectifsAnnee')
                .then((response) => {
                    this.loading = false;
                    this.objectifs = response.data.objectifs;
                    console.log(this.fk_stagiaire)
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
    addEvaluation(){ 
              console.log("test")
           console.log(this.objectif);
               
              axios.post('/addEvaluation',{evaluation:this.evaluation,objectifs:this.objectifs}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowEvaluations', params: { success: "add"  }});

                  });
            
        },
    fetchData(){
        this.getAllStagiairesEval();
    }

}

}
</script>