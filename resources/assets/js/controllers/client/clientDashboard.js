angular.module('app.controllers')
    .controller('ClientDashboardController', ['$scope','$location','$routeParams','appConfig','Client',
        function ($scope, $location, $routeParams, appConfig, Client) {

            $scope.client = {};
            $scope.status = appConfig.project.status;

            Client.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 8
            }, function (response) {
                $scope.clients = response.data;
            });

            $scope.showClient = function (client) {
                $scope.client = client;
            };

            $scope.getStatus = function($id) {
                for (var i = 0; i < $scope.status.length; i++) {
                    if($scope.status[i].value === $id){
                        return $scope.status[i].label;
                    }
                }
                return "";
            };

        }]);