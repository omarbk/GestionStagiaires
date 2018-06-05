<template>
    <div class="post" >
                <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/>   
      
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
     <b-btn :to="'/AddModule'"  class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>

        </div>
  
    </div>
    <h3>Liste des Modules</h3>
    <hr>   
    </div> 
  
 
    
    <!-- formulaire pour Ajouter un module -->
   
   
    
    <!-- fin formulaire -->
  
  
 <div class="row">
             <div class="card">

      <div class="card-header bg-light">
                            <div class="row btnMarge">
  <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un module -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchModule"  class="form-control" v-model="search" placeholder="recherche par Objcetif ou Type  " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         </div>
    </div>
                       </div>
       <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Année Modules </th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="moduleM of modules.data" :key="moduleM.id_module" >
                                        <td>{{ moduleM.niveau_etude}}</td> 
                                        <td  class="optionsWidth"> 
                                            <a href="#"  class="btn btn-primary" @click="redirect_To_ShowModule(moduleM)"  >
                                                <i class="fas fa-eye d-inline-block"></i>
                                            </a>
                                            <a href="#" @click="redirect_To_EditModule(moduleM)"  class="btn btn-success" >
                                                <i class="fas fa-edit d-inline-block"></i>
                                            </a>
                                             <a @click="deleteModule(moduleM)" class="btn btn-danger">
                                                 <i class="fas fa-trash-alt d-inline-block"></i>
                                            </a>
                                        </td>                                 
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                        
       
       
          
    <vue-pagination  :pagination="modules"
                     @paginate="getModules()"
                     :offset="4">
    </vue-pagination>
    </div>
       </div>
    </div>
</div>
    <!-- fin affiche -->
</div>
</template>

<script>
import  Pagination from '../Pagination.vue';

    export default{
         components:{
            'vue-pagination':Pagination,
         },

          data: () => ({
             
                 
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
                testAjout : false,
                testEdit : false,
              },
              
              // initialisation d un module 
              module: { 
                    id_module : 0,
                    nom_module : "",
                    niveau_etude : "",
                    titre_module:"",
                
              },
             modules:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,


          
    fileName : "Choose File",
          
      }),
 
 methods:{
  

    getModules(){
                axios.get('/getModules?page='+this.modules.current_page+'')
                .then((response) => {
                    this.modules = response.data.modules;
                    this.loading = false;

               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
   
    redirect_To_EditModule(moduleM){
        console.log(module)
                     this.$router.push('/EditModule/'+moduleM.niveau_etude);
            },
     redirect_To_ShowModule(moduleM){
        console.log(moduleM)
                     this.$router.push('/Showmodule/'+moduleM.niveau_etude);
            },
        searchModule(event){
             console.log(this.search);
             this.modules.current_page=1;
             if(this.search === ""){
                    this.getModules();}
                else {
                axios.get('/searchModule/'+this.search+'?page='+this.modules.current_page+'')
                .then((response) => {
                    this.modules = response.data.modules;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
     deleteModule(moduleM){

                 this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {

                            axios.delete('/deleteModule/'+moduleM.niveau_etude).then(
                                        response => {
                                
                                            this.getModules();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre compte a été supprimé',
                        'success'
                        )
  }
})
     },
fetchData () {
      this.loading = true
      this.getModules();


      }

  },
 
            created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },
watch:{

    '$route': 'fetchData',
},
        mounted(){
   
          if( this.$route.params.success == "add"){
             
                                 this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'module bien ajouter!',
                                      duration: 1500,
                                    });
          }
                    if( this.$route.params.success == "edit"){
             
                                this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'module bien modifier!',
                                      duration: 1500,
                                    });
          }
        },
      updated(){
          if( this.$route.params.success == "add"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testAjout = false }, 1500);
               }
          if( this.$route.params.success == "edit"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testEdit = false }, 1500);}               
            
      },
 
    }
    
</script>

<style scoped>
.shadawTr:hover {
  box-shadow: 1px 1px 1px 1px #888888;
    }
thead{
    background-color: #efefef;
}

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
.show{
     opacity:0.9;
    width: 270px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;}





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