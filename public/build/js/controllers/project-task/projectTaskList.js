angular.module('app.controllers')
    .controller('ProjectTaskListController', [
        '$scope','$routeParams','appConfig','ProjectTask',
        function($scope,$routeParams,appConfig,ProjectTask){

            $scope.projectTask = new ProjectTask();
            $scope.project_id = $routeParams.id;
            $scope.status = appConfig.projectTask.status;

            $scope.save = function(){
                if($scope.form.$valid){
                    $scope.projectTask.status = appConfig.projectTask.status[0].value;
                    $scope.projectTask.$save({id: $routeParams.id}).then(function(){
                        $scope.projectTask = new ProjectTask();
                        $scope.loadTask();
                    });
                }
            };

            $scope.loadTask = function(){
                $scope.projectTasks = ProjectTask.query({
                    id: $routeParams.id,
                    orderBy: 'id',
                    sortedBy: 'desc'
                });
            };

            $scope.loadTask();

            $scope.getStatus = function($id) {
                for (var i = 0; i < $scope.status.length; i++) {
                    if($scope.status[i].value === $id){
                        return $scope.status[i].label;
                    }
                }
                return "";
            };

        }]);