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
     <b-btn :to="'/AddHospitalier'"  class="float-right btn btn-primary" ><i class="fas fa-plus-circle"/> Ajouter</b-btn>

        </div>
  
    </div>
    <h2>Liste des Hospitaliers</h2>
    <hr>   
    </div> 
  
   
            <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testAjout">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Hospitalier Bien Ajouter !</strong>
</div>
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEdit">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Hospitalier Bien Modifier !</strong>
</div>
    
    <!-- formulaire pour Ajouter un hospitalier -->
   
   
    
    <!-- fin formulaire -->
  
  
 <div class="row">
             <div class="card">

       <!-- afficher les hospitaliers sous formes des cards  -->
      <div class="card-header bg-light">
                            <div class="row btnMarge">
  <div class="col"  >
    <!-- button pour afficher formulaire de l'ajout d un article -->         
                <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" @keyup.enter="searchHospitalier"  class="form-control" v-model="search" placeholder="recherche par Nom de hospitalier  " aria-label="Username" aria-describedby="basic-addon1" >
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
                                        <th>Nom Hospitalier</th>
                                        <th>Adresse </th>
                                        <th>Téléphone</th>
                                        <th>Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="hospitalier of hospitaliers.data" :key="hospitalier.id_hospitalier" >
                                        <td>{{hospitalier.nom_hospitalier}}</td>
                                        <td>{{hospitalier.adresse_hospitalier}} </td>
                                        <td>{{ hospitalier.tel_hospitalier}}</td> 
                                        <td  class="optionsWidth"> 
                                            <a href="#"  class="btn btn-primary" @click="getHospitalier(hospitalier)"  >
                                                <i class="fas fa-eye d-inline-block"></i>
                                            </a>
                                            <a href="#" @click="redirect_To_EditHospitalier(hospitalier)"  class="btn btn-success" >
                                                <i class="fas fa-edit d-inline-block"></i>
                                            </a>
                                             <a @click="deleteHospitalier(hospitalier)" class="btn btn-danger">
                                                 <i class="fas fa-trash-alt d-inline-block"></i>
                                            </a>
                                        </td>                                 
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                        
       
       
          
    <vue-pagination  :pagination="hospitaliers"
                     @paginate="getHospitaliers()"
                     :offset="4">
    </vue-pagination>
    </div>
       </div>
        <div>
              
                <b-modal ok-only  v-model="modalShow" no-fade
                :title="'Hospitalier'"
                :body-bg-variant="+' '+modalShow+''+hospitalier.nom_hospitalier+''+hospitalier.tel_hospitalier+''+hospitalier.adresse_hospitalier+''">
                 <div class="row" v-if="modalShow">
                      
                         <div class="col">
                   <span>Nom Hospitalier : </span>{{hospitalier.nom_hospitalier}}
                   <hr>
                   <span>Téléphone : </span>{{hospitalier.tel_hospitalier}}
                   <hr>
                    <span>Adresse :  </span>{{hospitalier.adresse_hospitalier}}
                   <hr>
                   </div>
                                                   
                   
                   <div class="col">
                       <div class="pull-right">
                     
                   <span>List Services : </span>
<div  v-for="service of services" :key="service.id_service" >

                  + {{service.nom_service}}
</div>
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
              
              // tester  si affiche hospitaliers  ou afficher ajouter hospitalier 
              
              // initialisation d un hospitalier 
              hospitalier: { 
                    id_hospitalier : 0,
                    nom_hospitalier : "",
                    adresse_hospitalier : "",
                    tel_hospitalier : "",
                    //nom_service:"",
                
              },
             hospitaliers:{
                        
                        total: 0,
                        per_page: 2,
                        from: 1,
                        to: 0,
                        current_page: 1,
                        data: [],

              },
              services:[],
               offset: 4,


          
    fileName : "Choose File",
   }),
 
 methods:{
  

    getHospitaliers(){//type_status
                axios.get('/getHospitaliers?page='+this.hospitaliers.current_page+'')
                .then((response) => {
                    console.log(response)
                    this.hospitaliers = response.data.hospitaliers;
                    console.log
                    this.loading = false;

               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
    
    getService_Hospitalier(hospitalier){
    axios.get('/getService_Hospitalier/'+hospitalier.id_hospitalier).then(
                  response => {
                       
                    this.services= response.data.serviceHospitalier;
                                  console.log(this.services)
                    this.modalShow = !this.modalShow

                  });
   },
    redirect_To_EditHospitalier(hospitalier){
                     this.$router.push('/EditHospitalier/'+hospitalier.id_hospitalier);
        //this.$router.push({ name: 'Edithospitalier', params: {hospitalier:this.hospitalier}});
//console.log(hospitalier)
            },
    getHospitalier(hospitalier){
                  axios.get('/getHospitalier/'+hospitalier.id_hospitalier).then(
                  response => {
                       
                    this.hospitalier= response.data.hospitalier[0];
                                  console.log(this.hospitalier)
                    this.getService_Hospitalier(hospitalier);
                  });         
    },
        searchHospitalier(event){
             console.log(this.search);
             this.hospitaliers.current_page=1;
             if(this.search === ""){
                //console.log('test2');
                    this.getHospitaliers();}
                else {
                     // console.log('test1');
                axios.get('/searchHospitalier/'+this.search+'?page='+this.hospitaliers.current_page+'')
                .then((response) => {
                  console.log('searchhhh ')
                  console.log(response.data.hospitaliers)
                    this.hospitaliers = response.data.hospitaliers;
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });}
                    
          },
     deleteHospitalier(hospitalier){

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
                            axios.delete('/deleteHospitalier/'+hospitalier.id_hospitalier).then(
                                        response => {
                                
                                            this.getHospitaliers();
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
      this.getHospitaliers();


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