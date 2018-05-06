
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
    <!-- button pour afficher tous les responsables-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/showResponsables'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Modifier Responsable</h2>
    <hr>
    </div>
  <!-- formulaire pour modifier un responsable -->
          <form   @submit.prevent="updateResponsable">


   <div class="row" > 
         
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Nom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="nom"  v-model="responsable.nom_responsable">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Date de Naissance</label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="dateN"  v-model="responsable.dateNaissance_responsable">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Adresse</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="adresse"  v-model="responsable.adresse_responsable">
                    </div>
                </div>
            </div> 
            <div class="col-md-6">
               <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Prénom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="prenom"  v-model="responsable.prenom_responsable">
                    </div>
                </div>

 <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Téléphone</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="tel"  v-model="responsable.tel_responsable">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Service</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="service"  v-model="responsable.service_responsable">
                    </div>
                </div>

 
              </div>
            <div class="col-md-12">

                <div class="form-group row ">
                    <label for="RC" class="col-sm-2" >Photo </label>
                    <div class="col-sm-10">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" v-on:change="onImageChange">
                        <label class="custom-file-label" for="inputGroupFile01">{{fileName}}</label>
                    </div>
                    </div>
                </div>
            </div>
    </div>
 


    <button  class="btn btn-success float-right " >Modifier</button>
          </form>
</div>
</div>

  <!-- fin formulaire -->
 </div>
</template>

<script>
export default {
  
  data : () => ({
        fileName : "Choose file",
        loading: false,

            responsable: { 
                    id_responsable : 0,
                    nom_responsable : "",
                    prenom_responsable : "",
                    photo_responsable : "",
                    adresse_responsable : "",
                    tel_responsable : "",
                    dateNaissance_responsable : "",
                    service_responsable : "",
                    fk_user : 0,
                    
                    email:"",
                    password:"",
                    role:"",
                
              }, 
               responsables :[],
  
  }),

  methods:{
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
                    vm.responsable.photo_responsable = e.target.result;
    };
                reader.readAsDataURL(file);
    },
    

       // recupere les donnees d'un responsable dans le formulaire
    
    getResponsable(id_responsable){
                  axios.get('/getResponsable/'+id_responsable).then(
                  response => {
                       
                    this.responsable= response.data.responsable[0];
                    this.fileName= response.data.responsable[0].photo_responsable;
                    this.loading = false

                    console.log(response.data.responsable)
                    this.modalShow = !this.modalShow
                  });         
    },
    updateResponsable(){
            axios.post('/updateResponsable',{responsable:this.responsable})
            .then(response => {  
 
                    if(response.data.etat){
                        this.$router.push('/ShowResponsables/edit');
                    }
                })
                .catch(error => {
                })
    },
  fetchData () {
      this.loading = true
      this.responsable.id_responsable=this.$route.params.id_responsable;
      console.log(this.$route.params.id_responsable)
      this.getResponsable(this.responsable.id_responsable);

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
               
    },

}
</script>
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
