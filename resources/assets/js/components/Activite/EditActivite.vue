<template>
  <div>
          <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les activites-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowActivites'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Modifier une Activite</h2>
    <hr>   
    </div>   
  <h3> {{niveau}} </h3>

<div >
        <form @submit.prevent="updateActivite">
        

   
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Type Activite</th>
                                        <th>Activite</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(activite,index) of activites" :key="activite.id_activite" >
                                        <input class="form-control"  type="text" v-model="activite.type_activite" disabled hidden>
                                        <th>
                                    <input  class="form-control" type="text"  v-model="activite.type_activite" disabled >

                                        </th>    
                                       <th><input type="text" class="form-control" id="email" v-model="activite.nom_activite" ></th>
                                        <th><a @click="spliceActivite(index,activite)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>

                                        </tr>
                                       
                                       <th><input type="text" class="form-control" id="civilite"  v-model="activite.type_activite"></th>
                                        <th><input type="text" class="form-control" id="prenom"  v-model="activite.nom_activite"></th>
                                         <th><a    @click="pushActivite(activite)"  class="btn btn-success"  ><i class="fas fa-plus-circle"></i></a></th>
                                                                          
                                   
                                      </tbody>
                                </table>
                            </div>
             </div>

     </div>
                       <button  class="btn mb-3  btn-success">Enregister</button>

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
                    type_activite : "",
                    niveau_etude : "",
                
              }, 
     niveau:"",
            activites :[],
            
            suppActivites:[],
        loading: false,
        error:false,
  }),

  methods:{
   async pushActivite(activite){
            console.log(this.activite);
          var result2 = await this.activites.push({ 
               type_activite:activite.type_activite,
               nom_activite:activite.nom_activite,
               niveau_etude: this.niveau,

            });
            this.activite = {
                 id_activite : 0,
                    activite : "",
                    type_activite : "",
                    niveau_etude:"",

                
              };
            
    },

    spliceActivite(index,activite){
            this.activites.splice(index, 1);
            this.suppActivites.push(activite);

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

 
    updateActivite(){
            axios.post('/updateActivite',{activites:this.activites,suppActivites:this.suppActivites})
            .then(response => {  
 
                    if(response.data.etat){
                      this.$router.push({ name: 'ShowActivites', params: { success: "edit"  }});

                    }
                })
                .catch(error => {
                })
    },

      fetchData () {
        this.loading = true
        this.niveau_etude=this.$route.params.niveau_etude;
         this.niveau=this.$route.params.niveau_etude;
      console.log( this.activite.niveau_etude)

      this.getActivite( this.niveau_etude); 

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