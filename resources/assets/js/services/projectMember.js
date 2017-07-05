angular.module('app.services')
    .service('ProjectMember', ['$resource', 'appConfig',
        function($resource,  appConfig){
            return $resource(appConfig.baseUrl + '/projeto/:id/membro/:idProjectMember', {
                id: '@id',
                idProjectMember: '@idProjectMember'
            }, {
                update: {
                    method: 'PUT'
                }
            });
        }
    ]);