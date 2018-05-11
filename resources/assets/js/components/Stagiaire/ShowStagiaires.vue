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
    <b-btn v-b-modal.modalPrevent class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>

        </div>
  
    </div>
    <h3>Liste des Satgiaires</h3>
    <hr>   
    </div> 


     <div class="row">
        <div class="col">

    
       <b-modal id="modalPrevent"
             ref="modal"
             title="+ Compte"
             @ok="addCompte"
             ok-title="Suivant" >
      <form @submit.stop.prevent="handleSubmit">

    <div class="form-group row">
                 <label for="reference" class="col-sm-2 col-form-label">Email: </label>
                    <div class="col-sm-10">
                    <b-form-input  type="text" v-model="user.email" class="form-control" id="Email" placeholder="Email" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="reference" class="col-sm-2 col-form-label">Password: </label>
                    <div class="col-sm-10">
                    <b-form-input  type="password" v-model="user.password" class="form-control" id="password" placeholder="Password" required/>
                    </div>
                </div>
     <div class="form-group row">
                    <label for="reference" class="col-sm-2 col-form-label">Role: </label>                    
                    <div class="col-sm-10">
                    <b-form-input  type="text" v-model="user.role" class="form-control" id="Role" placeholder="Role" disabled/>
                    </div>
                </div>
   
 



      
      </form>

    </b-modal>
  </div>
    </div>
    
            <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testAjout">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>stagiaire Bien Ajouter !</strong>
</div>
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>stagiaire Bien Modifier !</strong>
</div>
    
    
  
    
    <!-- formulaire pour Ajouter un stagiaire -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les stagiaires sous formes des cards  -->
    <div style="width: 75%">
      <div class="card-header bg-light">
                            <div class="row btnMarge">
  <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchStagiaire"  class="form-control" v-model="search" placeholder="recherche par Nom ou prenom  " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         </div>
    </div>
                       </div>

    </div>
                       <br>
  
 <div class="row">
       <div class="col-auto" v-for="stagiaire of stagiaires.data" :key="stagiaire.id_stagiaire" >
            <div class="card widthCard tailleCards"  >
            <img v-if="stagiaire.photo_stagiaire != ''" class="card-img-top tailleImage" :src="'storage/images/'+stagiaire.photo_stagiaire" alt="Card image cap" width="100px" height="150px">
            <img v-if="stagiaire.photo_stagiaire === ''" class="card-img-top tailleImage" :src="'storage/images/user0.jpg'" alt="Card image cap" width="100px" height="150px">

            <div class="card-body">
                <h5 class="card-title">Nom : {{stagiaire.nom_stagiaire}}</h5>
                <div class="card-text">
                    <hr>
                    <div class="widthTextCard">Prenom : {{ stagiaire.prenom_stagiaire}}</div>
                    <hr>
                    <div class="widthTextCard">Service : {{stagiaire.specialite_stagiaire}}</div>
                    <hr>
                </div>
                
                <div> 
                    
                <a href="#"  class="btn btn-primary" @click="getStagiaire(stagiaire)"  ><i class="fas fa-eye d-inline-block"></i></a>
                            
                  <a href="#"    @click="redirect_To_EditStagiaire(stagiaire)"  class="btn btn-success" ><i class="fas fa-edit d-inline-block "></i></a>
                    <a href="#" class="btn btn-danger " @click="deleteStagiaire(stagiaire)"><i class="fas fa-trash-alt d-inline-block"></i></a>
                </div>
            </div>
            </div>
        </div>
         <div>
              
            </div>
             <div>
              
                <b-modal ok-only  v-model="modalShow" no-fade
                :title="'Compte : Stagiaire'"
                :body-bg-variant="+' '+modalShow+''+stagiaire.nom_stagiaire+''+stagiaire.prenom_stagiaire+''+stagiaire.tel_stagiaire+''+stagiaire.email+''+stagiaire.service_stagiaire+''+stagiaire.adresse_stagiaire+''+stagiaire.photo_stagiaire+''">
                 <div class="row" v-if="modalShow">
                      
                         <div class="col">
                   <span>Nom : </span>{{stagiaire.nom_stagiaire}}
                   <hr>
                   <span>Prenom : </span>{{stagiaire.prenom_stagiaire}} 
                   <hr>
                   <span>Téléphone : </span>{{stagiaire.tel_stagiaire}}
                   <hr>
                   <span>E-mail :  </span>{{stagiaire.email}}
                   <hr>
                   <span>Date Naissance :  </span>{{stagiaire.dateNaissance_stagiaire}}
                   <hr>
                    <span>Adresse :  </span>{{stagiaire.adresse_stagiaire}}
                   <hr>
                   </div>
                                                   
                   
                   <div class="col">
                       <div class="pull-right">
                     
                      <img v-if="stagiaire.photo_stagiaire != ''" class="card-img-top" :src="'storage/images/'+stagiaire.photo_stagiaire" width="150px" height="150px">
                    <img v-if="stagiaire.photo_stagiaire === ''" class="card-img-top" :src="'storage/images/user0.jpg'"  width="150px" height="150px">
                    
                    <hr>
                   <span>specialite  : {{stagiaire.specialite_stagiaire}}</span>
                   
                    <hr>
                   <span>annee universitaire : {{stagiaire.annee_universitaire_stagiaire}}</span>
                   <hr>
                    
                     </div>
                     
                     </div>
                     </div>
                    <div slot="modal-footer" class="w-100">
                    <p class="float-left"> </p>
                    <b-btn size="sm" class="float-right" variant="primary" @click="modalShow=false">
                    Fermer
                    </b-btn>
                </div>
                </b-modal>
            </div>
    </div> 
    
    <vue-pagination  :pagination="stagiaires"
                     @paginate="getStagiaires()"
                     :offset="4">
    </vue-pagination>
    </div>  
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
              
              // tester  si affiche stagiaires  ou afficher ajouter stagiaire 
              
              // initialisation d un stagiaire 
         stagiaire: { 
                    id_stagiaire : 0,
                    nom_stagiaire : "",
                    prenom_stagiaire : "",
                    photo_stagiaire : "",
                    adresse_stagiaire : "",
                    email_stagiaire : "",
                    tel_stagiaire : "",
                    dateNaissance_stagiaire : "",
                    specialite_stagiaire: "",
                    annee_universitaire_stagiaire: "",	
                    fk_user : 0,
                
              }, 
             stagiaires:{
                        
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
      role:"Stagiaire",
    
      
    },

    users:[],
            
             
             
      }),
                  created () {
    this.fetchData()
  },
 
 methods:{
     fetchData () {
      //this.error = this.post = null
       this.loading = true
       this.countUser();
       this.getStagiaires();


      },
      onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.fileName=files[0].name;

                if (!files.length)
                    return;
                this.createImage(files[0]);
    },

    createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.stagiaire.photo_stagiaire = e.target.result;
                };
                reader.readAsDataURL(file);
    },
    countUser(){

                axios.get('/countUser')
                .then((response) => {
                    console.log(response.data.count)
                    this.user.id=response.data.count;
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },

    getStagiaires(){//type_status
                axios.get('/getStagiaires?page='+this.stagiaires.current_page+'')
                .then((response) => {
                    this.loading = false;
                    this.stagiaires = response.data.stagiaires;
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
    getStagiaire(stagiaire){
                  axios.get('/getStagiaire/'+stagiaire.id_stagiaire).then(
                  response => {
                       
                    this.stagiaire= response.data.stagiaire[0];
                                  console.log(this.stagiaire)

                    this.modalShow = !this.modalShow
                  });         
    },
    redirect_To_EditStagiaire(stagiaire){
                     this.$router.push('/EditStagiaire/'+stagiaire.id_stagiaire);
        //this.$router.push({ name: 'Editstagiaire', params: {stagiaire:this.stagiaire}});
//console.log(stagiaire)
            },
     // ajouter un user
    addCompte() {
               
    this.$router.push({ name: 'AddStagiaire', params: { user: this.user }});
            
    },
        searchStagiaire(event){
             console.log(this.search);
             this.stagiaires.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getStagiaires();}
                else {
                     // console.log('test1');
                axios.get('/searchStagiaire/'+this.search+'?page='+this.stagiaires.current_page+'')
                .then((response) => {
                  console.log('searchhhh ')
                  console.log(response.data.stagiaires)
                    this.stagiaires = response.data.stagiaires;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
     deleteStagiaire(stagiaire){

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
                           // console.log(stagiaire.fk_user)
                            axios.delete('/deleteStagiaire/'+stagiaire.id).then(
                                        response => {
                                
                                            this.getStagiaires();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre compte a été supprimé',
                        'success'
                        )
  }
})
     }  


  },
 
   
        mounted(){

   
           if( this.$route.params.success == "add"){
             
                       // this.Testopen.testnotifAdd = true;                  
                                   this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Groupe bien ajouter!',
                                      duration: 1500,
                                    });
          }
                    if( this.$route.params.success == "edit"){
             
                             this.$notify({
                                      group: 'foo',
                                      title: 'Succès',
                                      text: 'Groupe bien modifier!',
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

.notifstagiaire{
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

.tailleCards{
    height:292px;
}
.tailleImage{
    height:90px;
}

</style>



