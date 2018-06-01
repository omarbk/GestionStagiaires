<template>
  <div>
          <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les objectifs-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowActivites'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Ajouter des Activites</h2>
    <hr>   
    </div>   
   

<div >
        <form @submit.prevent="addActivite">
         
    <div class="form-group row">
                    <label for="stagiaire" class="col-sm-3" >niveau d'étude:</label>
                    <div class="col-sm-6">
   
                        <select class="form-control custom-select " id="fk_compte" v-model="niveau" >
                                    <option selected disabled>Choisir Niveau Etude</option>
                                    <option v-for="(anneeEtude,index) of listAnneeEtude" :key="index" :value="anneeEtude"> {{anneeEtude}} </option>
                        </select>  

                    
                            </div>
                        </div>
   
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Type Activité</th>
                                        <th>Activité</th>
                                    </tr>
                                    </thead>

                                      <tbody>
                                        <tr v-for="(activite,index) in activites" :key="index">
                                        <th><input type="text" class="form-control" id="civilite"  v-model="activite.type_activite"></th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="activite.nom_activite"></th>
                                        <th><a @click="spliceActivite(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                                        <th><input type="text" class="form-control" id="civilite"  v-model="activite.type_activite"></th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="activite.nom_activite"></th>
                                         <th><a    @click="pushActivite(activite)"  class="btn btn-success"  ><i class="fas fa-plus-circle"></i></a></th>
                                    </tbody>
                                </table>
                            </div>
             </div>

     </div>
                       <button  class="btn mb-3  btn-success">Enregister</button>

          </form>
</div>
  </div>
</template>
<script>
    export default{
        

          data: () => ({
              listAnneeEtude : ["1er annnée","2eme année",
                                "3eme année","4eme année","5eme année",
                                "6eme année","7eme année"],
                nameFile : "Choose file",
                                    niveau:"",

                activite: { 
                    id_activite : 0,
                    nom_activite : "",
                    type_activite : "",
                },  
        
                activites:[],
  
      }),
 
      methods: { 

    pushActivite(activite){
            console.log(this.activite);
                 // this.getTypeObjectif();
            this.activites.push({ 
               type_activite:activite.type_activite,
               nom_activite:activite.nom_activite,
               niveau_etude:this.niveau,
            });
                            console.log(this.activites);

            this.activite = {
                    id_activite : 0,
                    nom_activite : "",
                    type_activite : "",
                
              };
            
    },

    spliceActivite(index){
            this.activites.splice(index, 1);
        },

         
          addActivite(){ 
              console.log("test")
       this.activite.niveau_etude=this.niveau;
       console.log(this.activites)
              axios.post('/addActivite',{activites:this.activites}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowActivites', params: { success: "add"  }});

                  });
            
        },



 
               
      },

 
    }
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
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
.mr-4{
    margin-right: 0rem!important;
    width:100px;
}
.colBackround{
     background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.infoClient{

    background-color:  #42a5f529;

}
.AdressClient{
    width: 121%;
}

.noteCondition{
    width: 77%;
}
.calculePadding{
    padding-left: 50%;
}
.body{
        margin-left: 20%;
}
</style>