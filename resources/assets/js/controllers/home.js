/**
 * Created by marcio on 16/03/2017.
 */
angular.module('app.controllers')
.controller('HomeController',['$scope','$cookies',
    function ($scope, $cookies) {

        console.log($cookies.getObject('user').email);

    }
]);