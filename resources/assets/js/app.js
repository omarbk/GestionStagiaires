
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');



//bootstrapvue 
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);


import VeeValidate from 'vee-validate'
Vue.use(VeeValidate);

//multiselect
import Multiselect from 'vue-multiselect'
  // register globally
  Vue.component('multiselect', Multiselect)


import swal from 'sweetalert2'
Vue.prototype.$swal=swal;

import Notifications from 'vue-notification'
Vue.use(Notifications)

import WrittenNumber from 'written-number'
Vue.prototype.$WrittenNumber=WrittenNumber;



import Router from './routes.js'


import Auth from './Auth.js'
//import Char from './Chart.min.js'
Vue.use(Auth)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app-login', require('./components/Login.vue'));
Vue.component('app-menu', require('./components/TopMenu.vue'));
Vue.component('app-sidebar', require('./components/Sidebar.vue'));
Vue.component('app-content', require('./components/Contents.vue'));
/* Users*/

Vue.component('app-vue', require('./components/App.vue'));
Vue.component('app-vue-evaluateur', require('./components/AppEvaluateur.vue'));
Vue.component('app-vue-responsable', require('./components/AppResponsable.vue'));
Vue.component('app-vue-stagiaire', require('./components/AppStagiaire.vue'));


Vue.component('app-addusers', require('./components/User/AddUsers.vue'));
Vue.component('app-affusers', require('./components/User/AffUsers.vue'));
Vue.component('app-edituser', require('./components/User/EditUser.vue'));
Vue.component('app-userconnect', require('./components/User/UserConnect.vue'));


/* Responsable */
Vue.component('app-addresponsable', require('./components/Responsable/AddResponsable.vue'));
Vue.component('app-showresponsables', require('./components/Responsable/ShowResponsables.vue'));
Vue.component('app-editresponsable', require('./components/Responsable/EditResponsable.vue'));

/* Service */
Vue.component('app-addservice', require('./components/Service/AddService.vue'));
Vue.component('app-showservices', require('./components/Service/ShowServices.vue'));
Vue.component('app-editservice', require('./components/Service/EditService.vue'));

/* Hospitalier */
Vue.component('app-addhospitalier', require('./components/Hospitalier/AddHospitalier.vue'));
Vue.component('app-showhospitaliers', require('./components/Hospitalier/ShowHospitaliers.vue'));
Vue.component('app-edithospitalier', require('./components/Hospitalier/EditHospitalier.vue'));

/* Evaluateur */
Vue.component('app-addevaluateur', require('./components/Evaluateur/AddEvaluateur.vue'));
Vue.component('app-showevaluateurs', require('./components/Evaluateur/ShowEvaluateurs.vue'));
Vue.component('app-editevaluateur', require('./components/Evaluateur/EditEvaluateur.vue'));

/* Objectif */
Vue.component('app-addobjectif', require('./components/Objectif/AddObjectif.vue'));
Vue.component('app-showobjectifs', require('./components/Objectif/ShowObjectifs.vue'));
Vue.component('app-editobjectif', require('./components/Objectif/EditObjectif.vue'));
Vue.component('app-showobjectif', require('./components/Objectif/ShowObjectif.vue'));

/* Evaluation */
Vue.component('app-addevaluation', require('./components/Evaluation/AddEvaluation.vue'));
Vue.component('app-showevaluation', require('./components/Evaluation/ShowEvaluation.vue'));
Vue.component('app-editevaluation', require('./components/Evaluation/EditEvaluation.vue'));

/* Activite */
Vue.component('app-addactivite', require('./components/Activite/AddActivite.vue'));

// afficher un nombre de phrase limité 
/*Vue.filter('readMore', function (text, length, suffix) {
    return text.substring(0, length) + suffix;
});*/


/*import jquery from 'jquery'
global.jquery = jquery
global.$ = jquery*/

Router.beforeEach(

    (to,from,next) => {
        if(to.matched.some(record => record.meta.TopAdmin)){
            
            Promise.resolve(Vue.auth.getProfile()).then(function(value){
               
                if(value == "Admin" || value == "Expert Comptable"){
                    next({
                        path:'/'
                    })
                }
                else next()
            });
        
        

        }else if(to.matched.some(record => record.meta.SuperAdmin) && to.matched.some(record => record.meta.Admin)){
            
            Promise.resolve(Vue.auth.getProfile()).then(function(value){
               
                if(value == "Expert Comptable"){
                    next({
                        path:'/'
                    })
                }
                else next()
            });
        
        

        }

       
        else if(to.matched.some(record => record.meta.Responsable)){
            console.log('responsable***********************')
            
            Promise.resolve(Vue.auth.getProfile()).then(function(value){
               console.log("role --------")
               console.log(value)
                if(value == "Responsable"){
                    next({
                        path:'/ShowStagiairesResp'
                    })
                }
                else next()
            });
        
        

        }
        else if(to.matched.some(record => record.meta.Stagiaire)){
            console.log('responsable***********************')
            
            Promise.resolve(Vue.auth.getProfile()).then(function(value){
               console.log("role --------")
               console.log(value)
                if(value == "Stagiaire"){
                    next({
                        path:'/ShowStagiairesStagiaire'
                    })
                }
                else next()
            });
        
        

        }
        else if(to.matched.some(record => record.meta.Evaluateur)){
            console.log('eval***********************')
            
            Promise.resolve(Vue.auth.getProfile()).then(function(value){
               
                if(value == "Evaluateur"){
                    next({
                        path:'/ShowStagiairesEva'
                    })
                }
                else next()
            });
        
        

        }
  
        
        
        else next()
    }
)
const app = new Vue({
    el: '#app',
    router: Router,
   
            
  
});
