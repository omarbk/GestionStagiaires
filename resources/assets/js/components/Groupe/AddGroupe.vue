<template>
    <div>
      <notifications group="foo" 
      position="bottom right"/>
    <div class="row">
        <div class="col">
        <router-link class="btn btn-primary mb-3  float-right " :to="'/ShowGroupes'"> <i class="fas fa-long-arrow-alt-left fontsize"></i> </router-link>
        </div>
    </div>   
        <div class="text-center pull-right" >
    <h2>Ajouter Groupe</h2>
    <hr>   
    </div>


        <form @submit.prevent="validateForm('formGroup')"  data-vv-scope="formGroup">
         <div class="row" > 
         
            <div class="col-md-6">
               

                <div class="form-group row">
                    <label for="nom_compte" class="col-sm-4"> Nom groupe</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="nom_compte"  v-model="groupe.nom_groupe">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="responsable" class="col-sm-4" > année Universitaire</label>
                    <div class="col-sm-8">
                    <input type="text" class="form-control" id="responsable"  v-model="groupe.annee_universitaire_groupe">
                    </div>
                </div>
            </div> 
   <div class="col-md-6">
   
                    <div class="form-group row">
                    <label class="typo__label col-sm-4">Stagiaires *</label>
                    <div class="col-sm-8">
                    <multiselect name="MultiStagiaire" v-validate="'required'"  :custom-label="nameWithLang" tag-position="bottom" v-model="pushStagiaire"
                     tag-placeholder="Add this as new tag" placeholder="cherche un groupe"  track-by="prenom_stagiaire" 
                    :optionHeight="30" @remove="removeStagiaire" :options="stagiaires" :multiple="true"  ></multiselect>
                
                    <div v-show="errors.has('formGroup.MultiStagiaire')" class="text-danger">Champ obligatoire !</div>
                       </div> 

                    </div>

                    </div>

  
    </div>
     
     <hr>
     <h4>Ajouter calendrier</h4>
     <hr>
     <div class="row">
           <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                       <th>Mois de debut </th>
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
                                             <th class="sizeMois">
                                             <select id="month" title="Mois" class="form-control custom-select" v-model="calendrier.mois_stage_cal" >
                                            <option selected>Choisir un Mois</option>
                                             <option v-for="(Vmois,index) in Mois" :key="index" :value="index+1">{{Vmois}}</option>

                                            </select >
                                            </th>
                                            <th>
                                              <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text" id="">Du</span>
                                              </div>
                                             <select class="form-control custom-select sizeSmaine" id="exampleFormControlSelect1" v-model="calendrier.debut_semaine_cal" >
                                                
                                                <option v-for="(jour,index) in calendrier.JoursMoi" :key="index" :value="jour">{{jour}}</option>
                                            </select>
                                              <div class="input-group-prepend">
                                                <span class="input-group-text" id="">{{calendrier.nomMoisDebut}} au</span>
                                              </div>
                                            <input type="text" readonly class="form-control sizeJour" v-model="calendrier.fin_semaine_cal">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text" id=""> {{calendrier.nomMoisFin}}.</span>
                                              </div>  
                                            </div>
                                          </th>
                                          <th><input type="text" readonly class="form-control sizeJour" v-model="calendrier.lundi_cal"><input type="checkbox" @click="ferierLundi(calendrier)"  class="" id="exampleCheck1">ferié</th>
                                          <th><input type="text" readonly  class="form-control sizeJour" v-model="calendrier.mardi_cal"><input type="checkbox" @click="ferierMardi(calendrier)"  class="" id="exampleCheck2">ferié </th>
                                          <th><input type="text"  readonly class="form-control sizeJour" v-model="calendrier.mercredi_cal"><input type="checkbox" @click="ferierMercredi(calendrier)"  class="" id="exampleCheck3">ferié</th>
                                          <th><input type="text" readonly  class="form-control sizeJour" v-model="calendrier.jeudi_cal"><input type="checkbox" @click="ferierJeudi(calendrier)"  class="" id="exampleCheck4">ferié</th>
                                          <th><input type="text" readonly   class="form-control sizeJour" v-model="calendrier.vendredi_cal"><input type="checkbox" @click="ferierVendredi(calendrier)"  class="" id="exampleCheck5">ferié</th>
                                            
                                        <th><a @click="removeCalendrier(index)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                                        </tr>
                                        <tr>
                                           <th class="sizeMois">
                                             <select id="month" title="Mois" class="form-control custom-select" v-model="calendrier.mois_stage_cal" >
                                            <option selected>Choisir un Mois</option>
                                             <option v-for="(Vmois,index) in Mois" :key="index" :value="index+1">{{Vmois}}</option>

                                            </select >
                                            </th>
                                            <th>
                                              <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text" id="">Du</span>
                                              </div>
                                             <select class="form-control custom-select sizeSmaine" id="exampleFormControlSelect1" v-model="calendrier.debut_semaine_cal" >
                                                
                                                <option v-for="(jour,index) in calendrier.JoursMoi" :key="index" :value="jour">{{jour}}</option>
                                            </select>
                                              <div class="input-group-prepend">
                                                <span class="input-group-text" id="">{{calendrier.nomMoisDebut}} au</span>
                                              </div>
                                            <input type="text" readonly class="form-control sizeMoisFin" v-model="calendrier.fin_semaine_cal">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text" id=""> {{calendrier.nomMoisFin}}.</span>
                                              </div>
                                            
                                            </div>
                                          </th>
                              
                                        <th><a @click="pushCalendrier()"  class="btn btn-success"  ><i class="fas fa-plus-circle"></i></a></th>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
             </div>
     </div>
        <hr>

             
          <button  class="btn btn-primary mr-20 btn-success">Enregister</button>
</form>
    </div>
</template>

<script>

    export default{ 
        
          data: () => ({
            

            pushStagiaire:[],
            stagiaires:[],
              testDeep : false,
             Mois:['jan','fév','mar','avr','mai','jun','juil','aoû','sep','oct','nov','déc'],
             groupe:{
            id_groupe:0,
            nom_groupe: "",
            annee_universitaire_groupe:""     
            },
            calendrier :{
              id_calendrier:0,
              nomMoisDebut:"",
              nomMoisFin:"",
              mois_stage_cal:"",
              debut_semaine_cal:0,
              fin_semaine_cal:0,
              NbJours:0,
              lundi_cal:"",
              mardi_cal:"",
              mercredi_cal:"",
              jeudi_cal:"",
              vendredi_cal:"",
              JoursMoi:[],
              
              fk_groupe:0,
            },
            calendriers: [],
             groupe_stagiaire:[],
             
      }),
      watch:{

    'calendrier.debut_semaine_cal':{
  handler: function() {
      if(this.calendrier.mois_stage_cal !=""){
        this.DiffDebutFin2();}
  }
     },
     'calendrier.mois_stage_cal':{
           handler: function() {
               if(this.calendrier.mois_stage_cal !=""){
        this.getDaysMounth();}
       
         
  }
     },
     calendriers: {
            handler: function(newCalendriers, oldCalendriers){
                if(this.testDeep == false){    
                     this.testDeep = true;     
                      this.getDaysMounth3(); 
        this.DiffDebutFin3(newCalendriers,oldCalendriers);
       
       }else {
           this.testDeep = false; 
       }
        // this.testDeep = false; 
  },
              deep : true      
            },
            

     

            
    

      }, 
        
                    methods:{
  validateForm(scope) {
      this.$validator.validateAll(scope).then((result) => {
        if (result) {
          // eslint-disable-next-line
          this.addGroupe();
        }
      });
    },
                      DiffDebutFin2(){
                          console.log('dkhelllllllllllll')
                          let m1 =1
                          let m2 =1
                          let m3 =1
                           let indiceJour = 0
                          let nomSmaine = [];

                       
                       var datDebut = '2018'+'-'+this.calendrier.mois_stage_cal+'-'+this.calendrier.debut_semaine_cal;
                       for(let i=this.calendrier.debut_semaine_cal;i<this.calendrier.debut_semaine_cal+5;i++){
                          if((this.calendrier.NbJours == 31 || this.calendrier.NbJours == 28 || this.calendrier.NbJours == 30) && i>this.calendrier.NbJours){
                              if(this.calendrier.mois_stage_cal == 12 ){
                                nomSmaine[indiceJour]=m1+" "+this.Mois[0]
                                 this.calendrier.nomMoisFin = this.Mois[0]
                              m1++;
                               // m1++;
                              }
                              else {
                            nomSmaine[indiceJour]=m1+" "+this.Mois[this.calendrier.mois_stage_cal]
                            this.calendrier.nomMoisFin = this.Mois[this.calendrier.mois_stage_cal]
                              m1++;}
                           }
                           
                           
                           else {
                               nomSmaine[indiceJour]= i+" "+this.Mois[this.calendrier.mois_stage_cal-1]
                               this.calendrier.nomMoisDebut = this.Mois[this.calendrier.mois_stage_cal-1]
                           }

                        indiceJour++
                       }
                       if(m1 >1){
                           this.calendrier.fin_semaine_cal= m1-1;
                       }
                       else{
                           this.calendrier.nomMoisFin =  this.calendrier.nomMoisDebut
                           this.calendrier.fin_semaine_cal=this.calendrier.debut_semaine_cal+4
                       }


                       console.log("nom semaine ")
                       console.log(nomSmaine)
                       this.calendrier.lundi_cal = nomSmaine[0];
                        this.calendrier.mardi_cal =  nomSmaine[1];                 
                       this.calendrier.mercredi_cal = nomSmaine[2];       
                       this.calendrier.jeudi_cal = nomSmaine[3];       
                       this.calendrier.vendredi_cal = nomSmaine[4];       
                    
                      // calendrier.JoursMoi

                        var datFin = '2018'+'-'+this.calendrier.mois_stage_cal+'-'+this.calendrier.fin_semaine_cal;   

                       console.log('date debut ----->')
                       console.log(datDebut);
                       console.log('date fin ----->')
                       
                            
                            
                    },
                    //charger list avec les jours des mois 1 2 3 ... 30
                     getDaysMounth(){
                       let numberMounth = this.calendrier.mois_stage_cal;
                       let tab = [];
                        this.calendrier.NbJours = this.daysInMonth(numberMounth,2018)
                        console.log('nb jourrrrrrrrrrrrr')
                        console.log(this.calendrier.NbJours)
                        for(let i=0;i<this.calendrier.NbJours;i++){
                        tab[i]= i+1
                        }
                        this.calendrier.JoursMoi = tab;
                        
                        if(this.calendrier.debut_semaine_cal != 0){
                                this.DiffDebutFin2();
                        }
                    },

                     daysInMonth (month, year) {
                         return new Date(year, month, 0).getDate();
                     },
                    pushCalendrier(){
                      if(this.calendrier.mois_stage_cal == ""){
                                   this.$notify({
                                      group: 'foo',
                                      title: 'Champs vide',
                                      text: 'Ajouter le mois!'
                                    });
                      }
                      else if(this.calendrier.debut_semaine_cal == ""){
                                  this.$notify({
                                      group: 'foo',
                                      title: 'Champs vide',
                                      text: 'Ajouter le debut de la semaine!'
                                    });
                      }
                    else {

                    
                     
                    this.calendriers.push({mois_stage_cal:this.calendrier.mois_stage_cal,
                                        debut_semaine_cal: this.calendrier.debut_semaine_cal,
                                        fin_semaine_cal: this.calendrier.fin_semaine_cal,
                                        lundi_cal: this.calendrier.lundi_cal,
                                        mardi_cal: this.calendrier.mardi_cal,
                                        mercredi_cal: this.calendrier.mercredi_cal,
                                        jeudi_cal: this.calendrier.jeudi_cal,
                                        vendredi_cal: this.calendrier.vendredi_cal,
                                        JoursMoi: this.calendrier.JoursMoi,
                                        NbJours: this.calendrier.NbJours,
                                        nomMoisDebut: this.calendrier.nomMoisDebut,
                                        nomMoisFin: this.calendrier.nomMoisFin,
                                        
                    });
                               
                    this.calendrier = {
                                    id_calendrier:0,
                                    mois_stage_cal:"",
                                    debut_semaine_cal:0,
                                    fin_semaine_cal:0,
                                    lundi_cal:"",
                                    mardi_cal:"",
                                    mercredi_cal:"",
                                    jeudi_cal:"",
                                    vendredi_cal:"",
                                    JoursMoi:[],
                                    NbJours:0,
                                    fk_groupe:0,
                                    nomMoisDebut:"",
                                    nomMoisFin:""                                   
                                    }
                                    }
                                    
                },
                    removeCalendrier(index) {
                      this.calendriers.splice(index,1);
    
                     },

                      DiffDebutFin3(newCalendriers,oldCalendriers){
                        console.log(oldCalendriers)
                        console.log(newCalendriers)
                        
                           for (let index = 0; index < this.calendriers.length; index++) {
                           
           
                          console.log('dkhelllllllllllll')
                          let m1 =1
                          let m2 =1
                          let m3 =1
                           let indiceJour = 0
                          let nomSmaine = [];

                       // let Diff = +this.calendrier.fin_semaine_cal - +this.calendrier.debut_semaine_cal
                       var datDebut = '2018'+'-'+this.calendriers[index].mois_stage_cal+'-'+this.calendriers[index].debut_semaine_cal;
                       for(let i=this.calendriers[index].debut_semaine_cal;i<this.calendriers[index].debut_semaine_cal+5;i++){
                          if((this.calendriers[index].NbJours == 31 || this.calendriers[index].NbJours == 28 || this.calendriers[index].NbJours == 30) && i>this.calendriers[index].NbJours){
                              if(this.calendriers[index].mois_stage_cal == 12 ){
                                nomSmaine[indiceJour]=m1+" "+this.Mois[0]
                                this.calendriers[index].nomMoisFin = this.Mois[0]
                                m1++;
                              }
                              else {
                            nomSmaine[indiceJour]=m1+" "+this.Mois[this.calendriers[index].mois_stage_cal]
                            this.calendriers[index].nomMoisFin = this.Mois[this.calendriers[index].mois_stage_cal]
                              m1++;}
                           }
                           
                           
                           else {
                               nomSmaine[indiceJour]= i+" "+this.Mois[this.calendriers[index].mois_stage_cal-1]
                               this.calendriers[index].nomMoisDebut = this.Mois[this.calendriers[index].mois_stage_cal-1]
                           }

                        indiceJour++
                       }
                       if(m1 >1){
                           this.calendriers[index].fin_semaine_cal= m1-1;
                       }
                       else{
                         this.calendriers[index].nomMoisFin =  this.calendriers[index].nomMoisDebut
                           this.calendriers[index].fin_semaine_cal=this.calendriers[index].debut_semaine_cal+4
                       }


                       console.log("nom semaine ")
                       console.log(this.calendriers[0].NbJours)
                       
                       console.log(this.Mois[0])
                       if(this.calendriers[index].lundi_cal != ''){
                       this.calendriers[index].lundi_cal = nomSmaine[0]; }
                       if (this.calendriers[index].mardi_cal != ''){
                        this.calendriers[index].mardi_cal =  nomSmaine[1]; }  
                        if (this.calendriers[index].mercredi_cal != ''){            
                       this.calendriers[index].mercredi_cal = nomSmaine[2];    }
                       if (this.calendriers[index].jeudi_cal != ''){            
                       this.calendriers[index].jeudi_cal = nomSmaine[3];       }
                       if (this.calendriers[index].vendredi_cal != ''){
                       this.calendriers[index].vendredi_cal = nomSmaine[4];  }     
                        console.log('fuckkkkkkkkkkkk')
                      // calendrier.JoursMoi

                        var datFin = '2018'+'-'+this.calendriers[index].mois_stage_cal+'-'+this.calendriers[index].fin_semaine_cal;   

                       console.log('date debut ----->')
                       console.log(datDebut);
                       console.log('date fin ----->')
                       
                            }
                            
                      },
                    getDaysMounth3(){
                                                
                        for (let index = 0; index < this.calendriers.length; index++) {
                       let numberMounth = this.calendriers[index].mois_stage_cal;
                       let tab = [];
                        this.calendrier.NbJours = this.daysInMonth(numberMounth,2018)
                        for(let i=0;i<this.calendrier.NbJours;i++){
                        tab[i]= i+1
                        }
                        this.calendriers[index].JoursMoi = tab;
              
                    }},
                    addGroupe(){
                        console.log("nbr jourrrr --------")
                        console.log(this.calendrier.NbJours)
                         axios.post('/addGroupe',{calendriers:this.calendriers,groupe:this.groupe,pushStagiaire:this.pushStagiaire})
                        .then(response => {         
                                console.log("Groupe Bien ajouter ")
                            // this.$router.push('/');
                            this.$router.push({ name: 'ShowGroupes', params: { success: "addsuccess"  }});
                        })
                        .catch(() => {
                                console.log('handle server error from here');
                        });
                    },
                   ferierLundi(calendrier){
                      if(calendrier.lundi_cal !="") calendrier.lundi_cal= "";
                      else calendrier.lundi_cal=".";
                        

                    },
                   ferierMardi(calendrier){
                      if(calendrier.mardi_cal !="") calendrier.mardi_cal= "";
                      else calendrier.mardi_cal=".";
                    },
                 
           

                    ferierMercredi(calendrier){
                      if(calendrier.mercredi_cal !="") calendrier.mercredi_cal= "";
                      else calendrier.mercredi_cal=".";
                        

                    },
                    ferierJeudi(calendrier){
                      if(calendrier.jeudi_cal !="") calendrier.jeudi_cal= "";
                      else calendrier.jeudi_cal=".";
                        

                    },
                    ferierVendredi(calendrier){
                      if(calendrier.vendredi_cal !="") calendrier.vendredi_cal= "";
                      else calendrier.vendredi_cal=".";
                        

                    },
            getAllStagiaires(){//type_status
                axios.get('/getAllStagiaires')
                .then((response) => {
                    this.loading = false;
                    this.stagiaires = response.data.stagiaires;
               })
                .catch(() => {
                    console.log('handle server error from here');
                });
    },
           removeStagiaire(removedOption,id){
                console.log('---remove')
                console.log(removedOption)
          },
           nameWithLang ({ nom_stagiaire, prenom_stagiaire }) {
      return `${nom_stagiaire}-${prenom_stagiaire}`
    }
                    




                    },
                    mounted(){
                      this.getAllStagiaires();
                    }
                 

     
       
        
      

    }
    
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
 .thSmaine{
    width: 147px;
 }
  .sizeSmaine{
    width: 42px;
    min-width: 59px;
 }
  .sizeJour{
    width: 42px;
    min-width: 70px;
 }
 .sizeMoisFin{
         width: 42px;
    min-width: 42px;
 }
 .sizeMois{
   width: 155px;
 }
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
ul{
  margin: 0;
  padding: 0;
  list-style: none;
}
a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.fontsize{

    font-size: 1.30rem;
}
</style>
