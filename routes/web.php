<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'HomeController@login');

Route::get('/', 'HomeController@index')->name('Gcommerce');

Route::get('/logout', function(){
    Auth::logout();
   // return "logout";
});
Route::get('/register', 'RegisterController@create')->name('Registre');

//Route::resource('article', 'ArticleController');
     

          //article
  
Route::get('/register', 'RegisterController@create')->name('Registre');


// articles 
Route::post('/addArticle','ArticleController@store');
Route::get('/getArticles','ArticleController@getArticles');
Route::post('/updateArticle','ArticleController@updateArticle');
Route::delete('/deleteArticle/{id_article}','ArticleController@deleteArticle');
Route::get('/getArticle/{id_article}','ArticleController@getArticle');
Route::get('/searchArticles/{desig}','ArticleController@searchArticles');
Route::get('/getAllArticles','ArticleController@getAllArticles');



        //user
//user 
Route::post('/addUsers','Auth\RegisterController@store')->name('addUsers');
Route::get('/getUsers','Auth\RegisterController@getUsers');
Route::delete('/deleteUser/{id}','Auth\RegisterController@destroy');
Route::get('/editUser/{id}','Auth\RegisterController@editUser');
//Route::put('/updateUser','Auth\RegisterController@updateUser');
Route::get('/getProfile','Auth\RegisterController@getProfile');


        //compagnie
Route::post('/addCompagnie','maCompagnieController@store')->name('addCompagnie');
Route::get('/getCompagnies','maCompagnieController@getCompagnies');
Route::delete('/deleteCompagnie/{id_compagnie}','maCompagnieController@deleteCompagnie');
Route::get('/getCompagnie/{id_compagnie}','maCompagnieController@getCompagnie');
Route::post('/updateCompagnie','maCompagnieController@updateCompagnie');
Route::get('/getAllCompagnies','maCompagnieController@getAllCompagnies');

Route::get('/isSuperAdmin','Auth\RegisterController@isSuperAdmin');

//parametres-----------------------------------------------------------
        //famille
Route::post('/addFamille','ParametresController@addFamille');
Route::get('/getfamilles','ParametresController@getfamille');
Route::delete('/deletefamille/{id_famille}','ParametresController@deleteFamille');
        //tva 
Route::post('/addTva','ParametresController@addTva');
Route::get('/getTvas','ParametresController@getTvas');
Route::delete('/deleteTva/{id_tva}','ParametresController@deleteTva');
        //Status 
Route::post('/addStatu','ParametresController@addStatu');
Route::get('/getStatus','ParametresController@getStatus');
Route::get('/getStatu/{id_status}','ParametresController@getStatu');
Route::delete('/deleteStatu/{id_status}','ParametresController@deleteStatu');
        //type paiement
Route::post('/addTypePaiement','ParametresController@addTypePaiement');
Route::get('/getTypePaiement','ParametresController@getTypePaiement');
Route::delete('/deleteTypePaiement/{id_type_paiement}','ParametresController@deleteTypePaiement');
 //---------------------------------------------------------------------       

                //Desponsables
        // ajouter desponsables,commande desponsables, et mode paiement de desponsables
Route::post('/addDesponsables','DesponsablesController@addDesponsables')->name('addDesponsables');
Route::get('/countDesponsables','DesponsablesController@countDesponsables');
Route::get('/getPrixArticle/{fk_article}','DesponsablesController@getPrixArticle');
Route::get('/getDesponsables','DesponsablesController@getDesponsables');
Route::get('/getDesponsablesD/{id_desponsables}','DesponsablesController@getDesponsablesD');
Route::get('/getCommandes/{fk_document}','DesponsablesController@getCommandes');
Route::get('/getPaiement/{fk_document}','DesponsablesController@getPaiement');
Route::get('/tauxTva/{fk_tva_cmd}','DesponsablesController@tauxTva');
Route::post('/updateDesponsables','DesponsablesController@updateDesponsables');
Route::delete('/deleteDesponsables/{id_desponsables}','DesponsablesController@deleteDesponsables');
Route::get('/searchDesponsables/{search_D}','DesponsablesController@searchDesponsables');
Route::post('/updateStatusDesponsables','DesponsablesController@updateStatusDesponsables');

Route::get('/pdf_d/{reference_d}','DesponsablesController@pdf_d');
Route::get('/getDesponsablesCompte/{idCompte}','DesponsablesController@getDesponsablesCompte');


//----------------------------------------------------------------------
//Compte 
Route::post('/addCompte','CompteController@addCompte');
Route::get('/getComptes','CompteController@getComptes');
Route::post('/updateCompte','CompteController@updateCompte');
Route::delete('/deleteCompte/{id_compte}','CompteController@deleteCompte');
Route::get('/getCompte/{id_compte}','CompteController@getCompte');
Route::get('/searchComptes/{nomCompte}','CompteController@searchComptes');
Route::get('/countCompte','CompteController@countCompte');
     
    // compte: client recupere pour les commandes
Route::get('/getClients','CompteController@getClients');
Route::get('/getClient/{id_compte}','CompteController@getClient');

//contact 
Route::post('/addContact','CompteController@addContact');
Route::get('/updateContact','CompteController@updateContact');
Route::get('/getContacts/{fk_compte}','CompteController@getContacts');
Route::get('/getContactPaginate/{fk_compte}','CompteController@getContactPaginate');
// condition facture
Route::post('/addCFacture','CompteController@addCondtionFacture');
Route::post('/updateCFacture','CompteController@updateCondtionFacture');
Route::get('/getCFacture/{fk_compte}','CompteController@getCondtionFacture');

      // compte: remise recupere pour desponsables
Route::get('/getRemise/{fk_compte}','CompteController@getRemise');


     // bonCommande 
Route::post('/addBonCommande','BonCommandeController@addBonCommande');
Route::get('/countBonCommandes','BonCommandeController@countBonCommandes');
Route::get('/getPrixArticle_bc/{fk_article}','BonCommandeController@getPrixArticle_bc');
Route::get('/getCommandes_bc/{fk_document}','BonCommandeController@getCommandes_bc');
Route::get('/getPaiement_bc/{fk_document}','BonCommandeController@getPaiement_bc');
Route::get('/tauxTva_bc/{id_tva}','BonCommandeController@tauxTva_bc');

Route::get('/getBonCommandes','BonCommandeController@getBonCommandes');
Route::get('/getBonCommande/{id_bc}','BonCommandeController@getBonCommande');
Route::get('/searchBonCommande/{search_BC}','BonCommandeController@searchBonCommande');
Route::get('/getBonCommandesCompte/{idCompte}','BonCommandeController@getBonCommandesCompte');



Route::delete('/deleteBonCommande/{id_bc}','BonCommandeController@deleteBonCommande');
Route::get('/showBonCommande/{reference_bc}','BonCommandeController@showBonCommande');
Route::post('/UpdateBonCommande','BonCommandeController@UpdateBonCommande');


Route::get('/pdf/{reference_bc}','BonCommandeController@pdf');

Route::post('/updateStatusBC','BonCommandeController@updateStatusBC');
 //---------------------------------------------------------------------       

                //Factures
        // ajouter Factures,commande Factures, et mode paiement de Factures
        Route::post('/addFacture','FactureController@addFacture')->name('addFacture');
        Route::get('/countFactures','FactureController@countFactures');
        Route::get('/getPrixArticle_f/{fk_article}','FactureController@getPrixArticle_f');
        Route::get('/getFactures','FactureController@getFactures');
        Route::get('/getFactureF/{id_facture}','FactureController@getFactureF');
        Route::post('/updateFacture','FactureController@updateFacture');
        Route::delete('/deleteFacture/{id_facture}','FactureController@deleteFacture');
        Route::post('/updateStatusFacture','FactureController@updateStatusFacture');
        Route::get('/pdf_f/{reference_f}','FactureController@pdf_f');
        Route::get('/getFacturesCompte/{idCompte}','FactureController@getFacturesCompte');

      
        Route::get('/getsum/{fk_article}','FactureController@getsum');
 //---------------------------------------------------------------------       

                //AvoirFactures
        // ajouter AvoirFactures,commande AvoirFactures, et mode paiement de AvoirFactures
        Route::post('/addAvoirFacture','AvoirFactureController@addAvoirFacture')->name('addAvoirFacture');
        Route::get('/countAvoirFactures','AvoirFactureController@countAvoirFactures');
        Route::get('/getPrixArticle_af/{fk_article}','AvoirFactureController@getPrixArticle_af');
        Route::get('/getAvoirFactures','AvoirFactureController@getAvoirFactures');
        Route::get('/getAvoirFactureAF/{id_af}','AvoirFactureController@getAvoirFactureAF');
        Route::post('/updateAvoirFacture','AvoirFactureController@updateAvoirFacture');
        Route::delete('/deleteAvoirFacture/{id_af}','AvoirFactureController@deleteAvoirFacture');
        Route::post('/updateStatusAvoirFacture','AvoirFactureController@updateStatusAvoirFacture');
        Route::get('/pdf_af/{reference_af}','AvoirFactureController@pdf_af');
        Route::get('/getAvoirFacturesCompte/{idCompte}','AvoirFactureController@getAvoirFacturesCompte');
//----------------------------------------------------------------------

// bon livraison 
Route::post('/addBonLivraison','BonLivraisonController@addBonLivraison');
Route::get('/countBonLivraisons','BonLivraisonController@countBonLivraisons');
Route::get('/getPrixArticle_bl/{fk_article}','BonLivraisonController@getPrixArticle_bl');
Route::get('/getCommandes_bl/{fk_document}','BonLivraisonController@getCommandes_bl');
Route::get('/getPaiement_bl/{fk_document}','BonLivraisonController@getPaiement_bl');
Route::get('/tauxTva_bl/{id_tva}','BonLivraisonController@tauxTva_bl');

Route::get('/getBonLivraisons','BonLivraisonController@getBonLivraisons');
Route::get('/getBonLivraison/{id_bl}','BonLivraisonController@getBonLivraison');
Route::get('/searchBonLivraison/{search_BL}','BonLivraisonController@searchBonLivraison');
Route::get('/getBonLivraisonsCompte/{idCompte}','BonLivraisonController@getBonLivraisonsCompte');



Route::delete('/deleteBonLivraison/{id_bl}','BonLivraisonController@deleteBonLivraison');
Route::get('/showBonLivraison/{reference_bl}','BonLivraisonController@showBonLivraison');
Route::post('/UpdateBonLivraison','BonLivraisonController@UpdateBonLivraison');


Route::get('/pdfBL/{reference_bl}','BonLivraisonController@pdf');

Route::post('/updateStatusBL','BonLivraisonController@updateStatusBL');

   
//pour facture
Route::get('/getBonLivraisonBL/{id_bl}','FactureController@getBonLivraisonBL');



//Dashboard 
Route::get('/getArticlePlusVente','DashboardController@getArticlePlusVente');










//----------------------------------------------------------Gestion Stagiaires
//Responsable
Route::post('/addUser','ResponsableController@addUser');
Route::post('/addResponsable','ResponsableController@addResponsable');
Route::get('/countUser','ResponsableController@countUser');
Route::get('/getResponsables','ResponsableController@getResponsables');
Route::get('/getResponsable/{id_responsable}','ResponsableController@getResponsable');
Route::delete('/deleteResponsable/{fk_user}','ResponsableController@deleteResponsable');
//Route::post('/updateUser','ResponsableController@updateUser');
Route::post('/updateResponsable','ResponsableController@updateResponsable');
Route::get('/searchResponsable/{search_R}','ResponsableController@searchResponsable');

//Service
Route::post('/addService','ServiceController@addService');
Route::get('/getServices','ServiceController@getServices');
Route::get('/getServicesS','ServiceController@getServicesS');

Route::get('/getService/{id_Service}','ServiceController@getService');
Route::delete('/deleteService/{fk_user}','ServiceController@deleteService');
Route::post('/updateService','ServiceController@updateService');
Route::get('/searchService/{search_S}','ServiceController@searchService');

//Hospitalier
Route::post('/addHospitalier','HospitalierController@addHospitalier');
Route::get('/getHospitaliers','HospitalierController@getHospitaliers');
Route::get('/getHospitalier/{id_hospitalier}','HospitalierController@getHospitalier');
Route::get('/getService_Hospitalier/{id_hospitalier}','HospitalierController@getService_Hospitalier');
Route::delete('/deleteHospitalier/{id_hospitalier}','HospitalierController@deleteHospitalier');
Route::post('/updateHospitalier','HospitalierController@updateHospitalier');
Route::get('/searchHospitalier/{search_H}','HospitalierController@searchHospitalier');
//groupe
Route::post('/addGroupe','GroupeController@addGroupe');
Route::get('/getGroupes','GroupeController@getGroupes');
Route::delete('/deleteGroupe/{id_groupe}','GroupeController@deleteGroupe');

Route::get('/getGroupe/{id_groupe}','GroupeController@getGroupe');
Route::get('/getCalendriers/{fk_groupe}','GroupeController@getCalendriers');
Route::post('/updateGroupe','GroupeController@updateGroupe');


Auth::routes();





