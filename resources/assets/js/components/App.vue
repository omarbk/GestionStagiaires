<template>
  <div class="page-wrapper">
      <top-menu>

         
      </top-menu>
    <div class="main-container">
       <app-sidebar>

       </app-sidebar>
       <div class="content">
            <div class="container-fluid">
       <router-view></router-view>
            </div>
       </div>
    </div>

  </div>
</template>
<script>

import TopMenu from './TopMenu.vue' 
import Sidebar from './Sidebar.vue' 
import Contents from './Contents.vue' 
import Pagination from './Pagination.vue' 




export default {
   components:{
     'top-menu':TopMenu,
     'app-sidebar':Sidebar,
     'app-contents':Contents,

     'app_pagination':Pagination
     
     
  },
  data: () => ({
 
  }),


}
</script>