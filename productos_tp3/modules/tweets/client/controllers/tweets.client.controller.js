(function () {
  'use strict';

  // Tweets controller
  angular
    .module('tweets')
    .controller('TweetsController', TweetsController);

  TweetsController.$inject = ['$scope', '$state', '$window', 'Authentication', 'tweetResolve'];

  function TweetsController ($scope, $state, $window, Authentication, tweet) {
    var vm = this;
    
    vm.authentication = Authentication;
    vm.tweet = tweet;
    vm.error = null;
    vm.form = {};
    vm.remove = remove;
    vm.save = save;

    // Remove existing Tweet
    function remove() {
      if ($window.confirm('Are you sure you want to delete?')) {
        vm.tweet.$remove($state.go('tweets.list'));
      }
    }

    // Save Tweet
    function save(isValid) {
      if (!isValid) {
        $scope.$broadcast('show-errors-check-validity', 'vm.form.tweetForm');
        return false;
      }

      // TODO: move create/update logic to service
      if (vm.tweet._id) {
        vm.tweet.$update(successCallback, errorCallback);
      } else {
        vm.tweet.$save(successCallback, errorCallback);
      }

      function successCallback(res) {
        $state.go('tweets.view', {
          tweetId: res._id
        });
      }

      function errorCallback(res) {
        vm.error = res.data.message;
      }
    }
  }
}());
