<template>
  <div class="page-wrapper">
      <top-menu>

         
      </top-menu>
    <div class="main-container">
  
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

import Contents from './Contents.vue' 
import Pagination from './Pagination.vue' 




export default {
   components:{
     'top-menu':TopMenu,
     'app-contents':Contents,

     'app_pagination':Pagination
     
     
  },
  data: () => ({
      sidebarr:"sidebar-fixed header-fixed",
  }),


}
</script>