<template>
        <div>
           <div class="row">
               <div class="col-3">
               <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  
                <button @click="testAffich.testTypeObjectif = true;testAffich.testfamille = false;testAffich.testTVA=false;testAffich.testStatus = false" class="btn btn-primary mb-3 shadawButton ">Type Objectif</button>
                </div>
               </div>
                <div class="col">
                   
                     <div v-if="testAffich.testStatus"> 
                    <div class="row">
                        <div class="col">
                    <input v-model="statu.type_status"  type="text"  placeholder="Entrez Statut">
                    </div>
                    <div class="col">
                    <input type="color" id="html5colorpicker" style="height: 37px;width:150px" v-model="statu.colorStatu">
                    </div>
                    <div class="col">
                     <button @click="addStatu" class="btn btn-success">Ajouter </button>
                     </div>
                   </div>
                
                    




                    
                    <div class="row">
                       <table class="table table-bordered tableau">
                        <thead>
                            <tr>
                            <th>Status documents</th>
                            </tr>
                        </thead>
                        <tbody>                     
                            <tr v-for="statu in status" :key="statu.id_status">
                            <th>{{statu.type_status}}</th>      
                            <th><a @click="deleteStatu(statu)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                        </tbody>
                       </table>
                     </div>  
                     </div>


                      <div> 
                    <div class="row">
                        <div class="col">
                    <input v-model="typeObjectif.type_objectif"  type="text"  placeholder="Entrez Type objectif">
                    </div>
                    <div class="col">
                     <button @click="addTypeObjectif" class="btn btn-success">Ajouter </button>
                     </div>
                   </div>             
                    <div class="row">
                       <table class="table table-bordered tableau">
                        <thead>
                            <tr>
                            <th>Type de objectif</th>
                            </tr>
                        </thead>
                        <tbody>                     
                            <tr v-for="typeObjectif in typeObjectifs" :key="typeObjectif.id_type">
                            <th>{{typeObjectif.type_objectif}}</th>      
                            <th><a @click="deleteTypeObjectif(typeObjectif)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                        </tbody>
                       </table>
                     </div>  
                     </div>
                </div>
            </div>        


           </div>
       


</template>

<script>
    export default {
  
  data : () => ({
      colorStatu:"#ff0000",
        testAffich:{
            testfamille:true,
            testTVA:false,
            testStatus:false,
            testTypeObjectif:false,
        },
        famille_article:{
            id_famille : 0,
            libelle_famille : ""
        },
        famille_articles:[],

        tva:{
            id_tva : 0,
            taux_tva : ""
        },
        tvas:[],

        statu:{
            id_status : 0 ,
            type_status : "",
            colorStatu : "",
        },
        status:[],
         typeObjectif:{
            id_type: 0,
            type_objectif: "",
          },
          typeObjectifs: [],
          }),
    
        
          mounted(){
                this.getfamilles();
                this.getTvas();
                this.getStatus();
                this.getTypeObjectifs();
          },
        methods:{
                //-------------------------------------- famille
            addFamille(){
                  axios.post('/addFamille',this.famille_article).then(response => {     
                      this.getfamilles();    
                    console.log('famille Bien ajouter !');
                  });
            },
 
        getfamilles(){
                axios.get('/getfamilles')
                .then((response) => {
                 // console.log('shit');
                    this.famille_articles = response.data.famille_articles;
                    
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                       deleteFamille(famille){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deletefamille/'+famille.id_famille).then(
                                        response => {
                                
                                            this.getfamilles();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre categorie a été supprimé',
                        'success'
                        )
                        }
                        })
                        },
            //-------------------------------------- tva 
                addTva(){
                  axios.post('/addTva',this.tva).then(response => {     
                     this.getTvas();
                    console.log('famille Bien ajouter !');
                  });
            },
                getTvas(){
                axios.get('/getTvas')
                .then((response) => {
                  //console.log(response.data);
                    this.tvas= response.data.tvas;
                  //  console.log(this.tvas);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                                 deleteTva(tva){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteTva/'+tva.id_tva).then(
                                        response => {
                                
                                            this.getTvas();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre tva a été supprimé',
                        'success'
                        )
                        }
                        })
                        },
                        //-------------------------------------- status
            addStatu(){
                console.log('-------- color ')
                console.log(this.colorStatu);
                axios.post('/addStatu',this.statu).then(response => {     
                    this.getStatus();
                    console.log('status Bien ajouter !');
                  });
            },
            getStatus(){
                axios.get('/getStatus')
                .then((response) => {
                  console.log(response.data);
                    this.status= response.data.status;
                   // console.log(this.tvas);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                    deleteStatu(statu){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteStatu/'+statu.id_status).then(
                                        response => {
                                            console.log('statut bien supprimer');
                                            this.getStatus();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre statut a été supprimé',
                        'success'
                        )
                        }
                        })
                        },

// type objectif
                        addTypeObjectif(){
                                axios.post('/addTypeObjectif',this.typeObjectif).then(response => {     
                            this.getTypeObjectifs();
                            console.log('Type objectif Bien ajouter !');
                                });
                        },
                        getTypeObjectifs(){
                            axios.get('/getTypeObjectifs')
                            .then((response) => {                        
                                this.typeObjectifs= response.data.listeTypeObjectifs;
                            })
                            .catch(() => {
                                console.log('handle server error from here');
                            });
          },
              deleteTypeObjectif(typeObjectif){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteTypeObjectif/'+typeObjectif.id_type).then(
                                        response => {
                                
                                           this.getTypeObjectifs();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre Type objectif a été supprimé',
                        'success'
                        )
                        }
                        })
                        },




},
    }
</script>
<style scoped>
    .shadawButton:hover {
  box-shadow: 1px 1px 1px 1px #888888;
    }
    .tableau{
    margin-top: 30px;
    }
</style>