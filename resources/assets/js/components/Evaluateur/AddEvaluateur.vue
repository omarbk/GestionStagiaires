<template>
  <div>
            <notifications group="foo" 
      position="bottom right"/>

         <div class="text-center pull-right" >
                  <div class=" btnMarge">
        <div class="col">
    <!-- button pour afficher tous les users-->
    <router-link class="btn btn-primary mb-3 retour float-right " :to="'/ShowServices'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
  
    </div>
    <h2>Ajouter un Evaluateur</h2>
    <hr>   
    </div>   
   

<div>
        <form @submit.prevent="addEvaluateur">
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
                        <label class="custom-file-label" for="inputGroupFile01">{{nameFile}}</label>
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
             nameFile : "Choose file",
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
                    value:[],
                
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
      }),
 
      methods: { 
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                this.nameFile = files[0].name;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                
                
                
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                        var image = new Image();
                       image.src=e.target.result;
                         //console.log("okkkkk111 : "+image.src.length)
                        image.onload=function(){
                        //console.log("test222222");
                        //document.getElementById("original-Img").src=image.src;
                       // console.log("taille width : "+image.width)
                         console.log("taille size : "+image.src.length)
                         //console.log("taille width : "+image.height)

                        var canvas=document.createElement("canvas");
                        var context=canvas.getContext("2d");
                        if(image.src.length > 1000000){
                            
                        canvas.width=image.width/8; 
                        canvas.height=image.height/8;
                        }
                        else {
                         canvas.width=image.width; 
                        canvas.height=image.height;}
                        //console.log("canvas.width : "+canvas.width)
                        context.drawImage(image,
                            0,
                            0,
                            image.width,
                            image.height,
                            0,
                            0,
                            canvas.width,
                            canvas.height
                        );
                        console.log("size 2 : "+canvas.toDataURL().length)
                        vm.evaluateur.photo_evaluateur = canvas.toDataURL();
                        console.log(vm.evaluateur.photo_evaluateur);
                    }
                        

                   // vm.article.photo_art = e.target.result;
                
                    
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
          addEvaluateur(){ 
              console.log("test")
           console.log(this.hospitalier);
               if(this.hospitalier.nom_hospitalier === ""){
                               this.$notify({
                                      group: 'foo',
                                      title: 'Champs vide',
                                      text: 'Ajouter hospitalier!',
                                      duration: 1500,
                                    });
               }
               else {
              axios.post('/addUserEvaluateur',{evaluateur:this.evaluateur,hospitalier:this.hospitalier,user:this.user}).then(response => {  
                    console.log(response.data.user);   
                    console.log('evaluateur Bien ajouter !');
                    this.$router.push({ name: 'ShowEvaluateurs', params: { success: "add"  }});

                  });}
            
        },

 
                     
      },
     

   mounted(){
            this.user=this.$route.params.user;
            this.evaluateur.fk_user=this.$route.params.user.id;
            // this.user.id=this.$route.params.user.id;
            console.log(this.$route.params.user.id)
            this.getHospitaliersH();


   }  
       
        
      


    }
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
