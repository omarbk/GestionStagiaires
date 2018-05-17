export default function (Vue){
    Vue.auth = {
       async  getProfile(){
           
           let authen  = await  axios.get('/getProfile')
            .then(response => {let test;
              if(response.data.user[0].role == 'Super Admin')
              test = "Super Admin";
              else if(response.data.user[0].role == 'Evaluateur')
              test = "Evaluateur";
              else if(response.data.user[0].role == 'Responsable')
              test = "Responsable";
              else if(response.data.user[0].role == 'Expert Comptable')
              test = "Expert Comptable";
            //  else test = "";
              return test;
             // return false;
               
            })
            .catch(function (error) {
               
            });           
         return authen;
                   
            },


    }
    Object.defineProperties(Vue.prototype,{
        $auth:{
            get(){
                return Vue.auth;
            }
        }
    })
}