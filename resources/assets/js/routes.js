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


//Groupes
import ShowGroupes from './components/Groupe/ShowGroupes.vue'
import ShowGroupe from './components/Groupe/ShowGroupe.vue'
import AddGroupe from './components/Groupe/AddGroupe.vue'
import EditGroupe from './components/Groupe/EditGroupe.vue'






  

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
         {
            path:"/ShowResponsables",
            component: ShowResponsables
         },
         {
            path:"/AddResponsable",
            component: AddResponsable,
            name: "AddResponsable"
         },
 // Groupe 
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
         



            

        


    ],
   
})

export default router 