<template>
  <div>


    <div class="loading" v-if="loading">
     <div class="lds-hourglass"></div>
    </div>
    

<div v-if="!loading">
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowGroupes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
     <div class=" container colBackround">


<div class="row">
    <div class="col">
        <br>
    <h5><i class="fas fa-address-book"></i> {{groupe.nom_groupe}}  </h5>
    </div>
</div>
<hr>
    
        <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                
                <p class="card-text">
                   
                   <span>Nom groupe : </span>{{groupe.nom_groupe}}
                    <hr>
                    <span>année Universitaire : </span>{{groupe.annee_universitaire_groupe}}
                   
                   
                </p>
                
            </div>
            </div>
        </div>
        <div class="col-sm-6">
           <ul class="list-group">
            <li class="list-group-item active">Liste des stagiaires</li>
            <li class="list-group-item" v-for="(Vgroupe_stagiaire,index) in groupe_stagiaire" :key="index">{{Vgroupe_stagiaire.nom_stagiaire}} {{Vgroupe_stagiaire.prenom_stagiaire}}</li>
           
            </ul>
        </div>
   
        </div>
    <div class="row">
    <div class="col">
        <br>
    <h5><i class="fas fa-calendar-alt"></i> Calendrier  </h5>
    </div>
</div>
<hr>
   <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr class="trJour">
                                       <th> </th>
                                        <th>Semaine</th>
                                        <th>Lundi</th>
                                        <th>Mardi</th>                                       
                                        <th>Mercredi</th>
                                        <th>Jeudi</th>
                                        <th>Vendredi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(calendrier,index) in calendriers" :key="index">
                                             <th>
                                            <label for="">{{calendrier.nomMoisDebut}}</label>
                       
                                            </th>
                                            <th>
                                             
                                             
                                               <label for="">Du {{calendrier.debut_semaine_cal}} {{calendrier.nomMoisDebut}} au {{calendrier.fin_semaine_cal}} {{calendrier.nomMoisFin}}</label>
                                             

                                           
                                            
                                          </th>
                                          <th><input type="text" readonly class="form-control sizeJour" v-model="calendrier.lundi_cal"></th>
                                          <th><input type="text" readonly  class="form-control sizeJour" v-model="calendrier.mardi_cal"></th>
                                          <th><input type="text"  readonly class="form-control sizeJour" v-model="calendrier.mercredi_cal"></th>
                                          <th><input type="text" readonly  class="form-control sizeJour" v-model="calendrier.jeudi_cal"></th>
                                          <th><input type="text" readonly   class="form-control sizeJour" v-model="calendrier.vendredi_cal"></th>
                                            
                                      
                                        </tr>
                                        
                                        
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
             </div>
     </div>
  </div>
   <br>
 
   </div>
  </div>
</template>
<script>



      export default{ 
    
          data: () => ({
               loading: false,
              groupe:{
            id_groupe:0,
            nom_groupe: "",
            annee_universitaire_groupe:""     
            },
calendriers: [],
groupe_stagiaire: [],

          }),
  
          methods:{
 fetchData () {
                    
                console.log(this.$route.params.id_groupe)
               this.getGroupe(this.$route.params.id_groupe);
               this.getCalendriers(this.$route.params.id_groupe);
             
 },
      
       
           getGroupe:function(id_groupe){
                            axios.get('/getGroupe/'+id_groupe).then(
                            response => {
                                

                                this.groupe= response.data.groupe;
                                this.groupe_stagiaire = response.data.groupe_stagiaire;
                                console.log('liste stagiaire')
                                console.log(this.groupe_stagiaire)
                                console.log('grouppppe')
                                console.log(this.groupe);
                            });     
                    },
            getCalendriers:function(id_groupe){
                    console.log('-------------------idGroupe-----------');
                                console.log(id_groupe);
                            axios.get('/getCalendriers/'+id_groupe).then(
                            response => {
                                
                                this.calendriers= response.data.calendriers;
                                
                                console.log('-------------------calendriers-----------');
                                console.log(response);
                            });     
                    },
        
        
          },

          created(){
              this.fetchData()
          },

      }
</script>
<style scoped>
.card-header{
    background-color: #cac8c8;
}
span{
    color:#007ee4;
}
.fontsize{

    font-size: 1.30rem;
}
a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.colBackround{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}


.colBackround2{
    background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.colBackround3{
    background-color: #d8edff;
    padding-left:  0px;
    margin-left:  0px;
    padding-right: 0px;
}
.badgeSize{
    font-size: 14px;
}
.trJour{

    background-color: #b6dfff;

}
.sizeJour{
    width: 42px;
    min-width: 70px;
 }
 .list-group-item.active{

     background-color:#d4eddb;
     border-color:#d4eddb;
     color:#272727;
 }
</style>
