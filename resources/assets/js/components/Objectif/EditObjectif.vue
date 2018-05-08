<template>
  <div>
          <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les objectifs-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowObjectifs'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Ajouter un Objectif</h2>
    <hr>   
    </div>   
   

<div >
        <form @submit.prevent="updateObjectif">
         <div class="row" > 
         
            <div class="col-md-9">
               <!--
                <div class="form-group row">
                    <label for="objectif" class="col-sm-3" > Coefficient</label>
                    <div class="col-sm-6">
                    <input type="number" class="form-control" id="objectif"  v-model="objectif.coefficient">
                    </div>
                </div>
                -->
            </div> 
    </div>

   
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Type Objectif</th>
                                        <th>Objectif</th>
                                        <th>Annee Objectif</th>                                       
                                        <th>Coefficient</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr >
                                        <input class="form-control"  type="text" v-model="objectif.fk_type_objectif" disabled hidden>
                                        <th>
                                    <input  class="form-control" type="text"  v-model="objectif.type_objectif" disabled >

                                        </th>    
                                       <th><input type="text" class="form-control" id="email" v-model="objectif.objectif" ></th>
                                        <th><input type="number" class="form-control" id="fixe" v-model="objectif.annee_objectif" ></th>
                                        <th><input type="number" class="form-control" id="mobile" v-model="objectif.coefficient"></th> 
                                        </tr>
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
            objectif: { 
                    id_evaluation_objectif : 0,
                    objectif : "",
                    type_objectif : "",
                    coefficient : "",
                    type_objectif:"",
                
              }, 
     
            objectifs :[],
        loading: false,
        error:false,
  }),

  methods:{
   

       // recupere les donnees dans le formulaire
    
   getObjectif(id_evaluation_objectif){

                  axios.get('/getObjectif/'+id_evaluation_objectif).then(
                  response => {
                       
                    this.objectif= response.data.objectif[0];
                    
                    this.loading = false
                    console.log(response.data.objectif)
                  });         
    },
    updateObjectif(){
            axios.post('/updateObjectif',{objectif:this.objectif})
            .then(response => {  
 
                    if(response.data.etat){
                      this.$router.push({ name: 'ShowObjectifs', params: { success: "edit"  }});

                    }
                })
                .catch(error => {
                })
    },

      fetchData () {
        this.loading = true
        this.objectif.id_evaluation_objectif=this.$route.params.id_evaluation_objectif;
      console.log(this.$route.params.id_evaluation_objectif)
      this.getObjectif(this.objectif.id_evaluation_objectif); 

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