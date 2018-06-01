import Vue from 'vue'
import VueRouter from 'vue-router'
import Contents from './components/Contents.vue'
import Login from './components/Login.vue'
  //users
import AddUsers from './components/User/AddUsers.vue'
import AffUsers from './components/User/AffUsers.vue'
import EditUser from './components/User/EditUser.vue'
import UserConnect from './components/User/UserConnect.vue'

// Responsables 
import ShowResponsables from './components/Responsable/ShowResponsables.vue'
import AddResponsable from './components/Responsable/AddResponsable.vue'
import EditResponsable from './components/Responsable/EditResponsable.vue'

// Services 
import ShowServices from './components/Service/ShowServices.vue'
import AddService from './components/Service/AddService.vue'
import EditService from './components/Service/EditService.vue'

// Hospitaliers 
import ShowHospitaliers from './components/Hospitalier/ShowHospitaliers.vue'
import AddHospitalier from './components/Hospitalier/AddHospitalier.vue'
import EditHospitalier from './components/Hospitalier/EditHospitalier.vue'

// Evaluateurs 
import ShowEvaluateurs from './components/Evaluateur/ShowEvaluateurs.vue'
import AddEvaluateur from './components/Evaluateur/AddEvaluateur.vue'
import EditEvaluateur from './components/Evaluateur/EditEvaluateur.vue'

// Objectifs 
import ShowObjectifs from './components/Objectif/ShowObjectifs.vue'
import AddObjectif from './components/Objectif/AddObjectif.vue'
import EditObjectif from './components/Objectif/EditObjectif.vue'
import ShowObjectif from './components/Objectif/ShowObjectif.vue'

// Evaluation 
import ShowEvaluation from './components/Evaluation/ShowEvaluation.vue'
import AddEvaluation from './components/Evaluation/AddEvaluation.vue'
import EditEvaluation from './components/Evaluation/EditEvaluation.vue'
import ShowStagiairesEva from './components/Evaluation/ShowStagiairesEva.vue'


// show responsable
import ShowStagiairesResp from './components/CompteResp/ShowStagiairesResp.vue'
import ShowEvaluationStage from './components/CompteResp/ShowEvaluationStage.vue'
import ShowEvaluationStag from './components/CompteResp/ShowEvaluationStag.vue'
import ShowAbsencesStag from './components/CompteResp/ShowAbsencesStag.vue'
// show stagiaire
import ShowStagiairesStagiaire from './components/CompteStagiaire/ShowStagiairesStagiaire.vue'
import ShowStagesEffectues from './components/CompteStagiaire/ShowStagesEffectues.vue'
import ShowAbsencesActuel from './components/CompteStagiaire/ShowAbsencesActuel.vue'
import ShowEvaluationEffectues from './components/CompteStagiaire/ShowEvaluationEffectues.vue'
import ShowAbsencesEffectues from './components/CompteStagiaire/ShowAbsencesEffectues.vue'

//activite
import AddActivite from './components/Activite/AddActivite.vue'
import ShowActivites from './components/Activite/ShowActivites.vue'
import ShowActivite from './components/Activite/ShowActivite.vue'
import EditActivite from './components/Activite/EditActivite.vue'

//Module
import AddModule from './components/Module/AddModule.vue'
import ShowModules from './components/Module/ShowModules.vue'
import ShowModule from './components/Module/ShowModule.vue'
import EditModule from './components/Module/EditModule.vue'

//--------------------------------
//Groupes
import ShowGroupes from './components/Groupe/ShowGroupes.vue'
import ShowGroupe from './components/Groupe/ShowGroupe.vue'
import AddGroupe from './components/Groupe/AddGroupe.vue'
import EditGroupe from './components/Groupe/EditGroupe.vue'

//stagiaire
//Groupes
import ShowStagiaires from './components/Stagiaire/ShowStagiaires.vue'
import AddStagiaire  from './components/Stagiaire/AddStagiaire.vue'
import EditStagiaire  from './components/Stagiaire/EditStagiaire.vue'


//stages 
import ShowStage from './components/Stage/ShowStage.vue'
import ShowStages from './components/Stage/ShowStages.vue'
import AddStage  from './components/Stage/AddStage.vue'
import EditStage  from './components/Stage/EditStage.vue'



  

//Vue.use(VueRouter)


//parametres
import  Parametres from './components/Parametres.vue' 

// absence 

//Groupes
import ShowAbsences from './components/Absence/ShowAbsences.vue'
import AddAbsence from './components/Absence/AddAbsence.vue'
import EditAbsence from './components/Absence/EditAbsence.vue'







Vue.use(VueRouter) 

const  router = new VueRouter({ 

    routes: [
        // route gestion de commerce
        {
            path:"/",
            component: Contents,
            meta:{
                Evaluateur:true,
                Responsable:true,
                Stagiaire:true,
                }

        },
        

        
       // route d'authentification
        {   
            path:"/login",
            component: Login
        }, 
        
        


         // ----------------------------------------------------------  // Users 
      // route pour ajouter un utilisateur
        {    
            path:"/addUsers",
            component: AddUsers,
            meta:{
                TopAdmin:true,
            }
        },
      // route pour afficher les utilisateurs
        {   

            path:"/getUsers/:success",
            component: AffUsers
        },
        {   
              
            path:"/getUsers",
            component: AffUsers
        },
     // route pour recuperer les donnees d'un utilisateur
        {     
            path:"/editProfile",
            component: EditUser
        },
        {
            path:"/getProfile",
            component: UserConnect
        },
        {
        path:"/getProfile/:success",
        component: UserConnect
        },
        {
            path:"/Parametres",
            component: Parametres
         },

 // ----------------Responsable
         {
            path:"/ShowResponsables",
            component: ShowResponsables,
            name:"ShowResponsables"
         },
         {
            path:"/ShowResponsables/:success",
            component: ShowResponsables,
         },
         {
            path:"/AddResponsable",
            component: AddResponsable,
            name: "AddResponsable"
         },
         {
            path:"/EditResponsable/:id_responsable",
            component: EditResponsable,
           // name: "EditResponsable"
         },
 //----------------------------------- Groupe 
         {
            path:"/ShowGroupes",
            component: ShowGroupes,
            name: "ShowGroupes"
         },
         {
            path:"/ShowGroupe",
            component: ShowGroupe,
            name: "ShowGroupe"
         },
         {
            path:"/AddGroupe",
            component:AddGroupe,
            name: "AddGroupe"
         },
         {
            path:"/EditGroupe/:id_groupe",
            component: EditGroupe,
            name: "EditGroupe"
         },
         

 // ----------------Service
        {
            path:"/ShowServices",
            component: ShowServices,
            name:"ShowServices"
        },
        {
            path:"/ShowServices/:success",
            component: ShowServices,
        },
        {
            path:"/AddService",
            component: AddService,
            name: "AddService"
        },
        {
            path:"/EditService/:id_service",
            component: EditService,
        // name: "EditService"
        },

  // ----------------Hospitalier
  {
    path:"/ShowHospitaliers",
    component: ShowHospitaliers,
    name:"ShowHospitaliers"
},
{
    path:"/ShowHospitaliers/:success",
    component: ShowHospitaliers,
},
{
    path:"/AddHospitalier",
    component: AddHospitalier,
    name: "AddHospitalier"
},
{
    path:"/EditHospitalier/:id_hospitalier",
    component: EditHospitalier,
// name: "EditHospitalier"
},    


// ------------ stagiaire 
{
    path:"/ShowStagiaires",
    component: ShowStagiaires,
    name: "ShowStagiaires"
 },

 {
    path:"/AddStagiaire",
    component:AddStagiaire,
    name: "AddStagiaire"
 },
 {
    path:"/EditStagiaire/:id_stagiaire",
    component: EditStagiaire,
    name: "EditStagiaire"
 },      
 // ----------------Evaluateur
 {
    path:"/ShowEvaluateurs",
    component: ShowEvaluateurs,
    name:"ShowEvaluateurs"
 },
 {
    path:"/ShowEvaluateurs/:success",
    component: ShowEvaluateurs,
 },
 {
    path:"/AddEvaluateur",
    component: AddEvaluateur,
    name: "AddEvaluateur"
 },
 {
    path:"/EditEvaluateur/:id_evaluateur",
    component: EditEvaluateur,
   // name: "EditEvaluateur"
 },
 //stage 

 {
    path:"/ShowStages",
    component: ShowStages,
    name: "ShowStages"
 },
 {
    path:"/ShowStage",
    component: ShowStage,
    name: "ShowStage"
 },
 {
    path:"/AddStage",
    component:AddStage,
    name: "AddStage"
 },
 {
    path:"/EditStage/:id_stage",
    component: EditStage,
    name: "EditStage"
 },
        
 // ----------------Objectif
 {
    path:"/ShowObjectifs",
    component: ShowObjectifs,
    name:"ShowObjectifs"
},

{
    path:"/AddObjectif",
    component: AddObjectif,
    name: "AddObjectif"
},
{
    path:"/EditObjectif/:annee_objectif",
    component: EditObjectif,
// name: "EditObjectif"
},
{
    path:"/ShowObjectif/:annee_objectif",
    component: ShowObjectif,
   // name:"ShowObjectif"
},
//----------------Evaluation
{
    path:"/AddEvaluation",
    component: AddEvaluation,
    name: "AddEvaluation"
 },
 {
    path:"/ShowEvaluation",
    component: ShowEvaluation,
    name:"ShowEvaluation",
   

},
{
    path:"/EditEvaluation",
    component: EditEvaluation,
 name: "EditEvaluation"
},
{
    path:"/ShowStagiairesEva",
    component: ShowStagiairesEva,
    name:"ShowStagiairesEva",
   

},

//----------------Module
{
    path:"/AddModule",
    component: AddModule,
    name: "AddModule"
 },
 {
    path:"/ShowModules",
    component: ShowModules,
    name: "ShowModules"
 },
  {
    path:"/ShowModule/:niveau_etude",
    component: ShowModule,
    name: "ShowModule"
 },
 {
    path:"/EditModule/:niveau_etude",
    component: EditModule,
    name: "EditModule"
 },

 //----------------Activite
{
    path:"/AddActivite",
    component: AddActivite,
    name: "AddActivite"
 },
 {
    path:"/ShowActivites",
    component: ShowActivites,
    name: "ShowActivites"
 },
  {
    path:"/ShowActivite/:niveau_etude",
    component: ShowActivite,
    name: "ShowActivite"
 },
 {
    path:"/EditActivite/:niveau_etude",
    component: EditActivite,
    name: "EditActivite"
 },

//----------- Absence 
{
    path:"/ShowAbsences",
    component: ShowAbsences,
    name: "ShowAbsences"
 },
 {
    path:"/AddAbsence",
    component: AddAbsence,
    name: "AddAbsence"
 },
 {
    path:"/EditAbsence",
    component: EditAbsence,
    name: "EditAbsence"
 },

//------------------show responsable
{
    path:"/ShowStagiairesResp",
    component: ShowStagiairesResp,
    name:"ShowStagiairesResp",
   

},
{
    path:"/ShowEvaluationStage",
    component: ShowEvaluationStage,
    name:"ShowEvaluationStage",
   

},
{
    path:"/ShowEvaluationStag",
    component: ShowEvaluationStag,
    name:"ShowEvaluationStag",
   

},

{
    path:"/ShowAbsencesStag",
    component: ShowAbsencesStag,
    name:"ShowAbsencesStag",
   

},

//-------------show stagiaire
{
    path:"/ShowStagiairesStagiaire",
    component: ShowStagiairesStagiaire,
    name:"ShowStagiairesStagiaire",
   

},
{
    path:"/ShowStagesEffectues",
    component: ShowStagesEffectues,
    name:"ShowStagesEffectues",
   

},
{
    path:"/ShowAbsencesActuel",
    component: ShowAbsencesActuel,
    name:"ShowAbsencesActuel",
   

},{
    path:"/ShowEvaluationEffectues",
    component: ShowEvaluationEffectues,
    name:"ShowEvaluationEffectues",
   

},
{
    path:"/ShowAbsencesEffectues",
    component: ShowAbsencesEffectues,
    name:"ShowAbsencesEffectues",
   

},
    ],
   
})

export default router 