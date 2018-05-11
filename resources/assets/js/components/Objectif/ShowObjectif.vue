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
  <h3> {{annee}}  </h3>

<div >
        <form @submit.prevent="updateObjectif">
        

   
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Type Objectif</th>
                                        <th>Objectif</th>
                                        <th>Coefficient</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="objectif of objectifs" :key="objectif.id_evaluation_objectif" >
                                        <input class="form-control"  type="text" v-model="objectif.fk_type_objectif" disabled hidden>
                                        <th>
                                            {{objectif.type_objectif}}
                                        </th>    
                                       <th> {{objectif.objectif}}</th>
                                        <th>{{objectif.coefficient}}</th> 

                                        </tr>
                                       
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
            objectif: { 
                    id_evaluation_objectif : 0,
                    objectif : "",
                    type_objectif : "",
                    coefficient : "",
                    type_objectif:"",
                
              }, 
     annee:"",
            objectifs :[],
            type_objectifs:[],
            type:{
              type_objectif:"",
            },
            suppObjectifs:[],
        loading: false,
        error:false,
  }),

  methods:{


       // recupere les donnees dans le formulaire
    
   getObjectif(annee_objectif){

                  axios.get('/getObjectif/'+annee_objectif).then(
                  response => {
                       
                    this.objectifs= response.data.objectifs;
                    
                    this.loading = false
                    console.log(response.data.objectifs)
                  });         
    },
 
 
      getTypeObjectif(){
       // console.log('-------- type_objectifs ');
         //  console.log();
         let this1=this;
           this.type_objectifs.forEach(function(type_objectif) {
               console.log('**** type_objectif ***') 
               if(type_objectif.id_type == this1.objectif.fk_type_objectif){
                   console.log('-------- type_objectifs ');

                   this1.type.type_objectif = type_objectif.type_objectif;
                                                     console.log(this1.objectif.type_objectif) 

                  
                   return
                 
               }

});
    },


      fetchData () {
        this.loading = true
        this.objectif.annee_objectif=this.$route.params.annee_objectif;
         this.annee=this.$route.params.annee_objectif;
      console.log( this.objectif.annee_objectif)

      this.getObjectif( this.objectif.annee_objectif); 

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