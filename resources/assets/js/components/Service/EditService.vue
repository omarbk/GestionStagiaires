<template>
 <div>
         <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
  <div>
 
     <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowServices'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Modifier Service</h2>
    </div>
    <hr>
  <!-- formulaire pour modifier un user -->
  <div class="body">
          <form   @submit.prevent="updateService">


   <div class="row" > 
         
              <div class="col-md-9">
                <div class="form-group row">
                    <label for="service" class="col-sm-3" > Nom de Service</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="service"  v-model="service.nom_service">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="service" class="col-sm-3" > Besoin</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="service"  v-model="service.besoin_service">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="service" class="col-sm-3" > Durée(Nb Semaine)</label>
                    <div class="col-sm-6">
                    <input type="number" class="form-control" id="service"  v-model="service.duree_service">
                    </div>
                </div>
            </div> 
    </div>
 


    <button  class="btn btn-success " >Modifier</button>
          </form>
</div>
</div>
</div>
  <!-- fin formulaire -->
 </div>
</template>

<script>
export default {
  
  data : () => ({
       fileName : "Choose file",
            service: { 
                    id_service : 0,
                    nom_service : "",
                    besoin_service : "",
                    duree_service : "",
                
              }, 
            
            services :[],
        loading: false,

  }),

  methods:{
   

       // recupere les donnees d'un user dans le formulaire
    
   getService(id_service){
                 //console.log(id_service)

                  axios.get('/getService/'+id_service).then(
                  response => {
                       
                    this.service= response.data.service[0];
                    this.loading = false
console.log(response.data.service)
                    this.modalShow = !this.modalShow
                  });         
    },
    updateService(){
            axios.post('/updateService',{service:this.service})
            .then(response => {  
 
                    if(response.data.etat){
                        this.$router.push('/ShowServices/edit');
                    }
                })
                .catch(error => {
                })
    },

      fetchData () {
      //this.error = this.post = null
      this.loading = true
        this.service.id_service=this.$route.params.id_service;
      console.log(this.$route.params.id_service)
      this.getService(this.service.id_service); 

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