<template>
        <div>
            
   <div class="loading" v-show="loading">
          <div class="lds-hourglass"></div>
    </div>
     <div v-show="!loading" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{countEvaluateurs}}</span>
                                    <span class="font-weight-light">évaluateurs</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="icon icon-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{countStagiaire}}</span>
                                    <span class="font-weight-light">stagiaires</span>
                                </div>

                                <div class="h2 text-muted">
                                   <i class="icon icon-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{countResponsable}}</span>
                                    <span class="font-weight-light">Responsables</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="icon icon-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h4 d-block font-weight-normal mb-2">{{countStage}}</span>
                                    <span class="font-weight-light">stages</span>
                                </div>

                                <div class="h2 text-muted">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                        
                   
                <div class="row">
                     <div class="col-md-6">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <canvas id="myChart"></canvas>
                            </div> 
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <canvas id="myLine"></canvas>
                            </div> 
                        </div>
                     </div>                     
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <canvas id="PieChart"></canvas>
                            </div> 
                        </div>
                    </div>
                </div>
                      

     </div>     
     </div> 
</template>
<script>
//import { Line } from 'vue-chartjs'
import Chart from 'chart.js';


export default {
data: () => ({
     loading: false,
    articles: [],
        labels2 :[],
        votes2:[],
        message: "Vue.js & Chart.js",
        labels: ["groupe 1", "groupe 3", "groupe 5", "groupe 4"],
        votes: [120, 60, 40, 100, 40, 70],
        labels2: ["stage 4", "stage 2", "stage 3", "stage 1", "stage 6", "stage 5"],
        votes2: [40, 20, 30, 4, 40, 90],
        labels3: ["validé","non validé"],
        votes3: [90, 10],
        type : "bar",
        countEvaluateurs:"",
        countStagiaire:"",
        countResponsable:"",
        countStage:"",

        
  }),
  created(){
   

  },
   mounted () {
     this.getCountAllEvaluateurs();
     this.getCountAllStagiaires();
     this.getCountAllResponsables();
     this.getCountAllStages();
    var ctx =    document.getElementById("myChart");
    var ctxL =    document.getElementById("myLine");
    var ctxP =    document.getElementById("PieChart");
    
    var myPieChart = new Chart(ctxP ,{
    type: 'pie',
    data: {
                labels: this.labels3,
                    datasets: [
                        {
                            label: "# groupes",
                            data: this.votes3,
                            backgroundColor: [
                                 "rgba(54, 162, 235, 0.6)",
                               "rgba(255, 99, 132, 0.6)",
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ] 
    },
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        }
    }
});


var stackedLine = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: this.labels2,
                    datasets: [
                        {
                            label: "# stages",
                            data: this.votes2,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ] 
    },
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        }
    }
});
this.getArticlePlusVente(ctx);
  
            console.log('---- test labels 2 ')
            console.log(this.labels2)
           
        
        },
         methods: {

                       async getArticlePlusVente(ctx){
                           // this.loading= true;
             
                  var stackedChart = await  new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.labels,
                    datasets: [
                        {
                            label: "# groupes",
                            data: this.votes,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.6)",
                                "rgba(54, 162, 235, 0.6)",
                                "rgba(255, 206, 86, 0.6)",
                                "rgba(75, 192, 192, 0.6)",
                                "rgba(153, 102, 255, 0.6)",
                                "rgba(255, 159, 64, 0.6)"
                            ],
                            borderColor: [
                                "rgba(255,99,132,1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            }); 
            
          },
                       getCountAllEvaluateurs(){
                 
                 axios.get('/getCountAllEvaluateurs')
                .then((response) => { 
                        console.log("nombre Evaluateurs ========= ")
                        console.log(response.data.countEvaluateurs)
                        this.countEvaluateurs = response.data.countEvaluateurs;
                 });
             },
                       getCountAllStagiaires(){
                 
                 axios.get('/getCountAllStagiaires')
                .then((response) => { 
                        console.log("nombre Stagiaire ========= ")
                        console.log(response.data.countStagiaire)
                        this.countStagiaire = response.data.countStagiaire;
                 });
             },
                       getCountAllResponsables(){
                 
                 axios.get('/getCountAllResponsables')
                .then((response) => { 
                        console.log("nombre responsable ========= ")
                        console.log(response.data.countResponsable)
                        this.countResponsable = response.data.countResponsable;
                 });
             },
                       getCountAllStages(){
                 
                 axios.get('/getCountAllStages')
                .then((response) => { 
                        console.log("nombre Stage ========= ")
                        console.log(response.data.countStage)
                        this.countStage = response.data.countStage;
                 });
             },

        
         },
        

 

}
</script>
<style scoped>

</style>