<template>
  <div>
          <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les Modules-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowModules'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Modifier une Module</h2>
    <hr>   
    </div>   
  <h3> {{niveau}} </h3>

<div >
        <form @submit.prevent="updateModule">
        

   
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Type Module</th>
                                        <th>Module</th>
                                        <th>titre Module</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(moduleM,index) of modules" :key="moduleM.id_module" >
                                        <input class="form-control"  type="text" v-model="moduleM.type_module" disabled hidden>
                                        <th>
                                    <input  class="form-control" type="text"  v-model="moduleM.type_module" disabled >

                                        </th>    
                                        <th><input type="text" class="form-control" id="email" v-model="moduleM.titre_module" ></th>

                                       <th><input type="text" class="form-control" id="email" v-model="moduleM.nom_module" ></th>
                                        <th><a @click="spliceModule(index,moduleM)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>

                                        </tr>
                                       
                                       <th>
<div> 
                                                <select class="custom-select " id="fk_type_objectif" v-model="moduleM.type_module" >
                                                 <option selected disabled>Choisir Type Module</option>
                                                <option v-for="type_module in type_modules" :key="type_module" :value="type_module">{{type_module}}</option>
                                                </select>                                                                     
                                            </div>                                           </th>
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
export default {
  
  data : () => ({
       fileName : "Choose file",
            moduleM: { 
                    id_module : 0,
                    nom_module : "",
                    type_module : "",
                    titre_module : "",
                    niveau_etude : "",
                
              }, 
     niveau:"",
            modules :[],
            
            suppModules:[],
        loading: false,
        error:false,
                                type_modules:["Modules Obligatoires","Modules Optionnels"],
        type_module:{},
  }),

  methods:{
   async pushModule(moduleM){
            console.log(this.moduleM);
          var result2 = await this.modules.push({ 
               type_module:moduleM.type_module,
               titre_module:moduleM.titre_module,
               nom_module:moduleM.nom_module,
               niveau_etude: this.niveau,

            });
            this.moduleM = {
                 id_module : 0,
                    nom_module : "",
                    type_module : "",
                    niveau_etude:"",
                    titre_module:"",

                
              };
            
    },

    spliceModule(index,moduleM){
            this.modules.splice(index, 1);
            this.suppModules.push(moduleM);

        },

       // recupere les donnees dans le formulaire
    
   getModule(niveau_etude){

                  axios.get('/getModule/'+niveau_etude).then(
                  response => {
                       
                    this.modules= response.data.modules;
                    
                    this.loading = false
                    console.log(response.data.modules)
                  });         
    },

 
    updateModule(){
            axios.post('/updateModule',{modules:this.modules,suppModules:this.suppModules})
            .then(response => {  
 
                    if(response.data.etat){
                      this.$router.push({ name: 'ShowModules', params: { success: "edit"  }});

                    }
                })
                .catch(error => {
                })
    },

      fetchData () {
        this.loading = true
        this.moduleM.niveau_etude=this.$route.params.niveau_etude;
         this.niveau=this.$route.params.niveau_etude;
      console.log( this.moduleM.niveau_etude)

      this.getModule( this.moduleM.niveau_etude); 

      }

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

.body{
        margin-left: 20%;
}
/*loading*/
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