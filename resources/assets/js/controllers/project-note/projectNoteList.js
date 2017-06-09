angular.module('app.controllers')
    .controller('ProjectNoteListController',['$scope','$routeParams','ProjectNote',
        function ($scope,$routeParams,ProjectNote) {
            $scope.projectNote = ProjectNote.query({
                id: $routeParams.id
            });
        }
    ]);