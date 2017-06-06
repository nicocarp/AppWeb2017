'use strict';

/**
 * Module dependencies
 */
var tweetsPolicy = require('../policies/tweets.server.policy'),
  tweets = require('../controllers/tweets.server.controller');

module.exports = function(app) {
  // Tweets Routes
  app.route('/api/tweets').all(tweetsPolicy.isAllowed)
    .get(tweets.list)
    .post(tweets.create);

  app.route('/api/tweets/:tweetId').all(tweetsPolicy.isAllowed)
    .get(tweets.read)
    .put(tweets.update)
    .delete(tweets.delete);

  /* Tirando Fruta */
  app.route('/api/analisis/').all()
    .get(tweets.analisis);
    
  /* Fin Fruta */

  // Finish by binding the Tweet middleware
  app.param('tweetId', tweets.tweetByID);
};
