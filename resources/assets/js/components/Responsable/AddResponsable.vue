<template>
  <div>
          <div class="text-center pull-right" >
    <h2>Ajouter un Responsable</h2>
    <hr>   
    </div>   
   

<div>
        <form @submit.prevent="addResponsable">
         <div class="row" > 
         
            <div class="col-md-6">
               

                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Nom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="responsable.nom_responsable">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Date de Naissance</label>
                    <div class="col-sm-8">
                    <input type="date" class="form-control" id="responsable"  v-model="responsable.dateNaissance_responsable">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Adresse</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="responsable.adresse_responsable">
                    </div>
                </div>
            </div> 
            <div class="col-md-6">
               <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Prénom</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="responsable.prenom_responsable">
                    </div>
                </div>

 <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Téléphone</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="responsable.tel_responsable">
                    </div>
                </div>
                 <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > Service</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="responsable.service_responsable">
                    </div>
                </div>

 
              </div>
            <div class="col-md-12">

                <div class="form-group row ">
                    <label for="RC" class="col-sm-2" >Photo </label>
                    <div class="col-sm-10">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" v-on:change="onImageChange">
                        <label class="custom-file-label" for="inputGroupFile01">{{nameFile}}</label>
                    </div>
                    </div>
                </div>
            </div>
    </div>
     <button  class="btn mb-3 float-right btn-success">Enregister</button>

     </form>
</div>

  </div>
</template>
<script>
    



    export default{
        

          data: () => ({
             nameFile : "Choose file",
            responsable: { 
                    id_responsable : 0,
                    nom_responsable : "",
                    prenom_responsable : "",
                    photo_responsable : "",
                    adresse_responsable : "",
                    email_responsable : "",
                    tel_responsable : "",
                    dateNaissance_responsable : "",
                    service_responsable : "",
                    fk_user : 0,
                
              }, 
               responsables :[],
               user:{
                   id:0,
                   email:"",
                   password:"",
               }
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
                        vm.responsable.photo_responsable = canvas.toDataURL();
                        console.log(vm.responsable.photo_responsable);
                    }
                        

                   // vm.article.photo_art = e.target.result;
                
                    
                };
                reader.readAsDataURL(file);
            },
         
          addResponsable(){ 
              console.log("test")
           console.log(this.responsable);
               
              axios.post('/addUserResponsable',{responsable:this.responsable,user:this.user}).then(response => {  
                    console.log(response.data.user);   
                    console.log('Responsable Bien ajouter !');
                    this.$router.push({ name: 'ShowResponsables', params: { success: "add"  }});

                  });
            
        },

 
                     
      },
     

   mounted(){
            this.user=this.$route.params.user;
            this.responsable.fk_user=this.$route.params.user.id;
            // this.user.id=this.$route.params.user.id;
            console.log(this.$route.params.user.id)


   }  
       
        
      


    }
    
</script>
