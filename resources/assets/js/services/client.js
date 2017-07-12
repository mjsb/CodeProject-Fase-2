angular.module('app.services')
    .service('Client',['$resource','appConfig',
        function($resource,appConfig) {
            return $resource(
                appConfig.baseUrl + '/cliente/:id',{
                    id:'@id'
                },{
                    update: {
                        method: 'PUT'
                    },
                    query: {
                        isArray: false
                    }
                }
            );
        }
    ]);