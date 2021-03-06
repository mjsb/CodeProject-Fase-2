angular.module('app.controllers')
    .controller('ProjectNoteListController',['$scope','$routeParams','$compile','$http','$timeout','$window','ProjectNote',
        function ($scope,$routeParams,$compile,$http,$timeout,$window,ProjectNote) {
            $scope.projectNotes = ProjectNote.query({
                id: $routeParams.id
            });

            $scope.project_id = $routeParams.id;

            $scope.print = function(note){
                $http.get('/build/views/templates/projectNoteShow.html').then(function(response){
                    $scope.note = note;
                    var div = $('<div/>');
                    div.html($compile(response.data)($scope));
                    $timeout(function() {
                        var frame = $window.open('','_blank','width=500,height=500');
                        frame.document.open();
                        frame.document.write(div.html());
                        frame.document.close();
                        
                    });
                });

            };
        }
    ]);