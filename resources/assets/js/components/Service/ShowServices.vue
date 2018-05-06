<template>
    <div class="post" >
      <!-- au cas ajout bien passé afficher ce message -->   
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
     <b-btn :to="'/AddService'"  class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>

        </div>
  
    </div>
    <h2>Liste des Services</h2>
    <hr>   
    </div> 
  
   
            <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testAjout">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Service Bien Ajouter !</strong>
</div>
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Service Bien Modifier !</strong>
</div>
    
    <!-- formulaire pour Ajouter un service -->
   
   
    
    <!-- fin formulaire -->
  
  
 <div class="row">
             <div class="card">

       <!-- afficher les services sous formes des cards  -->
      <div class="card-header bg-light">
                            <div class="row btnMarge">
  <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchService"  class="form-control" v-model="search" placeholder="recherche par Nom ou Service  " aria-label="Username" aria-describedby="basic-addon1" >
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
                                        <th>Nom Service</th>
                                        <th>besoin_service </th>
                                        <th>Durée Service</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="service of services.data" :key="service.id_service" >
                                        <td>{{service.nom_service}}</td>
                                        <td>{{service.besoin_service}} </td>
                                        <td>{{ service.duree_service}}</td> 
                                        <td  class="optionsWidth"> 
                                            <a href="#" @click="redirect_To_EditService(service)"  class="btn btn-success" >
                                                <i class="fas fa-edit d-inline-block"></i>
                                            </a>
                                             <a @click="deleteService(service)" class="btn btn-danger">
                                                 <i class="fas fa-trash-alt d-inline-block"></i>
                                            </a>
                                        </td>                                 
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                        
       
       
          
    <vue-pagination  :pagination="services"
                     @paginate="getServices()"
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
              
              // tester l ajout si bien fais 
              
              // tester  si affiche services  ou afficher ajouter service 
              
              // initialisation d un service 
              service: { 
                    id_service : 0,
                    nom_service : "",
                    besoin_service : "",
                    duree_service : "",
                    
                
              },
             services:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
               offset: 4,


          
    fileName : "Choose File",
    user: {
      id:0,
      email:"",
      password:"",
      role:"service",
    
      
    },

    users:[],
            
             
             
      }),
 
 methods:{
  

    getServices(){//type_status
                axios.get('/getServices?page='+this.services.current_page+'')
                .then((response) => {
                    this.services = response.data.services;
                    this.loading = false;

               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
   
    redirect_To_EditService(service){
                     this.$router.push('/EditService/'+service.id_service);
        //this.$router.push({ name: 'EditService', params: {service:this.service}});
//console.log(service)
            },
     
        searchService(event){
             console.log(this.search);
             this.services.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getServices();}
                else {
                     // console.log('test1');
                axios.get('/searchService/'+this.search+'?page='+this.services.current_page+'')
                .then((response) => {
                  console.log('searchhhh ')
                  console.log(response.data.services)
                    this.services = response.data.services;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
     deleteService(service){

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
                           // console.log(service.fk_user)
                            axios.delete('/deleteService/'+service.id_service).then(
                                        response => {
                                
                                            this.getServices();
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
      //this.error = this.post = null
      this.loading = true
      this.getServices();


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
             
                        this.Testopen.testAjout = true;
          }
                    if( this.$route.params.success == "edit"){
             
                        this.Testopen.testEdit = true;
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
.optionsWidth{
width : 171px;

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

.notifresponsable{
    opacity:0.9;
    width: 241px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;
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