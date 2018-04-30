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



            

        


    ],
   
})

export default router 