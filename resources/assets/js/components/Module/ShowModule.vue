<template>
  <div>
          <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les Modules-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowModules'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
     <a href="#"    @click="PDFModule()"  class="btn btn-secondary mb-3  float-right" ><i class="far fa-file-pdf"></i></a>

        </div>
  
    </div>
    <h2>Details des Modules</h2>
    <hr>   
    </div>   
  <h3> {{niveau}}  </h3>

<div >
        <form @submit.prevent="updateModule">
        

   
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                     <thead>
                                        <div v-for="(type_module,index) in type_modules" :key="index" >
                 <br>
                  <h4> <span style="color: #42a5f5;"> {{index+1}}. {{type_module.type_module}} </span></h4>

                                    <tr>
                                    <th>modules</th>
                                    <th>Titre modules</th>
                                    
                                    </tr> 
      <tr v-for="(moduleM,index) in modules" v-if="moduleM.type_module===type_module.type_module" :key="index" >
                               
                              
                                 <th> {{moduleM.nom_module}}</th>
                                 <th> {{moduleM.titre_module}}</th>
                              
                          </tr>
                    
           
                                        </div>
                                    </thead>
                                    <tbody>
                                       
                                      </tbody>
                                </table>
                            </div>
             </div>

     </div>

          </form>
</div>
  </div>
</template>

<script>
export default {
  
  data : () => ({
       fileName : "Choose file",
            module: { 
                    id_module : 0,
                    nom_module : "",
                    titre_module : "",
                 
                
              }, 
     niveau:"",
            modules :[],
            type_modules:[],
            type_module:{
              type_module:"",
            },
          niveauPdf:{},

        loading: false,
        error:false,
  }),

  methods:{
 PDFModule(){
             var today = new Date();
              var annee = today.getFullYear();
              console.log(annee)
          window.open('/PDFModule/'+this.$route.params.niveau_etude
+'/'+annee
+'','_blank');
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
 
  getTypeModules(niveau_etude){
           axios.get('/getTypeModules/'+niveau_etude)
            .then((response) => {
                console.log(response.data.listeTypeModules);
                    this.type_modules = response.data.listeTypeModules;
                  //this.loading= false;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
 },
  /*    getTypemodule(){
       // console.log('-------- type_modules ');
         //  console.log();
         let this1=this;
           this.type_modules.forEach(function(type_module) {
               console.log('**** type_module ***') 
               if(type_module.type_module == this1.module.type_module){
                   console.log('-------- type_modules ');

                   this1.type_module.type_module = type_module.type_module;
                                                     console.log(this1.module.type_module) 

                  
                   return
                 
               }

});
    },*/


      fetchData () {
        this.loading = true
        this.niveau_etude=this.$route.params.niveau_etude;

         this.niveau=this.$route.params.niveau_etude;
      console.log( this.niveau_etude)
        this.getTypeModules(this.niveau_etude);

      this.getModule(this.niveau_etude); 

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