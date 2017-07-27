angular.module('app.controllers')
    .controller('ProjectListController', ['$scope', '$routeParams', 'appConfig', 'Project',
        function($scope, $routeParams, appConfig, Project){

            $scope.projects = [];
            $scope.totalProjects = 0;
            $scope.projectsPerPage = 10;

            $scope.status = appConfig.project.status;

            $scope.pagination = {
                current: 1
            };

            $scope.pageChanged = function(newPage){
                getResultsPage(newPage);
            };

            $scope.getStatus = function($id) {
                for (var i = 0; i < $scope.status.length; i++) {
                    if($scope.status[i].value === $id){
                        return $scope.status[i].label;
                    }
                }
                return "";
            };

            function getResultsPage(pageNumber){
                Project.query({
                    page: pageNumber,
                    limit: $scope.projectsPerPage
                }, function(data){
                    $scope.projects = data.data;
                    $scope.totalProjects = data.meta.pagination.total;
                });
            }

            getResultsPage(1);
        }]);