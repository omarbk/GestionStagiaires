<template>
  <div>
          <div class="text-center pull-right" >
    <h2>Ajouter un stagiaire</h2>
    <hr>   
    </div>   
   

<div>
        <form @submit.prevent="addStagiaire">
         <div class="row" > 
         
            <div class="col-md-6">
               

                <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" > Nom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="stagiaire"  v-model="stagiaire.nom_stagiaire">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" > Date de Naissance</label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="stagiaire"  v-model="stagiaire.dateNaissance_stagiaire">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" > Adresse</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="stagiaire"  v-model="stagiaire.adresse_stagiaire">
                    </div>
                </div>
                    <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" >année universitaire</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="stagiaire"  v-model="stagiaire.annee_universitaire_stagiaire">
                    </div>
                </div>
                
            </div> 
            <div class="col-md-6">
               <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" > Prénom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="stagiaire"  v-model="stagiaire.prenom_stagiaire">
                    </div>
                </div>
                

 <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" > Téléphone</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="stagiaire"  v-model="stagiaire.tel_stagiaire">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="stagiaire" class="col-sm-4" >specialite</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="stagiaire"  v-model="stagiaire.specialite_stagiaire">
                    </div>
                </div>
                 <div class="form-group row">

                    <label class="col-sm-4">Photo</label>
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
            stagiaire: { 
                    id_stagiaire : 0,
                    nom_stagiaire : "",
                    prenom_stagiaire : "",
                    photo_stagiaire : "",
                    adresse_stagiaire : "",
                    email_stagiaire : "",
                    tel_stagiaire : "",
                    dateNaissance_stagiaire : "",
                    specialite_stagiaire: "",
                    annee_universitaire_stagiaire: "",	
                    fk_user : 0,
                
              }, 
               stagiaires :[],
               user:{
                   id:0,
                   email:"",
                   password:"",
               },
       
      }),
 
      methods: {
          addTag (newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
      }
      this.options.push(tag)
      this.value.push(tag)
    }, 
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
                        vm.stagiaire.photo_stagiaire = canvas.toDataURL();
                        console.log(vm.stagiaire.photo_stagiaire);
                    }
                        

                   // vm.article.photo_art = e.target.result;
                
                    
                };
                reader.readAsDataURL(file);
            },
         
          addStagiaire(){ 
              console.log("test")
           console.log(this.stagiaire);
               
              axios.post('/addUserStagiaire',{stagiaire:this.stagiaire,user:this.user}).then(response => {  
                    console.log(response.data.user);   
                    console.log('stagiaire Bien ajouter !');
                    this.$router.push({ name: 'ShowStagiaires', params: { success: "add"  }});

                  });
            
        },

 
                     
      },
     

   mounted(){
            this.user=this.$route.params.user;
            this.stagiaire.fk_user=this.$route.params.user.id;
            // this.user.id=this.$route.params.user.id;
            console.log(this.$route.params.user.id)


   }  
       
        
      


    } 
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
.multiselect__content-wrapper{
    max-height: 10px !important;
}
</style>
