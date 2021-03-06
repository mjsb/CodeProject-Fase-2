angular.module('app.controllers')
    .controller('ProjectFileEditController',['$scope','$location','$routeParams','ProjectFile',
        function ($scope,$location,$routeParams,ProjectFile) {
            $scope.projectFile = ProjectFile.get({
                id: $routeParams.id,
                idFile: $routeParams.idFile
            });

            $scope.save = function () {
                if($scope.form.$valid) {
                    ProjectFile.update({
                        id: $routeParams.id,
                        idFile: $routeParams.idFile
                    },$scope.projectFile, function () {
                        $location.path('/projeto/'+$routeParams.id+'/arquivos');
                    });
                }
            };

            $scope.project_id = $routeParams.id;
        }
    ]);