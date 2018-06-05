<template>
 <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title"></li>

                    <li class="nav-item"> 
                      <router-link :to="'/'"  v-on:click.native="setActive('Statistiques')" :class="{ active: isActive2('Statistiques'), 'nav-link': navTest }">
                            <i class="fas fa-chart-line"></i> Statistiques
                        </router-link>
                    </li>            
                    <li class="nav-item">
                      <router-link :to="'/Parametres'"  v-on:click.native="setActive('Parametres')" :class="{ active: isActive2('Parametres'), 'nav-link': navTest }" >
                        <i class="fas fa-cog"></i> Paramètres
                        </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="'/ShowResponsables'"  v-on:click.native="setActive('Responsables')" :class="{ active: isActive2('Responsables'), 'nav-link': navTest }">
                            <i class="far fa-user-circle"></i>Responsables
                        </router-link>
                    </li>            
                    <li class="nav-item">
                      <router-link :to="'/ShowStagiaires'"  v-on:click.native="setActive('Stagiaires')" :class="{ active: isActive2('Stagiaires'), 'nav-link': navTest }">
                            <i class="far fa-user-circle"></i>Stagiaires
                        </router-link>
                    </li> 
                    <li class="nav-item">
                      <router-link :to="'/ShowEvaluateurs'"  v-on:click.native="setActive('Evaluateurs')" :class="{ active: isActive2('Evaluateurs'), 'nav-link': navTest }">
                            <i class="far fa-address-card"></i>Evaluateurs
                        </router-link>
                    </li>                      
                    <li class="nav-item">
                      <router-link :to="'/ShowGroupes'"  v-on:click.native="setActive('Groupes')" :class="{ active: isActive2('Groupes'), 'nav-link': navTest }">
                            <i class="fab fa-gofore"></i>Groupes
                        </router-link>
                    </li>                     
                 
                    <li class="nav-item">
                      <router-link :to="'/ShowHospitaliers'"  v-on:click.native="setActive('Hospitaliers')" :class="{ active: isActive2('Hospitaliers'), 'nav-link': navTest }">
                            <i class="far fa-hospital"></i>Hospitaliers
                        </router-link>
                    </li>               
                    <li class="nav-item">
                      <router-link :to="'/ShowStages'"  v-on:click.native="setActive('Stages')" :class="{ active: isActive2('Stages'), 'nav-link': navTest }">
                            <i class="fas fa-briefcase"></i>Stages
                        </router-link>
                    </li>   
 
                    <li class="nav-item">
                      <router-link :to="'/ShowServices'" v-on:click.native="setActive('Services')" :class="{ active: isActive2('Services'), 'nav-link': navTest }">
                            <i class="fas fa-cogs"></i>Services
                        </router-link>
                    </li> 
                    <li class="nav-item">
                      <router-link :to="'/ShowObjectifs'"  v-on:click.native="setActive('Evaluation')" :class="{ active: isActive2('Evaluation'), 'nav-link': navTest }">
                            <i class="far fa-file-alt"></i>Evaluation
                        </router-link>
                    </li>                         
                       <li class="nav-item">
                      <router-link  :to="'/ShowActivites'" v-on:click.native="setActive('Activites')" :class="{ active: isActive2('Activites'), 'nav-link': navTest }">
                            <i class="fas fa-tasks"></i> Activites
                        </router-link>
                    </li>  
                    <li class="nav-item">
                      <router-link v-on:click.native="setActive('Modules')"  :to="'/ShowModules'"  :class="{ active:isActive2('Modules'), 'nav-link': navTest }">
                            <i class="fas fa-boxes"></i> Modules
                        </router-link>
                    </li>         
                                 
           
                </ul>
   
            </nav>
        </div> 
</template>
<script>
     export default {
        data: () => ({
                isActive : true,
                navTest : true,
                activeItem: 'Statistiques'
        }),
        methods:{
            isActive2: function (menuItem) {
                
                console.log(this.activeItem === menuItem)
                return this.activeItem === menuItem
                },
                setActive: function (menuItem) {
                    console.log("test : ")
                this.activeItem = menuItem // no need for Vue.set()
                }
        }
        
        
        }
</script>

<style scoped>
.sidebar{
    margin-top:45px;
}



</style>