angular.module('app.services')
    .service('ProjectNote',['$resource','appConfig',
        function($resource,appConfig) {
            return $resource(
                appConfig.baseUrl + '/projeto/:id/nota/:idNote',{
                    id:'@id',
                    idNote:'@idNote'
                },{
                    update: {
                        method: 'PUT'
                    }
                }
            );
        }
    ]);