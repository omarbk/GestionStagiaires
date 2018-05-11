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
    <!-- button pour afficher tous les users-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowEvaluateurs'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Modifier Evaluateurs</h2>
    </div>
    <hr>

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
  <multiselect v-model="hospitalier" :options="hospitaliers" :searchable="false" :close-on-select="true" :show-labels="true" label="nom_hospitalier" placeholder="Selectionner un hospitalier" required></multiselect>
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
  </div>
</template>
<script>
    



    export default{
        

          data: () => ({
            fileName : "Choose file",
            loading: false,
            error:false,
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
               },
               eval:[],
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

                    this.hospitalier= response.data.evaluateur[0];
                    this.fileName= response.data.evaluateur[0].photo_evaluateur;
                    this.loading = false
                    console.log("eval-----")
                                  console.log(response)

                    this.modalShow = !this.modalShow
                  });         
    },
          updateEvaluateur(){ 
              console.log("test")
           console.log(this.evaluateur);
               
              axios.post('/updateEvaluateur',{evaluateur:this.evaluateur,hospitalier:this.hospitalier}).then(response => {  
                    console.log(response.data.evaluateur);   
                    console.log(response.data.hospitalier);   

                    console.log('evaluateur Bien ajouter !');
                    this.$router.push({ name: 'ShowEvaluateurs', params: { success: "edit"  }});

                  });
            
        },

   fetchData () {
        this.loading = true
        this.evaluateur.id_evaluateur=this.$route.params.id_evaluateur;
        console.log(this.evaluateur.id_evaluateur)
        this.getEvaluateur(this.evaluateur.id_evaluateur);
        this.getHospitaliersH();

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
            this.evaluateur.id_evaluateur=this.$route.params.id_evaluateur;
            // this.user.id=this.$route.params.user.id;
            console.log(this.evaluateur.id_evaluateur)
            this.getEvaluateur(this.evaluateur.id_evaluateur);
                        this.getHospitaliersH();



   }  
       
        
      


    }
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
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
