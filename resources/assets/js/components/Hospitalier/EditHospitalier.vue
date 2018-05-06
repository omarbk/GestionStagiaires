<template>
  <div>
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
    <!-- button pour afficher tous les Hospitaliers-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowHospitaliers'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Modifier un Hospitalier</h2>
    <hr>   
    </div>   
   

<div class="body">
        <form @submit.prevent="updateHospitalier">
         <div class="row" > 
         
            <div class="col-md-9">
               

                <div class="form-group row">
                    <label for="Hospitalier" class="col-sm-3" > Nom d'Hospitalier</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="nom"  v-model="hospitalier.nom_hospitalier">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hospitalier" class="col-sm-3" > Téléphone</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="tel"  v-model="hospitalier.tel_hospitalier">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="hospitalier" class="col-sm-3" > Adresse</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="adresse"  v-model="hospitalier.adresse_hospitalier">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="typo__label col-sm-3">Services</label>
                    <div class="col-sm-6">

  <multiselect v-model="value" tag-placeholder="Add this as new tag" @remove="spliceService" placeholder="Search or add a tag" label="nom_service" track-by="id_service"  :options="services" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                      </div>
                </div>
                <div>
   
   
  
</div>
            </div> 
            <div class="col-md-3">
                <button  class="btn mb-3  btn-success">Enregister</button>
            </div>
    </div>

     </form>
</div>
     
  </div>
  </div>
</template>
<script>
    

//import Underscore from 'underscore/underscore.js';
    export default{

          data:()=>({
            index:0,
            nameFile : "Choose file",
            loading: false,

            hospitalier: { 
                    id_hospitalier : 0,
                    nom_hospitalier : "",
                    adresse_hospitalier : "",
                    tel_hospitalier : "",
                  
                
              }, 
               hospitaliers :[],
               user:{
                   id:0,
                   email:"",
                   password:"",
               },    
      value: [],
      services: [],
       service: { 
                    id_service : 0,
                    nom_service : "",
                    besoin_service : "",
                    duree_service : "",
                  
                
              }, 
        service_hospitaliers:[],
suppServices :[],
              
          }),
 
      methods: { 
        
           addTag (newTag) {
      const tag = {
        nom_service: newTag,
        //code: newTag
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
      }
      this.options.push(tag)
      this.value.push(tag)
           },
          updateHospitalier(){ 
              console.log("test")
           console.log(this.suppServices);
               
              axios.post('/updateHospitalier',{hospitalier:this.hospitalier,service_hospitaliers:this.value,suppServices:this.suppServices}).then(response => {  
                    console.log(response.data.hospitalier);   
                    console.log('hospitalier Bien ajouter !');
                    this.$router.push({ name: 'ShowHospitaliers', params: { success: "edit"  }});

                  });
            
        },
         getHospitalier(id_hospitalier){
                                              // console.log(this.hospitalier)

                  axios.get('/getHospitalier/'+id_hospitalier).then(
                  response => {
                       
                    this.hospitalier= response.data.hospitalier[0];
                                  console.log(this.hospitalier)
                    this.getService_Hospitalier(this.hospitalier.id_hospitalier);
                  });         
    },
    getService_Hospitalier(id_hospitalier){
    axios.get('/getService_Hospitalier/'+id_hospitalier).then(
                  response => {
                       
                    this.value= response.data.serviceHospitalier;
                    this.loading = false

                                  console.log(this.value)
                    this.modalShow = !this.modalShow

                  });
   },
getServicesS(){
                  axios.get('/getServicesS').then(
                  response => {
                       
                    this.services= response.data.services;
                                  console.log(this.services)

                  });         
    },
 
           spliceService(removedOption,id){
            this.services.splice(id, 1);
                        this.suppServices.push(removedOption);
                        console.log('supp ----------');
                        console.log(this.suppServices)
        },  
        
         fetchData () {
      this.loading = true
      this.hospitalier.id_hospitalier=this.$route.params.id_hospitalier;
    console.log(this.hospitalier.id_hospitalier);
    this.getServicesS();
    this.getHospitalier(this.$route.params.id_hospitalier);

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
    
}
    }
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
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
.mr-4{
    margin-right: 0rem!important;
    width:100px;
}
.colBackround{
     background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.infoClient{

    background-color:  #42a5f529;

}
.AdressClient{
    width: 121%;
}

.noteCondition{
    width: 77%;
}
.calculePadding{
    padding-left: 50%;
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