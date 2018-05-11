<template>
  <div class="page-wrapper">
      <top-menu-evaluateur>

         
      </top-menu-evaluateur>
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


import TopMenuEvaluateur from './TopMenuEvaluateur.vue' 

import Contents from './Contents.vue' 
import Pagination from './Pagination.vue' 




export default {
   components:{
  
     'app-contents':Contents,
      'top-menu-evaluateur':TopMenuEvaluateur,
     'app_pagination':Pagination
     
     
  },
  data: () => ({
      sidebarr:"sidebar-fixed header-fixed",
  }),


}
</script>