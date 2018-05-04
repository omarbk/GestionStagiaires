<template>
  <div>
          <div class="text-center pull-right" >
    <h2>Ajouter un Evaluateur</h2>
    <hr>   
    </div>   
   

<div>
        <form @submit.prevent="updateEvaluateur">
         <div class="row" > 
         
            <div class="col-md-6">
               

                <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Nom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="evaluateur"  v-model="evaluateur.nom_evaluateur">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Date de Naissance</label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="evaluateur"  v-model="evaluateur.dateNaissance_evaluateur">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Adresse</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="evaluateur"  v-model="evaluateur.adresse_evaluateur">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Specialite</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="evaluateur"  v-model="evaluateur.specialite_evaluateur">
                    </div>
                </div>

                <div class="form-group row">
  <label class="typo__label col-sm-4">Centre</label>
   <div class="col-sm-8">
  <multiselect v-model="evaluateur" :options="hospitaliers" :searchable="false" :close-on-select="true" :show-labels="true" label="nom_hospitalier" placeholder="Selectionner un hospitalier"></multiselect>
  <pre class="language-json"><code>{{ evaluateur  }}</code></pre>
   </div>
</div>
            </div> 
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Prénom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="evaluateur"  v-model="evaluateur.prenom_evaluateur">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Téléphone</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="evaluateur"  v-model="evaluateur.tel_evaluateur">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Service</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="evaluateur"  v-model="evaluateur.service_evaluateur">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="evaluateur" class="col-sm-4" > Type</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="evaluateur"  v-model="evaluateur.type_evaluateur">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="RC" class="col-sm-4" >Photo </label>
                    <div class="col-sm-8">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" v-on:change="onImageChange">
                        <label class="custom-file-label" for="inputGroupFile01">{{fileName}}</label>
                    </div>
                    </div>
                </div>
                     <button  class="btn mb-3 float-right btn-success">Enregister</button>

              </div>
         
    </div>

     </form>
</div>

  </div>
</template>
<script>
    



    export default{
        

          data: () => ({
             fileName : "Choose file",
            evaluateur: { 
                    id_evaluateur : 0,
                    nom_evaluateur : "",
                    prenom_evaluateur : "",
                    photo_evaluateur : "",
                    adresse_evaluateur : "",
                    email_evaluateur : "",
                    tel_evaluateur : "",
                    dateNaissance_evaluateur : "",
                    service_evaluateur : "",
                    specialite_evaluateur:"",
                    type_evaluateur:"",
                    fk_hospitalier:"",
                    fk_user : 0,
                   // value:[],
                
              }, 
               evaluateurs :[],
               user:{
                   id:0,
                   email:"",
                   password:"",
               },
               hospitaliers:[],
               hospitalier: {
                   id_hospitalier:"",
                   nom_hospitalier:"",
               }
               
      }),
 
      methods: { 
           onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.fileName=files[0].name;
                if (!files.length)
                    return;
                this.createImage(files[0]);
    },

    createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.evaluateur.photo_evaluateur = e.target.result;
    };
                reader.readAsDataURL(file);
    },
         getHospitaliersH(){
                  axios.get('/getHospitaliersH').then(
                  response => {
                       
                    this.hospitaliers= response.data.hospitaliers;
                    console.log("hosp-----")
                                  console.log(this.hospitaliers)

                  });         
    },
    getEvaluateur(id_evaluateur){
                  axios.get('/getEvaluateur/'+id_evaluateur).then(
                  response => {
                       
                    this.evaluateur= response.data.evaluateur[0];
                    this.fileName= response.data.evaluateur[0].photo_evaluateur;
                   // this.value=response.data.evaluateur[0];
                    console.log("eval-----")
                                  console.log(response)

                    this.modalShow = !this.modalShow
                  });         
    },
          updateEvaluateur(){ 
              console.log("test")
           console.log(this.evaluateur);
               
              axios.post('/updateEvaluateur',{evaluateur:this.evaluateur}).then(response => {  
                    console.log(response.data.evaluateur);   
                    console.log('evaluateur Bien ajouter !');
                    this.$router.push({ name: 'ShowEvaluateurs', params: { success: "edit"  }});

                  });
            
        },

 
                     
      },
     

   mounted(){
            this.evaluateur.id_evaluateur=this.$route.params.id_evaluateur;
            // this.user.id=this.$route.params.user.id;
            console.log(this.evaluateur.id_evaluateur)
            this.getEvaluateur(this.evaluateur.id_evaluateur);
                        this.getHospitaliersH();



   }  
       
        
      


    }
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
