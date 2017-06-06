'use strict';

/**
 * Module dependencies.
 */
var path = require('path'),
  mongoose = require('mongoose'),
  Tweet = mongoose.model('Tweet'),
  errorHandler = require(path.resolve('./modules/core/server/controllers/errors.server.controller')),
  _ = require('lodash'), 
  express = require('express'),
  Twitter = require('twitter');


/**
 * Create a Tweet
 */
exports.create = function(req, res) {
  var tweet = new Tweet(req.body);
  tweet.user = req.user;

  tweet.save(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(tweet);
    }
  });
};

/**
 * Show the current Tweet
 */
exports.read = function(req, res) {
  // convert mongoose document to JSON
  var tweet = req.tweet ? req.tweet.toJSON() : {};

  // Add a custom field to the Article, for determining if the current User is the "owner".
  // NOTE: This field is NOT persisted to the database, since it doesn't exist in the Article model.
  tweet.isCurrentUserOwner = req.user && tweet.user && tweet.user._id.toString() === req.user._id.toString();

  res.jsonp(tweet);
};

/**
 * Update a Tweet
 */
exports.update = function(req, res) {
  var tweet = req.tweet;

  tweet = _.extend(tweet, req.body);

  tweet.save(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(tweet);
    }
  });
};

/**
 * Delete an Tweet
 */
exports.delete = function(req, res) {
  var tweet = req.tweet;

  tweet.remove(function(err) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(tweet);
    }
  });
};

/**
 * List of Tweets
 */
exports.list = function(req, res) {
  Tweet.find().sort('-created').populate('user', 'displayName').exec(function(err, tweets) {
    if (err) {
      return res.status(400).send({
        message: errorHandler.getErrorMessage(err)
      });
    } else {
      res.jsonp(tweets);
    }
  });
};

/**
 * Tweet middleware
 */
exports.tweetByID = function(req, res, next, id) {

  if (!mongoose.Types.ObjectId.isValid(id)) {
    return res.status(400).send({
      message: 'Tweet is invalid'
    });
  }

  Tweet.findById(id).populate('user', 'displayName').exec(function (err, tweet) {
    if (err) {
      return next(err);
    } else if (!tweet) {
      return res.status(404).send({
        message: 'No Tweet with that identifier has been found'
      });
    }
    req.tweet = tweet;
    next();
  });
};

exports.analisis = function(req, res) {
  var client = new Twitter({
      consumer_key:         'XEpmSeeUEHkNgga7MN68vFnC1',
      consumer_secret:      'L2XpT8xpmiP9Ia6ySh101YfW0as4Xz33jERfy1ISvgoirPSRGt',
      access_token_key:         '184062783-ZmmgxBXQLpNQS0Fhgi8w5N4P2HsbgzBUY6ZRQvqd',
      access_token_secret:  'Zkm7fDY2MXBYGCGMKFgD7pWQvOaeI3RoGboR8hIS217fa',
       app_only_auth: true
      
    })


  var params = {screen_name: 'd3f0'};
  client.get('statuses/user_timeline', params, function(error, tweets, response) {
    if (!error) {
      console.log(tweets);
      return res.jsonp(tweets);
      
    }else{
      console.log(error);
      return res.jsonp(error);
    }
  });
  //console.log('listo');
  //var tweets = [{"hola":"chau"},{"hola":"chau"},{"hola":"chau"}];
  //return res.jsonp(tweets);
  
};