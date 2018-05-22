<template>
<div>

    <div v-if="error" class="error">
      {{ error }}
    </div>

<div>
    <nav class="navbar page-header">
        <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
            <i class="fa fa-bars"></i>
        </a>

        <a class="navbar-brand" href="#">
            <img src="storage/images/logoStagiaire.png" alt="logo">
        </a>

        <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
            <i class="fa fa-bars"></i>
        </a>
     <router-link :to="'/ShowStagiairesEva'" class="nav-link active margLien">
                            <i class="far fa-user-circle fa-lg"> Stagiaires </i>
         </router-link>

        <ul class="navbar-nav ml-auto">
           
            <li class="nav-item dropdown">

                   <a  href="#" role="button"  @click="MarkNotifRead" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill badge-danger">{{nbNotif}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                <ul class="list-group scroll">
                    <li   class="list-group-item"  v-for="(notification,index) of notifications" :key="index" ><i class="far fa-file" :style="[notification.read_at == null ? redColor : blueColor]" ></i> {{notification.data.data}}</li>
                </ul>
                </div>
                
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
                         redColor: {
               color: 'red',
                },
            blueColor:{
                color: 'blue',
            },
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
        notifications : [],
    nbNotif :0,
        }),
        
        methods: {
                 listen(){
         console.log("ooooook ===")
        /* Echo.channel('posts')
              .listen('App.Events.NewComment', () => {
                  this.pusherr="pusherrrr"
                  console.log("pusherrrrrr")
              })*/
              let this1=this;
              Echo.channel('posts-channel').listen('NewComment', function(e) {
                console.log(e);
                console.log("pusherrrrrr")
                this1.getNotifications();
            });
       
     },
                        MarkNotifRead(){
                axios.get('/MarkNotifRead').then((response) => {
                                                console.log('all notif read')
                                               let  this1 = this;
                                                this.nbNotif =0;
                                                setTimeout(function(){ this1.getNotifications(); }, 100000);
                                               console.log('douzzzz')
                                                })
                                                .catch(() => {
                                                    console.log('handle server error from here');
                                                });
            },
               getNotifications(){
               axios.get('/getNotifications')
                .then((response) => {
                console.log("notifications")
                console.log(response)
                    
                  this.notifications = response.data.notifications;
                  this.nbNotif = response.data.CountnotifNotRead

                })
                .catch(() => {
                    console.log('handle server error from here');
                });
                
          },
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
            this.listen();
            this.getNotifications();
                    this.getProfile();
            
          
          
         // console.log(this.profile)
          
    },

        
    }
</script>
<style scoped>
.scroll {
  height:150px;
  overflow-y: scroll;
}
</style>