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
  <strong>stagiaire Bien Ajouter !</strong>
</div>
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>stagiaire Bien Modifier !</strong>
</div>
    
    
  
    <hr>
    <!-- formulaire pour Ajouter un stagiaire -->
   
   <div class="row">
                <div class="col-6 col-sm-4">              
                            <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" @keyup.enter="searchStagiaire"  class="form-control" v-model="searchStage" placeholder="recherche par Stage " aria-label="Username" aria-describedby="basic-addon1" >
                            </div>
                 </div>
  <div class="col-6 col-sm-4">
                        
                            <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" @keyup.enter="searchStagiaire"  class="form-control" v-model="searchGroupe" placeholder="recherche par Groupe " aria-label="Username" aria-describedby="basic-addon1" >
                            </div>
                
  </div>
<div class="col-6 col-sm-4">
                        <div class="form-group row">
                        <label for="stagiaire" class="col-sm-4" >niveau d'étude:</label>
                        <div class="col-sm-8">
    
                            <select class="form-control custom-select " id="fk_compte" v-model="searchNiveauE" @change="searchStagiaire" >
                                        <option value="" selected>Choisir année</option>
                                        <option v-for="(anneeEtude,index) of listAnneeEtude" :key="index" :value="anneeEtude"> {{anneeEtude}} </option>
                            </select>  

                        
                                </div>
                            </div>
</div>
  <div class="col-12"> <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>stage</th>
                                        <th>groupe</th>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>specialite</th>
                                        <th>Niveau d'étude</th>
                                        <th>options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(stagiaire,index) of stagiaires.data" :key="index" >
                                        <td>{{stagiaire.intitule_stage}}</td>
                                        <td>{{stagiaire.nom_groupe}}</td>
                                        <td>{{stagiaire.nom_stagiaire}}</td>
                                        <td>{{stagiaire.prenom_stagiaire}}</td>
                                        <td>{{stagiaire.specialite_stagiaire}}</td>  
                                        <td>{{stagiaire.niveau_etude_stagiaire}}</td>  
                                        <td>{{stagiaire.id_stage}}</td>  

                                        <td  class="optionsWidth"> 
                                                 <a href="#"  @click="redirect_To_Absences(stagiaire)"   class="btn btn-primary"   ><i class="fab fa-product-hunt"></i></a>
                            
                  <a href="#"  @click="redirect_To_Evaluation(stagiaire)"   class="btn btn-success" ><i class="far fa-sticky-note"></i></a>
                                          </td>                                  
                                    </tr>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    </div>
                                    </tbody>
                                </table>
                            </div></div>
</div>
    
    <!-- fin formulaire -->
    <!-- afficher les stagiaires sous formes des cards  -->
   


 
    
    <vue-pagination  :pagination="stagiaires"
                     @paginate="getStagiairesParEvaluateur()"
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
               listAnneeEtude : ["1er annnée","2eme année","3eme année","4eme année","5eme année","6eme année","7eme année"],
             
                 
                     loading: false,
      post: null,
      error: null,
             modalShow: false,
              //search
              searchNiveauE:'',
              searchStage : '',
              searchGroupe: '',
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
                    niveau_etude_stagiaire:"",
                    id_stage:0,
                
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
       this.getStagiairesParEvaluateur();


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

    getStagiairesParEvaluateur(){

            axios.get('/getStagiairesParEvaluateur?page='+this.stagiaires.current_page+'')
                .then((response) => {
                    this.loading = false;
                    this.stagiaires = response.data.stagiaires;
                   console.log('staaaaaaaaaaaaaaaaaaaage')
                   console.log(response)
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
    redirect_To_Absences(stagiaire){
        console.log('stgiaires')
                      console.log(this.stagiaires)
                     this.$router.push({ name: 'ShowAbsences', params: { stagiaire:stagiaire,fk_evaluateur:this.stagiaires.data[0].fk_evaluateur}});
        //this.$router.push({ name: 'Editstagiaire', params: {stagiaire:this.stagiaire}});
//console.log(stagiaire)
            },
            redirect_To_Evaluation(stagiaire){
        console.log('stgiaires')
        console.log(stagiaire)
               this.$router.push({ name: 'ShowEvaluation', params: { stagiaire:stagiaire}});
        //this.$router.push({ name: 'Editstagiaire', params: {stagiaire:this.stagiaire}});
//console.log(stagiaire)
            },
     // ajouter un user
    addCompte() {
               
    this.$router.push({ name: 'AddStagiaire', params: { user: this.user }});
            
    },
        searchStagiaire(event){
            console.log('------ annnée -------')
            console.log(this.searchNiveauE)
             console.log(this.search);
             this.stagiaires.current_page=1;
             if(this.searchStage === "" && this.searchGroupe === "" && this.searchNiveauE ===""){
                //console.log('test2');
                    this.getStagiairesParEvaluateur();}
                else {
                     // console.log('test1');
  
  //axios.get('/searchStagiaireParStageGroupe/'+this.searchStage+'/'+this.searchGroupe+'?page='+this.stagiaires.current_page+'')
                axios.get('/searchStagiaireParStageGroupe',{ params: {page: this.stagiaires.current_page,searchStage: this.searchStage ,searchGroupe:this.searchGroupe,searchNiveauE:this.searchNiveauE} })
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
                                
                                            this.getStagiairesParEvaluateur();
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
.searchHight{
    height: 30px;
}

</style>



