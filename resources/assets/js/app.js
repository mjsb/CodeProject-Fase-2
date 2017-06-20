var app = angular.module('app',['ngRoute','angular-oauth2','app.controllers','app.filters','app.services']);

angular.module('app.controllers',['ngMessages','angular-oauth2']);
angular.module('app.filters',[]);
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

        .when('/cliente', {
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

        .when('/projeto', {
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

        .when('/projeto/:id/nota', {
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

app.run(['$rootScope', '$window', 'OAuth', function($rootScope, $window, OAuth) {

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

}]);