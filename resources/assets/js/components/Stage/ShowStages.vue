<template>
    <div class="post" >
            <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification success"/>    
      <!-- au cas ajout bien passé afficher ce message -->   
        <h5>Stages </h5>      
           
    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
     <div class="row">
        <div class="col">
    <router-link class="float-right btn btn-secondary" :to="'/AddStage'" ><i class="fas fa-plus-circle"/> Ajouter </router-link>
       
  </div>
    </div>
    
            <div v-if="Testopen.testnotifAdd" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Groupe bien ajouter !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

        <div v-if="Testopen.testnotifEdit" class="alert alert-success alert-dismissible fade show notifArticle" role="alert">
        <strong>Groupe bien modifier !</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    
    
  
    <hr>
    <!-- formulaire pour Ajouter un article -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les articles sous formes des cards  -->
    
  


    <div class="row" id="testdiv">
             <div class="card">
                        <div class="card-header bg-light">
                            <div class="row btnMarge">
 
    <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchComptes"  class="form-control" v-model="search" placeholder="recherche par nom du Compte ou responsable " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
        
    </div>
                       </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>intitule</th>
                                        <th>date Debut</th>                                       
                                        <th>date Fin</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="stage of stages.data" :key="stage.id_stage" >
                                        <td>{{stage.intitule_stage}}</td>
                                        <td>{{stage.dateDebut_stage}}</td> 
                                        <td>{{stage.dateFin_stage}}</td>
                                        <td  class="optionsWidth"> 
                                            <a href="#"    @click="redirect_To_ShowStage(stage.id_stage)"  class="btn btn-primary"  ><i class="fas fa-eye d-inline-block"></i></a>
                                         <router-link class="btn btn-success " :to="'/EditStage/'+stage.id_stage"><i class="fas fa-edit d-inline-block"></i></router-link>
                                             <a @click="deleteStage(stage)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></td>                                 
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
              
            </div>
            </div>  
    </div>
    
    <vue-pagination  :pagination="groupes"
                     @paginate="getGroupes()"
                     :offset="4">
    </vue-pagination>
    </div>
    <!-- fin affiche -->
   
</template>

<script>
import  Pagination from '../Pagination.vue';

    export default{
         components:{
            'vue-pagination':Pagination,
         },

          data: () => ({
             
             groupe:{
            id_groupe:0,
            nom_groupe: "",
            annee_universitaire_groupe:""     
            },
              test1 : {
                  searchQuery: 0,
                   calculee: 0,
                  },
                 
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
                testnotifEdit : false,
                testnotifAdd : false,
                testAjout : false,
                testAffiche : false,
                testmodelArticle : false,
              },
              testEdit : false,
              // tester l ajout si bien fais 
              
              // tester  si affiche articles  ou afficher ajouter article 
              
              // initialisation d un article 
              comptes:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
                groupes:{
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],
                },
                   stages:{
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],
                },


               offset: 4,


              compte: { 
                    id_compte : 0,
                    nom_compte : "",
                    responsable : "",
                    type_compte : "",
                    categorie : "",
                    raison_social : "",
                    reference : "",
                    fixe : "",
                    portable : "",
                    fax : "",
                    email : "",
                    site_web  : "",
                    secteur_activite : "",
                    taille : "",
                    RC : "",
                    fk_compagnie : "",
              },
    fileName : "Choose File",
    user: {
      id:0,
      names:"",
      email:"",
      password:"",
      role:"Responsable",
      photo:"",
      
    },

    users:[],
            
             
             
      }),
 
 methods:{
     
        getGroupes(){
                axios.get('/getGroupes?page='+this.groupes.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.groupes = response.data.groupes;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
        getStages(){
                axios.get('/getStages?page='+this.groupes.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.stages = response.data.stages;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
              fetchData () {
      //this.error = this.post = null
      this.loading = true
      // replace `getPost` with your data fetching util / API wrapper
                 axios.get('/getStages?page='+this.groupes.current_page+'')
                .then((response) => {
                 // console.log('shit');
                    this.stages = response.data.stages;
                  this.loading =false
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
 
    },
    deleteStage:function(stage){

        console.log(stage);
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
                            axios.delete('/deleteStage/'+stage.id_stage).then(
                                        response => {
                                
                                            this.getStages();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre  Stage a été supprimé',
                        'success'
                        )
  }
})

        },
               redirect_To_ShowStage(id_stage){
                   //  this.$router.push('/ShowGroupe/'+id_groupe);
                   
                      this.$router.push({ name: 'ShowStage', params: {id_stage: id_stage}});
            },


  },
     mounted(){
           
          if( this.$route.params.success == "addsuccess"){
             
                        this.Testopen.testnotifAdd = true;
          }
                    if( this.$route.params.success == "editsuccess"){
             
                        this.Testopen.testnotifEdit = true;
          }
        },
      updated(){
          if( this.$route.params.success == "addsuccess"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testnotifAdd = false }, 1500);
               }
          if( this.$route.params.success == "editsuccess"){
          let this1 = this
               setTimeout(function () { this1.Testopen.testnotifEdit = false }, 1500);}               
            
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

.notifArticle{
    opacity:0.9;
    width: 241px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;
}






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



