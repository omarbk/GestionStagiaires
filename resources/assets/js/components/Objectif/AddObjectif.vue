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
   

<div class="body">
        <form @submit.prevent="addObjectif">
         <div class="row" > 
         
            <div class="col-md-9">
               

                <div class="form-group row">
                    <label for="objectif" class="col-sm-3" > Objectif</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="objectif"  v-model="evaluationObjectif.objectif">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="objectif" class="col-sm-3" > Type Objectif</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="objectif"  v-model="evaluationObjectif.type_objectif">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="objectif" class="col-sm-3" > Coefficient</label>
                    <div class="col-sm-6">
                    <input type="number" class="form-control" id="objectif"  v-model="evaluationObjectif.coefficient">
                    </div>
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
            evaluationObjectif: { 
                    id_evaluation_objectif : 0,
                    objectif : "",
                    type_objectif : "",
                    coefficient : "",
                  
                
              }, 
               evaluationObjectifS :[],

      }),
 
      methods: { 
          
         
          addObjectif(){ 
              console.log("test")
           console.log(this.objectif);
               
              axios.post('/addObjectif',{evaluationObjectif:this.evaluationObjectif}).then(response => {  
                    //console.log(response.data.objectif);   
                    console.log('objectif Bien ajouter !');
                    this.$router.push({ name: 'ShowObjectifs', params: { success: "add"  }});

                  });
            
        },

 
                     
      },

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
</style>