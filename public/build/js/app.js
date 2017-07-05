var app = angular.module('app',['ngRoute','angular-oauth2','app.controllers','app.filters','app.directives','app.services',
    'ui.bootstrap.typeahead','ui.bootstrap.tpls','ui.bootstrap.datepicker','ngFileUpload']);

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

        $routeProvider

            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController'
            })

            .when('/home', {
                templateUrl: 'build/views/home.html',
                controller: 'HomeController'
            })

            .when('/clientes', {
                templateUrl: 'build/views/client/list.html',
                controller: 'ClientListController'
            })

            .when('/cliente/novo', {
                templateUrl: 'build/views/client/new.html',
                controller: 'ClientNewController'
            })

            .when('/cliente/:id/editar', {
                templateUrl: 'build/views/client/edit.html',
                controller: 'ClientEditController'
            })

            .when('/cliente/:id/excluir', {
                templateUrl: 'build/views/client/remove.html',
                controller: 'ClientRemoveController'
            })

            .when('/projetos', {
                templateUrl: 'build/views/project/list.html',
                controller: 'ProjectListController'
            })

            .when('/projeto/novo', {
                templateUrl: 'build/views/project/new.html',
                controller: 'ProjectNewController'
            })

            .when('/projeto/:id/editar', {
                templateUrl: 'build/views/project/edit.html',
                controller: 'ProjectEditController'
            })

            .when('/projeto/:id/excluir', {
                templateUrl: 'build/views/project/remove.html',
                controller: 'ProjectRemoveController'
            })

            .when('/projeto/:id/notas', {
                templateUrl: 'build/views/project-note/list.html',
                controller: 'ProjectNoteListController'
            })

            .when('/projeto/:id/nota/:idNote/show', {
                templateUrl: 'build/views/project-note/show.html',
                controller: 'ProjectNoteShowController'
            })

            .when('/projeto/:id/nota/nova', {
                templateUrl: 'build/views/project-note/new.html',
                controller: 'ProjectNoteNewController'
            })

            .when('/projeto/:id/nota/:idNote/editar', {
                templateUrl: 'build/views/project-note/edit.html',
                controller: 'ProjectNoteEditController'
            })

            .when('/projeto/:id/nota/:idNote/excluir', {
                templateUrl: 'build/views/project-note/remove.html',
                controller: 'ProjectNoteRemoveController'
            })

            .when('/projeto/:id/arquivos', {
                templateUrl: 'build/views/project-file/list.html',
                controller: 'ProjectFileListController'
            })

            .when('/projeto/:id/arquivo/novo', {
                templateUrl: 'build/views/project-file/new.html',
                controller: 'ProjectFileNewController'
            })

            .when('/projeto/:id/arquivo/:idFile/editar', {
                templateUrl: 'build/views/project-file/edit.html',
                controller: 'ProjectFileEditController'
            })

            .when('/projeto/:id/arquivo/:idFile/excluir', {
                templateUrl: 'build/views/project-file/remove.html',
                controller: 'ProjectFileRemoveController'
            })

            .when('/projeto/:id/tarefas', {
                templateUrl: 'build/views/project-task/list.html',
                controller: 'ProjectTaskListController'
            })

            .when('/projeto/:id/tarefa/:idTask/show', {
                templateUrl: 'build/views/project-task/show.html',
                controller: 'ProjectTaskShowController'
            })

            .when('/projeto/:id/tarefa/nova', {
                templateUrl: 'build/views/project-task/new.html',
                controller: 'ProjectTaskNewController'
            })

            .when('/projeto/:id/tarefa/:idTask/editar', {
                templateUrl: 'build/views/project-task/edit.html',
                controller: 'ProjectTaskEditController'
            })

            .when('/projeto/:id/tarefa/:idTask/excluir', {
                    templateUrl: 'build/views/project-task/remove.html',
                    controller: 'ProjectTaskRemoveController'
            })

            .when('/projeto/:id/membros', {
                templateUrl: 'build/views/project-member/list.html',
                controller: 'ProjectMemberListController'
            })

            .when('/projeto/:id/membro/:idMember/excluir', {
                templateUrl: 'build/views/project-member/remove.html',
                controller: 'ProjectMemberRemoveController'
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

app.run(['$rootScope', '$location', '$window', 'OAuth',
    function($rootScope, $location, $window, OAuth) {

        $rootScope.$on('$routeChangeStart', function (event, next, current) {
            if (next.$$route.originalPath != '/login') {
                if (!OAuth.isAuthenticated()) {
                    $location.path('login');
                }
            }
            $rootScope.$emit('pusher-build', {next: next});
            $rootScope.$emit('pusher-destroy',{next: next});
        });


        $rootScope.$on('oauth:error', function(event, rejection) {
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === rejection.data.error) {
                return;
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('invalid_token' === rejection.data.error) {
                return OAuth.getRefreshToken();
            }

            // Redirect to `/login` with the `error_reason`.
            return $window.location.href = '/login?error_reason=' + rejection.data.error;
        });

    }
]);