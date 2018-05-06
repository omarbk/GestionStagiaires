<template>
    <div class="post" >
      <!-- au cas ajout bien passé afficher ce message -->   
            
           
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
    <h2>Liste des Evaluateurs</h2>
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
                    <b-form-input  type="text" v-model="user.email" class="form-control" id="Email" placeholder="Email" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="reference" class="col-sm-2 col-form-label">Password: </label>
                    <div class="col-sm-10">
                    <b-form-input  type="password" v-model="user.password" class="form-control" id="password" placeholder="Password" />
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
  <strong>Evaluateur Bien Ajouter !</strong>
</div>
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Evaluateur Bien Modifier !</strong>
</div>
        <!-- formulaire pour Ajouter un evaluateur -->
   
   
    
    <!-- fin formulaire -->
    <!-- afficher les evaluateurs sous formes des cards  -->
    <div style="width: 75%">
      <div class="card-header bg-light">
                            <div class="row btnMarge">
  <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchEvaluateur"  class="form-control" v-model="search" placeholder="recherche par Nom ou Service  " aria-label="Username" aria-describedby="basic-addon1" >
            </div>
        </div> 
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         </div>
    </div>
                       </div>

    </div>
                       <br>
  
 <div class="row">
       <div class="col-auto" v-for="evaluateur of evaluateurs.data" :key="evaluateur.id_evaluateur" >
            <div class="card widthCard"  >
            <img v-if="evaluateur.photo_evaluateur != ''" class="card-img-top" :src="'storage/images/'+evaluateur.photo_evaluateur" alt="Card image cap" width="100px" height="150px">
            <img v-if="evaluateur.photo_evaluateur === ''" class="card-img-top" :src="'storage/images/responsable0.jpg'" alt="Card image cap" width="100px" height="150px">

            <div class="card-body">
                <h5 class="card-title">Nom : {{evaluateur.nom_evaluateur}}</h5>
                <div class="card-text">
                    <hr>
                    <div class="widthTextCard">Prenom : {{ evaluateur.prenom_evaluateur}}</div>
                    <hr>
                    <div class="widthTextCard">Service : {{evaluateur.service_evaluateur}}</div>
                    <hr>
                </div>
                
                <div> 
                    
                <a href="#"  class="btn btn-primary" @click="getEvaluateur(evaluateur)"  ><i class="fas fa-eye d-inline-block"></i></a>
                            
                  <a href="#"    @click="redirect_To_EditEvaluateur(evaluateur)"  class="btn btn-success" ><i class="fas fa-edit d-inline-block "></i></a>
                    <a href="#" class="btn btn-danger " @click="deleteEvaluateur(evaluateur)"><i class="fas fa-trash-alt d-inline-block"></i></a>
                </div>
            </div>
            </div>
        </div>
       
             <div>
              
                <b-modal ok-only  v-model="modalShow" no-fade
                :title="'Compte : Evaluateur'"
                :body-bg-variant="+' '+modalShow+''+evaluateur.nom_evaluateur+''+evaluateur.prenom_evaluateur+''+evaluateur.tel_evaluateur+''+evaluateur.email+''+evaluateur.service_evaluateur+''+evaluateur.adresse_evaluateur+''+evaluateur.photo_evaluateur+''">
                 <div class="row" v-if="modalShow">
                      
                         <div class="col">
                   <span>Nom : </span>{{evaluateur.nom_evaluateur}}
                   <hr>
                   <span>Prenom : </span>{{evaluateur.prenom_evaluateur}} 
                   <hr>
                   <span>Téléphone : </span>{{evaluateur.tel_evaluateur}}
                   <hr>
                   <span>E-mail :  </span>{{evaluateur.email}}
                   <hr>
                   <span>Date Naissance :  </span>{{evaluateur.dateNaissance_evaluateur}}
                   <hr>
                    <span>Adresse :  </span>{{evaluateur.adresse_evaluateur}}
                    <hr>
                   <span>Centre : </span>{{evaluateur.nom_hospitalier}}
                  
                   </div>
                                                   
                   
                   <div class="col">
                       <div class="pull-right">
                     
                      <img v-if="evaluateur.photo_evaluateur != ''" class="card-img-top" :src="'storage/images/'+evaluateur.photo_evaluateur" width="150px" height="150px">
                    <img v-if="evaluateur.photo_evaluateur === ''" class="card-img-top" :src="'storage/images/responsable0.jpg'"  width="150px" height="150px">
                    
                    <hr>
                   <span>Service : </span>{{evaluateur.service_evaluateur}}
                   <hr>
                   <span>Type : </span>{{evaluateur.type_evaluateur}}
                   <hr>
                   <span>Spécialite : </span>{{evaluateur.specialite_evaluateur}}
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
    
    <vue-pagination  :pagination="evaluateurs"
                     @paginate="getEvaluateurs()"
                     :offset="4">
    </vue-pagination>
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
              
              // tester  si affiche evaluateurs  ou afficher ajouter evaluateur 
              
              // initialisation d un evaluateur 
              evaluateur: { 
                    id_evaluateur : 0,
                    nom_evaluateur : "",
                    prenom_evaluateur : "",
                    photo_evaluateur : "",
                    adresse_evaluateur : "",
                    tel_evaluateur : "",
                    dateNaissance_evaluateur : "",
                    service_evaluateur : "",
                    specialite_evaluateur:"",
                    type_evaluateur:"",
                    fk_hospitalier:"",
                    fk_user : 0,
                
              },
             evaluateurs:{
                        
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
      role:"Evaluateur",
    
      
    },

    users:[],
            
             
             
      }),
 
 methods:{
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
                    vm.evaluateur.photo_evaluateur = e.target.result;
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

    getEvaluateurs(){//type_status
                axios.get('/getEvaluateurs?page='+this.evaluateurs.current_page+'')
                .then((response) => {
                    console.log(response)
                    this.loading = false;
                    this.evaluateurs = response.data.evaluateurs;
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
    getEvaluateur(evaluateur){
                  axios.get('/getEvaluateur/'+evaluateur.id_evaluateur).then(
                  response => {
                       
                    this.evaluateur= response.data.evaluateur[0];
                                  console.log(this.evaluateur)

                    this.modalShow = !this.modalShow
                  });         
    },
    redirect_To_EditEvaluateur(evaluateur){
                     this.$router.push('/EditEvaluateur/'+evaluateur.id_evaluateur);
        //this.$router.push({ name: 'Editevaluateur', params: {evaluateur:this.evaluateur}});
//console.log(evaluateur)
            },
     // ajouter un user
    addCompte() {
               
    this.$router.push({ name: 'AddEvaluateur', params: { user: this.user }});
            
    },
        searchEvaluateur(event){
             console.log(this.search);
             this.evaluateurs.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getEvaluateurs();}
                else {
                     // console.log('test1');
                axios.get('/searchEvaluateur/'+this.search+'?page='+this.evaluateurs.current_page+'')
                .then((response) => {
                  console.log('searchhhh ')
                  console.log(response.data.evaluateurs)
                    this.evaluateurs = response.data.evaluateurs;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
     deleteEvaluateur(evaluateur){

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
                           // console.log(evaluateur.fk_user)
                            axios.delete('/deleteEvaluateur/'+evaluateur.id).then(
                                        response => {
                                
                                            this.getEvaluateurs();
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
        this.countUser();
        this.getEvaluateurs();

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



