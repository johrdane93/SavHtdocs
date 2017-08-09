// -- Initialisation de notre application Angular
angular.module('mainApp', ['ngRoute'])

/* --------------------------------
        GESTION DES ROUTES
----------------------------------- */
.config(function($routeProvider) {
    $routeProvider
    .when('/', {
        templateUrl: 'templates/main.htm'
    })
    .when('/connexion', {
        templateUrl: 'templates/connexion.htm',
        controller: 'connexionController'
    })
    .when('/inscription', {
        templateUrl: 'templates/inscription.htm'
    })
    .when('/contact', {
        template: '<h1>Contact</h1>'
    })
})

/* --------------------------------
          LES CONTROLEURS
----------------------------------- */
.controller('mainController', ['$scope', function($scope) {

}])

.controller('connexionController', ['$scope', '$http', function($scope, $http) {
    $http.get('http://ip-api.com/json/')
    .then(function(response) {
        console.log(response);
        $scope.infosip = response.data;
    })
}])