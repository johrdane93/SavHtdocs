// -- Initialisation de notre application Angular
angular.module('mainApp', [])

// -- Déclaration de notre Controleur principal
.controller('mainController', ['$scope', function($scope) {
    $scope.identifiants = {};
    $scope.identifiants.connexion = function() {
        console.log($scope.identifiants);
        console.log('FORMULAIRE ENVOYE');
    };
}]);