/**
 * Created by marcio on 16/03/2017.
 */
angular.module('app.controllers')
.controller('LoginController',['$scope','$location','OAuth',function ($scope,$locatio,$OAuth) {
    $scope.user = {
        username: '',
        password: ''
    };

    $scope.login = function () {
        OAuth.getAccessToken($scope.user).then(function () {
            $location.path('home');
        }, function () {
            alert('Login inválido!!!');
        });
    };

}]);