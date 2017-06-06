// Tweets service used to communicate Tweets REST endpoints
(function () {
  'use strict';

  angular
    .module('tweets')
    .factory('TweetsService', TweetsService);

  TweetsService.$inject = ['$resource'];

  function TweetsService($resource) {
    
    return $resource('/api/tweets/:tweetId', 
                      { tweetId: '@_id' }, 
                      { update: { 
                          method: 'PUT'
                        } 
                      }
                    );
  
  }
}());
