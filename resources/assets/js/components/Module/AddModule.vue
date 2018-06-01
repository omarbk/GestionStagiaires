<template>
  <div>
          <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les objectifs-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowModules'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Ajouter des Modules</h2>
    <hr>   
    </div>   
   

<div >
        <form @submit.prevent="addModule">
         
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
                                        <th>Type module</th>
                                        <th>nom module</th>
                                        <th>titre module</th>
                                    </tr>
                                    </thead>

                                      <tbody>
                                        <tr v-for="(moduleM,index) in modules" :key="index">
                                        <th><input type="text" class="form-control" id="civilite"  v-model="moduleM.type_module" disabled></th>
                                        <th><input type="text" class="form-control" id="XX"  v-model="moduleM.titre_module"></th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="moduleM.nom_module"></th>
                                        <th><a @click="spliceModule(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                                        <th>
                                             <div> 
                                                <select class="custom-select " id="fk_type_objectif" v-model="moduleM.type_module" >
                                                 <option selected disabled>Choisir Type Module</option>
                                                <option v-for="type_module in type_modules" :key="type_module" :value="type_module">{{type_module}}</option>
                                                </select>                                                                     
                                            </div>
                                            </th>
                                       <th><a    @click="pushModule(moduleM)"  class="btn btn-success"  ><i class="fas fa-plus-circle"></i></a></th>
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
                                type_modules:["Modules Obligatoires","Modules Optionnels"],
                                type_module:"",
                nameFile : "Choose file",
                                    niveau:"",

                moduleM: { 
                    id_module : 0,
                    nom_module : "",
                    type_module : "",
                    titre_module:"",
                },  
        
                modules:[],
  
      }),
 
      methods: { 

    pushModule(moduleM){
            console.log(this.moduleM);
                 // this.getTypeObjectif();
            this.modules.push({ 
               type_module:moduleM.type_module,
               nom_module:moduleM.nom_module,
               titre_module:moduleM.titre_module,
               niveau_etude:this.niveau,
            });
                            console.log(this.modules);

            this.moduleM = {
                    id_module : 0,
                    nom_module : "",
                    type_module : "",
                    titre_module:"",
                
              };
            
    },

    spliceModule(index){
            this.modules.splice(index, 1);
        },

         
          addModule(){ 
              console.log("test")
       this.moduleM.niveau_etude=this.niveau;
       console.log(this.modules)
              axios.post('/addModule',{modules:this.modules}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowModules', params: { success: "add"  }});

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