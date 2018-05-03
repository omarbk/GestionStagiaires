<template>
 <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title"></li>

                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="fas fa-chart-line"></i> Statistiques
                        </router-link>
                    </li>            
                    <li class="nav-item">
                      <router-link :to="'/Parametres'" class="nav-link active">
                            <i class="fas fa-cogs"></i>Paramètres
                        </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="'/ShowResponsables'" class="nav-link active">
                            <i class="far fa-user-circle"></i>Responsables
                        </router-link>
                    </li>            
                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="far fa-user-circle"></i>Stagiaires
                        </router-link>
                    </li> 
                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="far fa-address-card"></i>Evaluateurs
                        </router-link>
                    </li>                      
                    <li class="nav-item">
                      <router-link :to="'/ShowGroupes'" class="nav-link active">
                            <i class="fab fa-gofore"></i>Groupes
                        </router-link>
                    </li>                     
                 
                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="far fa-hospital"></i>Hospitaliers
                        </router-link>
                    </li>               
                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="fas fa-briefcase"></i>Stages
                        </router-link>
                    </li>   
                    <li class="nav-item">
                      <router-link :to="'/'" class="nav-link active">
                            <i class="far fa-sticky-note"></i>Etats
                        </router-link>
                    </li>                           
                            
                                 
              
                    
                 
                </ul>
            </nav>
        </div> 
</template>
<style scoped>



</style>