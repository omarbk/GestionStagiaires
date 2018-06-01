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
                                    <tr  v-for="(objectif,index) of objectifs" :key="objectif.id_evaluation_objectif" >
                                        <input class="form-control"  type="text" v-model="objectif.fk_type_objectif" disabled hidden>
                                        <th>
                                    <input  class="form-control" type="text"  v-model="objectif.type_objectif" disabled >

                                        </th>    
                                       <th><input type="text" class="form-control" id="email" v-model="objectif.objectif" ></th>
                                        <th><input type="number" class="form-control" id="mobile" v-model="objectif.coefficient"></th> 
                                        <th><a @click="spliceObjectif(index,objectif)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>

                                        </tr>
                                       
                                       
                                         <th>
                                            <div> 
                                                <select class="custom-select " id="fk_type_objectif" v-model="objectif.fk_type_objectif" >
                                                 <option selected disabled>Choisir Type Objectif</option>
                                                <option v-for="type_objectif in type_objectifs" :key="type_objectif.id_type" :value="type_objectif.id_type">{{type_objectif.type_objectif}}</option>
                                                </select>                                                                     
                                            </div>
                                        </th>                                        
                                         <th><a    @click="pushObjectif(objectif)"  class="btn btn-success"  ><i class="fas fa-plus-circle"></i></a></th>
                                   
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
   async pushObjectif(objectif){
            console.log(this.objectif);
              var result = await this.getTypeObjectif();
          var result2 = await this.objectifs.push({ 
               fk_type_objectif:objectif.fk_type_objectif,
               objectif:objectif.objectif,
               annee_objectif: this.annee,
               coefficient: objectif.coefficient,
               type_objectif:objectif.type_objectif,
            });
            this.objectif = {
                 id_evaluation_objectif : 0,
                    objectif : "",
                    fk_type_objectif : "",
                    annee_objectif:"",
                    coefficient : "",
                    type_objectif:"",
                
              };
            
    },

    spliceObjectif(index,objectif){
            this.objectifs.splice(index, 1);
            this.suppObjectifs.push(objectif);

        },

       // recupere les donnees dans le formulaire
    
   getObjectif(annee_objectif){

                  axios.get('/getObjectif/'+annee_objectif).then(
                  response => {
                       
                    this.objectifs= response.data.objectifs;
                    
                    this.loading = false
                    console.log(response.data.objectifs)
                  });         
    },
    getTypeObjectifs(){
           axios.get('/getTypeObjectifs')
            .then((response) => {
                console.log(response.data.listeTypeObjectifs);
                    this.type_objectifs = response.data.listeTypeObjectifs;
                  this.loading= false;
            })
            .catch(() => {
                    console.log('handle server error from here');
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

                   this1.objectif.type_objectif = type_objectif.type_objectif;
                                                     console.log(this1.objectif.type_objectif) 

                  
                   return
                 
               }

});
    },
    updateObjectif(){
            axios.post('/updateObjectif',{objectifs:this.objectifs,suppObjectifs:this.suppObjectifs})
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
        this.objectif.annee_objectif=this.$route.params.annee_objectif;
         this.annee=this.$route.params.annee_objectif;
      console.log( this.objectif.annee_objectif)
              this.getTypeObjectifs();

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