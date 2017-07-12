angular.module('app.controllers')
    .controller('ClientListController', ['$scope', '$routeParams', 'Client',
        function($scope, $routeParams, Client){

            $scope.clients = [];
            $scope.totalClients = 0;
            $scope.clientsPerPage = 10;

            $scope.pagination = {
                current: 1
            };

            $scope.pageChanged = function(newPage){
                getResultsPage(newPage);
            };

            function getResultsPage(pageNumber){
                Client.query({
                    page: pageNumber,
                    limit: $scope.clientsPerPage
                }, function(data){
                    $scope.clients = data.data;
                    $scope.totalClients = data.meta.pagination.total;
                });
            }

            getResultsPage(1);
        }]);