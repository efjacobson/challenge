<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Article Challenge</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
  <link href="styles/main.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="body" ng-app="challengeApp">
  <div class="navbar navbar-default navbar-inverse" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="navbar-brand">
        <a href="#">
          <div class="logo">
            <img class="logo-tmz" src="images/logo_tmz.svg" class="logo" alt="logo" />
          </div>
        </a>
      </div>
    </div>
    <div class="navbar-collapse navbar-main">
      <ul class="nav navbar-nav navbar-left">
        <li><a ng-click="challengeController.getAllArticles()" href="#!/admin">Admin List</a></li>
        <li><a href="#">Categories</a></li>
        <li><a href="#">Photos</a></li>
        <li><a href="#">People</a></li>
        <li><a href="#">Tour</a></li>
      </ul>
    </div>
  </div>
  <div ng-controller="challengeController as challengeController">
    <toaster-container></toaster-container>
    <div ng-view></div>
  </div>
</body>
<script src="http://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.0/angular-route.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slideout/1.0.1/slideout.min.js"></script>
  <script src="https://code.angularjs.org/1.6.0/angular-animate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angularjs-toaster/1.1.0/toaster.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/angularjs-toaster/1.1.0/toaster.min.css" rel="stylesheet" />
<script type="text/javascript">

</script>
<script>
(function() {
  'use strict';

  jQuery(function($) {
    $('.navbar-toggle').click(function() {
      $('.navbar-collapse').toggleClass('right');
      $('.navbar-toggle').toggleClass('sidebar');
    });
  });

  $('.nav > li').click(function() {
    if ($(window).width() < 769) {
      $('.navbar-collapse').toggleClass('right');
      $('.navbar-toggle').toggleClass('sidebar');
    }

});
})();

(function() {
  'use strict';

  angular.module('challengeApp', ['ngRoute', 'toaster']);
})();

(function() {
  'use strict';

  angular.module('challengeApp')
    .config(['$routeProvider',

      function($routeProvider) {
        $routeProvider.when('/', {
          templateUrl: 'views/list.html'
        }).when('/create', {
          templateUrl: 'views/create.html'
        }).when('/admin', {
          templateUrl: 'views/list-admin.html'
        }).otherwise({
          templateUrl: 'views/list.html'
        });
      }
    ]);
})();

(function() {
  'use strict';

  angular
    .module('challengeApp')
    .factory('challengeFactory', challengeFactory);

  challengeFactory.$inject = ['$http', '$q'];

  function challengeFactory($http, $q) {
    var factory = {
      getAllArticles: _getAllArticles,
      getArticle: _getArticle
    };

    return factory;

    function _getAllArticles() {
      var _deferred = $q.defer();

      $http({
        method: 'GET',
        url: '/api.php/article'
      }).then(function(response) {
        _deferred.resolve(response.data.article)
      }, function(response) {
        _deferred.reject(response)
      });

      return _deferred.promise;
    }

    function _getArticle(id) {
      var _deferred = $q.defer();

      $http({
        method: 'GET',
        url: 'api.php/article/' + id
      }).then(function(response) {
        _deferred.resolve(response)
      }, function(response) {
        _deferred.reject(response)
      });

      return _deferred.promise;
    }
  }
})();

(function() {
  'use strict';

  angular
    .module('challengeApp')
    .service('challengeService', challengeService);

  challengeService.$inject = ['$http', '$q'];

  function challengeService($http, $q) {
    this.createArticle = _createArticle;
    this.updateArticle = _updateArticle;
    this.deleteArticle = _deleteArticle;

    function _createArticle(title, description, image) {
      var _deferred = $q.defer();

      var data = {
        title: title,
        description: description
      }

      if(image) {
        image += '.jpg';
        data.image = image;
      }

      $http({
        method: 'POST',
        url: '/api.php/article',
        data: data
      }).then(function(response) {
        _deferred.resolve(response)
      }, function(response) {
        _deferred.reject(response)
      });

      return _deferred.promise;
    }

    function _updateArticle(id, title, description, image) {
      var _deferred = $q.defer();

      var data = {
        title: title,
        description: description
      }

      if(image) {
        image += '.jpg';
        data.image = image;
      }

      $http({
        method: 'PUT',
        url: '/api.php/article/' + id,
        data: data
      }).then(function(response) {
        _deferred.resolve(response)
      }, function(response) {
        _deferred.reject(response)
      });

      return _deferred.promise;
    }

    function _deleteArticle(id) {
      var _deferred = $q.defer();

      $http({
        method: 'DELETE',
        url: '/api.php/article/' + id
      }).then(function(response) {
        _deferred.resolve(response)
      }, function(response) {
        _deferred.reject(response)
      });

      return _deferred.promise;
    }
  }
})();

(function() {
  'use strict';

  angular
    .module('challengeApp')
    .controller('challengeController', challengeController);

  challengeController.$inject = ['$http', '$location', 'toaster', 'challengeFactory', 'challengeService'];

  function challengeController($http, $location, toaster, challengeFactory, challengeService) {
    var vm = this;
    vm.schema = null;
    vm.articles = null;
    vm.title = null;
    vm.description = null;
    vm.currentArticleId = null;
    vm.createOrEdit = null;
    // vm.file = null;
    // vm.errFile = null;

    vm.howToOrderOptions = [
      {id: '1', name: 'title'},
      {id: '2', name: 'date'}
    ];

    vm.createOrUpdate = _createOrUpdate;
    vm.getArticle = _getArticle;
    vm.getAllArticles = _getAllArticles;
    vm.editArticle = _editArticle;
    vm.clearSelected = _clearSelected;
    vm.delete = _delete;

    activate();

    function activate() {
      _getAllArticles();
    }

    function _getAllArticles() {
      challengeFactory.getAllArticles()
        .then(
          function(response) {
            vm.schema = response.columns;
            vm.articles = response.records.map(function(item) {
              return {
                'id': item[0],
                'title': item[1],
                'description': item[2],
                'image': item[3],
                'date': item[4]
              }
            });
            console.log(vm.articles);
          },
          function(response) {
            _onError(response);
          }
        )
    }

    function _getArticle() {
      challengeFactory.getArticle(vm.currentArticleId)
        .then(
          function(response) {
            vm.title = response.data.title;
            vm.description = response.data.description;
          },
          function(response) {
            _onError(response);
          }
        )
    }

    function _createOrUpdate() {
      var uniqueId = '';
      if (document.getElementById('image_file').files[0]) {
        var timeStamp = (new Date()).toISOString().replace(/[^0-9]/g, "");
        var randomString = Math.random().toString(36).substring(7);
        uniqueId = timeStamp + '-' + randomString;
      }
      if (!vm.currentArticleId) {
        challengeService.createArticle(vm.title, vm.description, uniqueId)
          .then(
            function(response) {
              _uploadImage(uniqueId);
              _onSuccess('The article was created.');
            },
            function(response) {
              _onError(response);
            }
          );
      } else {
        challengeService.updateArticle(vm.currentArticleId, vm.title, vm.description, uniqueId)
          .then(
            function(response) {
              _uploadImage(uniqueId);
              _onSuccess('The article was updated.');
            },
            function(response) {
              _onError(response);
            }
          )
      }
    }

    function _onError(response) {
            toaster.pop({
                type: 'error',
                title: 'Uh Oh!',
                body: 'Something went wrong. You should make fun of Eric.',
                showCloseButton: true
            });
            console.log(response);
    }

    function _onSuccess(message) {

                            toaster.pop({
                type: 'success',
                title: 'You did it!',
                body: message,
                showCloseButton: true
            });
              _getAllArticles();
    }

    function _uploadImage(uniqueId) //t=this
    {
      if(uniqueId) {
        var file = document.getElementById('image_file').files[0];

        var img = document.createElement("img");
        var reader = new FileReader();
        reader.onload = (function(aImg) {
          return function(e) {
            aImg.src = e.target.result;
            var file = aImg.src;
            $http({
              method: 'POST',
              url: '/challenge/upload.php?' + uniqueId,
              data: file
            }).then(function(response) {
              console.log(response.data);
            }, function(response) {
              _onError();
            });
          };
        })(img);
        reader.readAsDataURL(file);
      }
    }

    function _delete() {
      challengeService.deleteArticle(vm.currentArticleId)
        .then(
          function(response) {
            _onSuccess('The article was deleted.');
            _getAllArticles();
            $location.path('/admin');
          },
          function(response) {
            _onError(response);
          }
        )
    }

    function _editArticle(id, title, description) {
      vm.currentArticleId = id;
      vm.title = title;
      vm.description = description;
      $location.path('/create');
    }

    function _clearSelected() {
      if (vm.currentArticleId) {
        vm.currentArticleId = null;
        vm.title = null;
        vm.description = null;
      }
    }
  }
})();
</script>
</body>

</html>
