 angular.module('app')

.factory('Preguntas_Voto', ['$resource', 'CONFIG', function ($resource, CONFIG) {
      var Preguntas_Voto = {
        get:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/preguntas_voto/:id', null, {
          'get' : { method:'GET', headers: {'Authorization': params.token }}
        });
        return res.get({id:params.id});
        },
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/preguntas_voto/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({preguntas_voto:params.id});
        },
        update:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/preguntas_voto/:id', null, {
          'update' : { method:'PUT', headers: {'Authorization': params.token }}
        });
        return res.update({preguntas_voto:params.id});
        },
        delete:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/preguntas_voto/:id', null, {
          'delete' : { method:'DELETE', headers: {'Authorization': params.token }}
        });
        return res.delete({id:params.id});
        }
      };
 
      return Preguntas_Voto;
  }])
  .factory('Mensaje_Tema', ['$resource','CONFIG', function ($resource, CONFIG) {
     var Mensaje_Tema = {
        get:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/mensaje_tema/:id', null, {
          'get' : { method:'GET', headers: {'Authorization': params.token }}
        });
        return res.get({id:params.id});
        },
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/mensaje_tema/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({mensaje_tema:params.id});
        },
        update:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/mensaje_tema/:id', null, {
          'update' : { method:'PUT', headers: {'Authorization': params.token }}
        });
        return res.update({mensaje_tema:params.id});
        },
        delete:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/mensaje_tema/:id', null, {
          'delete' : { method:'DELETE', headers: {'Authorization': params.token }}
        });
        return res.delete({id:params.id});
        }
      };
 
      return Mensaje_Tema;
  }])
  .factory('Usuario_Tema', ['$resource','CONFIG', function ($resource, CONFIG) {
     var Usuario_Tema = {
        get:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/usuario_tema/:id', null, {
          'get' : { method:'GET', headers: {'Authorization': params.token }}
        });
        return res.get({id:params.id});
        },
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/usuario_tema/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({usuario_tema:params.id});
        },
        update:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/usuario_tema/:id', null, {
          'update' : { method:'PUT', headers: {'Authorization': params.token }}
        });
        return res.update({usuario_tema:params.id});
        },
        delete:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/usuario_tema/:id', null, {
          'delete' : { method:'DELETE', headers: {'Authorization': params.token }}
        });
        return res.delete({id:params.id});
        }
      };
 
      return Usuario_Tema;
  }])

  .factory('Temas', ['$resource', 'CONFIG', function ($resource, CONFIG) {
     var Temas = {
        get:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR + '/temas/:id', null, {
          'get' : { method:'GET', headers: {'Authorization': params.token }}
        });
        return res.get({id:params.id});
        },
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR + '/temas/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({tema:params.id});
        },
        update:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR + '/temas/:id', null, {
          'update' : { method:'PUT', headers: {'Authorization': params.token }}
        });
        return res.update({tema:params.id});
        }
      };
 
    return Temas;
  }])
  .factory('Usuarios', ['$resource', 'CONFIG', function ($resource, CONFIG) {
     var Usuarios = {
        get:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/usuarios/:id', null, {
          'get' : { method:'GET', headers: {'Authorization': params.token }}
        });
        return res.get({id:params.id});
        },
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/usuarios/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({usuario:params.id});
        },
        update:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/usuarios/:id', null, {
          'update' : { method:'PUT', headers: {'Authorization': params.token }}
        });
        return res.update({usuario:params.id});
        }
      };
 
      return Usuarios;
  }])

  .factory('Mensajes', ['$resource', 'CONFIG', function ($resource, CONFIG) {
     var Mensajes = {
        get:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR+'/mensajes/:id', null, {
          'get' : { method:'GET', headers: {'Authorization': params.token }}
        });
        return res.get({id:params.id});
        },
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR+'/mensajes/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({mensaje:params.id});
        }
      };
 
      return Mensajes;
  }])

  .factory('Preguntas', ['$resource', 'CONFIG', function ($resource, CONFIG) {
     var Preguntas = {
        get:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/preguntas/:id', null, {
          'get' : { method:'GET', headers: {'Authorization': params.token }}
        });
        return res.get({id:params.id});
        },
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/preguntas/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({pregunta:params.id});
        },
        update:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR +'/preguntas/:id', null, {
          'update' : { method:'PUT', headers: {'Authorization': params.token }}
        });
        return res.update({pregunta:params.id});
        }
      };
 
      return Preguntas;
  }])

  .factory('Tokens', ['$resource', 'CONFIG', function ($resource, CONFIG) {
     var Tokens = {
        save:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR+'/tokens/:id', null, {
          'save' : { method:'POST', headers: {'Authorization': params.token }}
        });
        return res.save({token:params.id});
        },
        delete:function(params) {
        var res = $resource(CONFIG.URL_SERVIDOR+'/tokens/:id', null, {
          'delete' : { method:'DELETE', headers: {'Authorization': params.token }}
        });
        return res.delete({id:params.id});
        }
      };
 
      return Tokens;
  }]);