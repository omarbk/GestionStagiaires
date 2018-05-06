<template>
    <div class="post" >
   
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
     <b-btn :to="'/AddObjectif'"  class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>

        </div>
  
    </div>
    <h2>Liste des Objectifs</h2>
    <hr>   
    </div> 
  
   
            <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testAjout">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Objectif Bien Ajouter !</strong>
</div>
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Objectif Bien Modifier !</strong>
</div>
    
    <!-- formulaire pour Ajouter un objectif -->
   
   
    
    <!-- fin formulaire -->
  
  
 <div class="row">
             <div class="card">

      <div class="card-header bg-light">
                            <div class="row btnMarge">
  <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un objectif -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchObjectif"  class="form-control" v-model="search" placeholder="recherche par Objcetif ou Type  " aria-label="Username" aria-describedby="basic-addon1" >
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
                                        <th>Objectif</th>
                                        <th>Type Objectif </th>
                                        <th>Coefficient</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="objectif of objectifs.data" :key="objectif.id_evaluation_objectif" >
                                        <td>{{objectif.objectif}}</td>
                                        <td>{{objectif.type_objectif}} </td>
                                        <td>{{ objectif.coefficient}}</td> 
                                        <td  class="optionsWidth"> 
                                            <a href="#" @click="redirect_To_EditObjectif(objectif)"  class="btn btn-success" >
                                                <i class="fas fa-edit d-inline-block"></i>
                                            </a>
                                             <a @click="deleteObjectif(objectif)" class="btn btn-danger">
                                                 <i class="fas fa-trash-alt d-inline-block"></i>
                                            </a>
                                        </td>                                 
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                        
       
       
          
    <vue-pagination  :pagination="objectifs"
                     @paginate="getObjectifs()"
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
              
              // initialisation d un objectif 
              objectif: { 
                    id_evaluation_objectif : 0,
                    objectif : "",
                    type_objectif : "",
                    coefficient : 0,
                    
                
              },
             objectifs:{
                        
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
  

    getObjectifs(){
                axios.get('/getObjectifs?page='+this.objectifs.current_page+'')
                .then((response) => {
                    this.objectifs = response.data.objectifs;
                    this.loading = false;

               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
   
    redirect_To_EditObjectif(objectif){
                     this.$router.push('/EditObjectif/'+objectif.id_evaluation_objectif);
            },
     
        searchObjectif(event){
             console.log(this.search);
             this.objectifs.current_page=1;
             if(this.search === ""){
                    this.getObjectifs();}
                else {
                axios.get('/searchObjectif/'+this.search+'?page='+this.objectifs.current_page+'')
                .then((response) => {
                    this.objectifs = response.data.objectifs;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
     deleteObjectif(objectif){

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

                            axios.delete('/deleteObjectif/'+objectif.id_evaluation_objectif).then(
                                        response => {
                                
                                            this.getObjectifs();
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
      this.getObjectifs();


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