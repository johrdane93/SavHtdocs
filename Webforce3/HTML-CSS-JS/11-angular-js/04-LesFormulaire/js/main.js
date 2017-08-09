// --initialisation de notre application angular
angular.module('mainApp',['ng-Route'])

/*-----------------------------------
          GESTION DES ROUTES
------------------------------------*/
.config(function($routeProvider){
    $routeProvider
    .when('/',{
      templateURL:'templates/main.htm'
      })

      .when('/Connection',{
           templateURL: 'templates/connection.htm'
      })

      .when('/inscription',{
           templateURL: 'templates/inscription.htm'
      })

      .when('/contact',{
           template:'<h1>Contact</h1>'
      })

})

/*----------------------------------------
            LES CONTROLLER
-----------------------------------------*/
.controller('mainController',['$scope','$http',function($scope){
  $http.get('http://ip-api.com/json/')
  .then(function(response){
    console.log();
  })

}])

.controller('inscriptionController',['$scope',function($scope){

}])

.controller('connectionController',['$scope',function($scope){

}])
