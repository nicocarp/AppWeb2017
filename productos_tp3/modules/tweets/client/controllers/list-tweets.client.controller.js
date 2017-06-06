(function () {
  'use strict';

  angular
    .module('tweets')
    .controller('TweetsListController', TweetsListController);

  TweetsListController.$inject = ['TweetsService'];

  function TweetsListController(TweetsService) {
    var vm = this;    
    vm.tweets = TweetsService.query();
  }
}());
