<template>
  <div class="page-wrapper">
      <top-menu>

         
      </top-menu>
    <div class="main-container">
        <app-sidebar-comptable></app-sidebar-comptable>
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
import SidebarComptable from './SidebarComptable.vue' 
import Contents from './Contents.vue' 

import Pagination from './Pagination.vue' 





export default {
   components:{
     'top-menu':TopMenu,
     'app-sidebar':Sidebar,
     'app-contents':Contents,

     'app_pagination':Pagination,
     'app-sidebar-comptable':SidebarComptable,
     
  },
  data: () => ({
 
  }),


}
</script>