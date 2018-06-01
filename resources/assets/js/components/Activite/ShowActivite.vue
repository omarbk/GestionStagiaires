<template>
  <div>
          <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les activites-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowActivites'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
     <a href="#"    @click="PDFActivite(niveau_etude)"  class="btn btn-secondary mb-3  float-right" ><i class="far fa-file-pdf"></i></a>

        </div>
  
    </div>
    <h2>Details des Activites</h2>
    <hr>   
    </div>   
  <h3> {{niveau}}  </h3>

<div >
        <form @submit.prevent="updateActivite">
        

   
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                     <thead>
                                        <div v-for="(type_activite,index) in type_activites" :key="index" >
                 <br>
                  <h4> <span style="color: #42a5f5;"> {{index+1}}. {{type_activite.type_activite}} </span></h4>

                                    <tr>
                                    <th>activites</th>
                                    
                                    </tr> 
      <tr v-for="(activite,index) in activites" v-if="activite.type_activite===type_activite.type_activite" :key="index" >
                               
                              
                                 <th> {{activite.nom_activite}}</th>
                              
                          </tr>
                    
           
                                        </div>
                                    </thead>
                                    <tbody>
                                       
                                      </tbody>
                                </table>
                            </div>
             </div>

     </div>

          </form>
</div>
  </div>
</template>

<script>
export default {
  
  data : () => ({
       fileName : "Choose file",
            activite: { 
                    id_activite : 0,
                    nom_activite : "",
                 
                
              }, 
     niveau:"",
            activites :[],
            type_activites:[],
            type_activite:{
              type_activite:"",
            },
          niveauPdf:{},

        loading: false,
        error:false,
  }),

  methods:{
 PDFActivite(niveau_etude){
          
          window.open('/PDFActivite/'+this.$route.params.niveau_etude
+'','_blank');
    }, 

       // recupere les donnees dans le formulaire
    
   getActivite(niveau_etude){

                  axios.get('/getActivite/'+niveau_etude).then(
                  response => {
                       
                    this.activites= response.data.activites;
                    
                    this.loading = false
                    console.log(response.data.activites)
                  });         
    },
 
  getTypeActivites(niveau_etude){
           axios.get('/getTypeActivites/'+niveau_etude)
            .then((response) => {
                console.log(response.data.listeTypeActivites);
                    this.type_activites = response.data.listeTypeActivites;
                  //this.loading= false;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
 },
  /*    getTypeActivite(){
       // console.log('-------- type_activites ');
         //  console.log();
         let this1=this;
           this.type_activites.forEach(function(type_activite) {
               console.log('**** type_activite ***') 
               if(type_activite.type_activite == this1.activite.type_activite){
                   console.log('-------- type_activites ');

                   this1.type_activite.type_activite = type_activite.type_activite;
                                                     console.log(this1.activite.type_activite) 

                  
                   return
                 
               }

});
    },*/


      fetchData () {
        this.loading = true
        this.activite.niveau_etude=this.$route.params.niveau_etude;
                this.niveauPdf = this.$route.params.niveau_etude;

         this.niveau=this.$route.params.niveau_etude;
      console.log( this.activite.niveau_etude)
        this.getTypeActivites(this.activite.niveau_etude);

      this.getActivite(this.activite.niveau_etude); 

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
 a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
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