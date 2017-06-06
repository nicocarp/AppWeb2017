(function () {
  'use strict';

  angular
    .module('tweets')
    .config(routeConfig);

  routeConfig.$inject = ['$stateProvider'];

  function routeConfig($stateProvider) {
    $stateProvider
      .state('tweets', {
        abstract: true,
        url: '/tweets',
        template: '<ui-view/>'
      })
      .state('tweets.list', {
        url: '',
        templateUrl: '/modules/tweets/client/views/list-tweets.client.view.html',
        controller: 'TweetsListController',
        controllerAs: 'vm',
        data: {
          pageTitle: 'Tweets List'
        }
      })
      .state('tweets.analisis', {
        url: '/analisis',
        templateUrl: '/modules/tweets/client/views/analisis-tweet.client.view.html',
        controller: 'AnalisisTweetsController',
        controllerAs: 'vm',
        data: {
          pageTitle: 'Analisis de TweetsService'
        }
      })
      .state('tweets.create', {
        url: '/create',
        templateUrl: '/modules/tweets/client/views/form-tweet.client.view.html',
        controller: 'TweetsController',
        controllerAs: 'vm',
        resolve: {
          tweetResolve: newTweet
        },
        data: {
          roles: ['user', 'admin'],
          pageTitle: 'Tweets Create'
        }
      })
      .state('tweets.edit', {
        url: '/:tweetId/edit',
        templateUrl: '/modules/tweets/client/views/form-tweet.client.view.html',
        controller: 'TweetsController',
        controllerAs: 'vm',
        resolve: {
          tweetResolve: getTweet
        },
        data: {
          roles: ['user', 'admin'],
          pageTitle: 'Edit Tweet {{ tweetResolve.name }}'
        }
      })
      .state('tweets.view', {
        url: '/:tweetId',
        templateUrl: '/modules/tweets/client/views/view-tweet.client.view.html',
        controller: 'TweetsController',
        controllerAs: 'vm',
        resolve: {
          tweetResolve: getTweet
        },
        data: {
          pageTitle: 'Tweet {{ tweetResolve.name }}'
        }
      });
      
  }

  getTweet.$inject = ['$stateParams', 'TweetsService'];

  function getTweet($stateParams, TweetsService) {
    return TweetsService.get({
      tweetId: $stateParams.tweetId
    }).$promise;
  }

  newTweet.$inject = ['TweetsService'];

  function newTweet(TweetsService) {
    return new TweetsService(); 
  }
}());
