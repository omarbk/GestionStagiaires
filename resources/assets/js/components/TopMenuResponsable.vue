<template>
<div>

    <div v-if="error" class="error">
      {{ error }}
    </div>

<div>
    <nav class="navbar page-header colorMenu">


        <a class="navbar-brand" href="#">
            <img src="storage/images/logoStagiaire.png" alt="logo">
        </a>

      
        <router-link :to="'/ShowStagiairesResp'" class="nav-link active margLien">
                            <i class="far fa-user-circle fa-lg"> Stagiaires </i>
         </router-link>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
            </li>

            <li class="nav-item d-md-down-none">
                <a href="#">
                    <i class="fa fa-envelope-open"></i>
                    <span class="badge badge-pill badge-danger">5</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img v-if="profile.photo != ''" :src="'storage/images/'+profile.photo" class="avatar avatar-sm" alt="logo">
                    <img v-if="profile.photo === ''" :src="'storage/images/user0.jpg'" class="avatar avatar-sm" alt="logo">

                    <span class="small ml-1 d-md-down-none">{{profile.name}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">Account</div>

                    <router-link :to="'/getProfile'" class="dropdown-item">
                        <i class="fa fa-user"></i> Profile
                    </router-link>

                 
                  

                    <a href="#" class="dropdown-item" @click="logout">
                        <i class="fa fa-lock"></i> Déconnecter
                    </a>
                   
                </div>
                
            </li>
        </ul>

    </nav>
</div>
</div> 
</template>

<script>

 export default {
        data: () => ({
            loading: false,
            error:false,
            isSuperAd:false,
            profile: {
      id:0,
      name:"",
      email:"",
      password:"",
      role:"",
      photo:"",
      
    },
        }),
        
        methods: {
            logout:function() {

                axios.get('/logout')
                .then((response) => {
                  
                    window.location.href="/login"
                  
                })
                .catch(() => {
                    console.log('error log out ');
                });},
                
                    
        
            
             getProfile(){
this.loading = true
                        axios.get('/getProfile')
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                         //  console.log("11")
                           this.profile = response.data.user[0];
                           this.loading = false;
                        //console.log(response.data.user[0]);
                      //  console.log(this.profile)

                        })
                        .catch(function (error) {
                           
                        });                
                         
                               
            },
            isSuperAdmin(){
                  axios.get('/isSuperAdmin')
                        .then(response => {
                            // recuperé ensemble des articles sous format json
                           console.log("11")
                           this.isSuperAd = test;
                        //console.log(response.data.user[0]);
                        console.log( this.isSuperAd )

                        })
                        .catch(function (error) {
                           
                        });
            }
            

        },

created(){
//this.getProfile();
},
        mounted(){
                    this.getProfile();
            
          
          
         // console.log(this.profile)
          
    },

        
    }
</script>
<style scoped>
.margLien{
    margin-left: -69px;
}
.colorMenu{
   background: #b8ebfd;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #FFFFFF, #6DD5FA, #b8ebfd);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #FFFFFF, #6DD5FA,#b8ebfd); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

}
</style>
