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
        <form @submit.prevent="addObjectif">
         <div class="row" > 
            <div class="col-md-9">
               
                <div class="form-group row">
                    <label for="objectif" class="col-sm-3" > Annee</label>
                    <div class="col-sm-6">
  <multiselect v-model="annee" :options="options" :searchable="false" :close-on-select="true" :show-labels="false" placeholder="Selectionner une annee"></multiselect>
                    </div>
                </div>
            
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
                                        <th>Coefficient</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(objectif,index) in objectifs" :key="index">
                                        <input class="form-control"  type="text" v-model="objectif.fk_type_objectif" disabled hidden>
                                      
                                        <th>
                                    <input  class="form-control" type="text"  v-model="objectif.type" disabled >

                                        </th>    
                                       <th><input type="text" class="form-control" id="email" v-model="objectif.objectif" ></th>
                                        <th><input type="number" class="form-control" id="mobile" v-model="objectif.coefficient"></th> 
                                            <th><a @click="spliceObjectif(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
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
    export default{
        

          data: () => ({
             nameFile : "Choose file",
            objectif: { 
                    id_evaluation_objectif : 0,
                    objectif : "",
                    fk_type_objectif : "",
                    annee_objectif:"",
                    coefficient : "",
                    type:"",
                   
                  
                
              },  annee:"",
                value: '',
                options: [1, 2,3,4,5,6,7],
   
               objectifs:[],
            type_objectif:{
                id_type:0,
                type_objectif:"",
            },
            type_objectifs:[],
      }),
 
      methods: { 

    pushObjectif(objectif){
            console.log(this.objectif);
                  this.getTypeObjectif();
            this.objectifs.push({ 
               fk_type_objectif:objectif.fk_type_objectif,
               objectif:objectif.objectif,
               annee_objectif: this.annee,
               coefficient: objectif.coefficient,
               type:objectif.type,
            });
            this.objectif = {
                 id_evaluation_objectif : 0,
                    objectif : "",
                    fk_type_objectif : "",
                    annee_objectif:"",
                    coefficient : "",
                    type:"",
                
              };
            
    },

    spliceObjectif(index){
            this.objectifs.splice(index, 1);
        },

         
          addObjectif(){ 
              console.log("test")
               this.objectif.annee_objectif=this.annee;
                          console.log(this.objectif.annee_objectif);
              axios.post('/addObjectif',{objectifs:this.objectifs}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowObjectifs', params: { success: "add"  }});

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

                   this1.objectif.type = type_objectif.type_objectif;
                                                     console.log(this1.objectif.type) 

                  
                   return
                 
               }

});
    },
  fetchData () { 
        this.loading = true
        this.getTypeObjectifs();

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
</style>