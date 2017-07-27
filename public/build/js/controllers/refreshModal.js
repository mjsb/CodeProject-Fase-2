angular.module('app.controllers')
    .controller('RefreshModalController',
        ['$rootScope','$scope','$location','$interval','$modalInstance','authService','OAuth','OAuthToken','User',
            function ($rootScope, $scope, $location, $interval, $modelInstance, authService, OAuth, OAuthToken, User) {

                $scope.$on('event::auth-loginConfirmed', function () {
                    $rootScope.loginModalOpened = false;
                    $modelInstance.close();
                });

                $scope.$on('$routeChangeStart', function () {
                    $rootScope.loginModalOpened = false;
                    $modelInstance.dismiss('cancel');
                });

                $scope.$on('event::auth-loginCancelled', function () {
                    OAuthToken.removeToken();
                });

                $scope.cancel = function () {
                    authService.loginCancelled();
                    $location.path('login');
                };

                OAuth.getRefreshToken().then(function () {
                    $interval(function(){
                        authService.loginConfirmed();
                        $modelInstance.close();
                    }, 20000);
                }, function (data) {
                    $scope.cancel();
                });

            }]);