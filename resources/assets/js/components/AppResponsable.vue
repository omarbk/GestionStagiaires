<template>
  <div class="page-wrapper">
      <top-menu-responsable>

         
      </top-menu-responsable>
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


import TopMenuResponsable from './TopMenuResponsable.vue' 

import Contents from './Contents.vue' 
import Pagination from './Pagination.vue' 




export default {
   components:{
  
     'app-contents':Contents,
      'top-menu-responsable':TopMenuResponsable,
     'app_pagination':Pagination
     
     
  },
  data: () => ({
      sidebarr:"sidebar-fixed header-fixed",
  }),


}
</script>
<style scoped>
.content{
  margin-top: 40px;
}
</style>