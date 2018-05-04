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




  

//Vue.use(VueRouter)


//parametres
import  Parametres from './components/Parametres.vue' 







Vue.use(VueRouter) 

const  router = new VueRouter({ 

    routes: [
        // route gestion de commerce
        {
            path:"/",
            component: Contents
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
        


    ],
   
})

export default router 