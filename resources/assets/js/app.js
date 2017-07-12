var app = angular.module('app',['ngRoute','angular-oauth2','app.controllers','app.filters','app.directives','app.services',
    'ui.bootstrap.typeahead','ui.bootstrap.tpls','ui.bootstrap.datepicker','ui.bootstrap.modal','ngFileUpload','http-auth-interceptor',
    'angularUtils.directives.dirPagination','mgcrea.ngStrap.navbar','ui.bootstrap.dropdown']);

angular.module('app.controllers',['ngMessages','angular-oauth2']);
angular.module('app.filters',[]);
angular.module('app.directives',[]);
angular.module('app.services',['ngResource']);

app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider){

    var config = {
        baseUrl:'http://localhost:8000',
        project:{
            status: [
                {value: 1, label: 'Parado'},
                {value: 2, label: 'Iniciado'},
                {value: 3, label: 'Pausado'},
                {value: 4, label: 'Finalizado'}
            ]
        },

        projectTask:{
            status: [
                {value: 1, label: 'Incompleta'},
                {value: 2, label: 'Completa'}
            ]
        },

        urls: {
            projectFile: '/projeto/{{id}}/arquivo/{{idFile}}'
        },

        utils: {
            transformRequest: function (data) {
                if(angular.isObject(data)) {
                    return $httpParamSerializerProvider.$get()(data);
                }
                return data;
            },
            transformResponse: function (data, headers) {
                var headersGetter = headers();
                if(headersGetter['content-type'] == 'application/json' || headersGetter['content-type'] == 'text/json') {
                    var dataJson = JSON.parse(data);
                    if(dataJson.hasOwnProperty('data') && Object.keys(dataJson).length == 1) {
                        dataJson = dataJson.data;
                    }
                    return dataJson;
                }
                return data;
            }
        }
    };

    return {
        config: config,
        $get: function(){
            return config;
        }
    }
}]);

app.config(['$routeProvider','$httpProvider','OAuthProvider','OAuthTokenProvider','appConfigProvider',
    function ($routeProvider,$httpProvider,OAuthProvider,OAuthTokenProvider,appConfigProvider) {

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
        $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;
        $httpProvider.interceptors.splice(0,1);
        $httpProvider.interceptors.splice(0,1);
        $httpProvider.interceptors.push('oauthFixInterceptor');

        $routeProvider

            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController'
            })

            .when('/logout', {
                resolve: {
                    logout: ['$location','OAuthToken',function ($location,OAuthToken) {
                        OAuthToken.removeToken();
                        return $location.path('/login');
                    }]
                }
            })

            .when('/home', {
                templateUrl: 'build/views/home.html',
                controller: 'HomeController',
                title: 'Home'
            })

            .when('/clientes', {
                templateUrl: 'build/views/client/list.html',
                controller: 'ClientListController',
                title: 'Clientes'
            })

            .when('/clientes/dashboard', {
                templateUrl: 'build/views/client/dashboard.html',
                controller: 'ClientDashboardController',
                title: 'Clientes'
            })

            .when('/clientes/novo', {
                templateUrl: 'build/views/client/new.html',
                controller: 'ClientNewController',
                title: 'Novo cliente'
            })

            .when('/cliente/:id/editar', {
                templateUrl: 'build/views/client/edit.html',
                controller: 'ClientEditController',
                title: 'Editar cliente'
            })

            .when('/cliente/:id/excluir', {
                templateUrl: 'build/views/client/remove.html',
                controller: 'ClientRemoveController',
                title: 'Excluir cliente'
            })

            .when('/projetos/dashboard', {
                templateUrl: 'build/views/project/dashboard.html',
                controller: 'ProjectDashboardController',
                title: 'Projetos'
            })

            .when('/projetos', {
                templateUrl: 'build/views/project/list.html',
                controller: 'ProjectListController',
                title: 'Projetos'
            })

            .when('/projeto/novo', {
                templateUrl: 'build/views/project/new.html',
                controller: 'ProjectNewController',
                title: 'Novo projeto'
            })

            .when('/projeto/:id/editar', {
                templateUrl: 'build/views/project/edit.html',
                controller: 'ProjectEditController',
                title: 'Editar projeto'
            })

            .when('/projeto/:id/excluir', {
                templateUrl: 'build/views/project/remove.html',
                controller: 'ProjectRemoveController',
                title: 'Excluir projeto'
            })

            .when('/projeto/:id/notas', {
                templateUrl: 'build/views/project-note/list.html',
                controller: 'ProjectNoteListController',
                title: 'Notas'
            })

            .when('/projeto/:id/nota/:idNote/show', {
                templateUrl: 'build/views/project-note/show.html',
                controller: 'ProjectNoteShowController',
                title: 'Nota'
            })

            .when('/projeto/:id/notas/nova', {
                templateUrl: 'build/views/project-note/new.html',
                controller: 'ProjectNoteNewController',
                title: 'Nova nota'
            })

            .when('/projeto/:id/nota/:idNote/editar', {
                templateUrl: 'build/views/project-note/edit.html',
                controller: 'ProjectNoteEditController',
                title: 'Editar nota'
            })

            .when('/projeto/:id/nota/:idNote/excluir', {
                templateUrl: 'build/views/project-note/remove.html',
                controller: 'ProjectNoteRemoveController',
                title: 'Excluir nota'
            })

            .when('/projeto/:id/arquivos', {
                templateUrl: 'build/views/project-file/list.html',
                controller: 'ProjectFileListController',
                title: 'Arquivos'
            })

            .when('/projeto/:id/arquivos/novo', {
                templateUrl: 'build/views/project-file/new.html',
                controller: 'ProjectFileNewController',
                title: 'Novo arquivo'
            })

            .when('/projeto/:id/arquivo/:idFile/editar', {
                templateUrl: 'build/views/project-file/edit.html',
                controller: 'ProjectFileEditController',
                title: 'Editar arquivo'
            })

            .when('/projeto/:id/arquivo/:idFile/excluir', {
                templateUrl: 'build/views/project-file/remove.html',
                controller: 'ProjectFileRemoveController',
                title: 'Excluir arquivo'
            })

            .when('/projeto/:id/tarefas', {
                templateUrl: 'build/views/project-task/list.html',
                controller: 'ProjectTaskListController',
                title: 'Tarefas'
            })

            .when('/projeto/:id/tarefa/:idTask/show', {
                templateUrl: 'build/views/project-task/show.html',
                controller: 'ProjectTaskShowController',
                title: 'Tarefa'
            })

            .when('/projeto/:id/tarefas/nova', {
                templateUrl: 'build/views/project-task/new.html',
                controller: 'ProjectTaskNewController',
                title: 'Nova tarefa'
            })

            .when('/projeto/:id/tarefa/:idTask/editar', {
                templateUrl: 'build/views/project-task/edit.html',
                controller: 'ProjectTaskEditController',
                title: 'Editar tarefa'
            })

            .when('/projeto/:id/tarefa/:idTask/excluir', {
                templateUrl: 'build/views/project-task/remove.html',
                controller: 'ProjectTaskRemoveController',
                title: 'Excluir tarefa'
            })

            .when('/projeto/:id/membros', {
                templateUrl: 'build/views/project-member/list.html',
                controller: 'ProjectMemberListController',
                title: 'Membros'
            })

            .when('/projeto/:id/membro/:idProjectMember/excluir', {
                templateUrl: 'build/views/project-member/remove.html',
                controller: 'ProjectMemberRemoveController',
                title: 'Excluir membro'
            }

        );

        OAuthProvider.configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: 'app',
            clientSecret: 'secret', // optional
            grantPath: 'oauth/access_token'
        });

        OAuthTokenProvider.configure({
            name: 'Token',
            options: {
                secure: false
            }

        });

    }]);

app.run(['$rootScope', '$location', '$http', '$modal', 'httpBuffer', 'OAuth',
    function($rootScope, $location, $http, $modal, httpBuffer, OAuth) {

        $rootScope.$on('$routeChangeStart', function (event, next, current) {
            if (next.$$route.originalPath != '/login') {
                if (!OAuth.isAuthenticated()) {
                    $location.path('login');
                }
            }
           /* $rootScope.$emit('pusher-build', {next: next});
            $rootScope.$emit('pusher-destroy',{next: next});*/
        });

        $rootScope.$on('$routeChangeSuccess', function(event, current, previous){
            $rootScope.pageTitle = current.$$route.title;
        });

        $rootScope.$on('oauth:error', function(event, data) {
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === data.rejection.data.error) {
                return;
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('access_denied' === data.rejection.data.error) {

               httpBuffer.append(data.rejection.config, data.deferred);

               if(!$rootScope.loginModalOpened) {

                   var modalInstance = $modal.open({

                       templateUrl: 'build/views/templates/loginModal.html',
                       controller: 'LoginModalController'

                   });
                   $rootScope.loginModalOpened = true;
               }
               return;
            }

            // Redirect to `/login` with the `error_reason`.
            return $location.path('/login');
        });

    }
]);