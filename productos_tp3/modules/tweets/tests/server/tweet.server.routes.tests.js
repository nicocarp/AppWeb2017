'use strict';

var should = require('should'),
  request = require('supertest'),
  path = require('path'),
  mongoose = require('mongoose'),
  User = mongoose.model('User'),
  Tweet = mongoose.model('Tweet'),
  express = require(path.resolve('./config/lib/express'));

/**
 * Globals
 */
var app,
  agent,
  credentials,
  user,
  tweet;

/**
 * Tweet routes tests
 */
describe('Tweet CRUD tests', function () {

  before(function (done) {
    // Get application
    app = express.init(mongoose);
    agent = request.agent(app);

    done();
  });

  beforeEach(function (done) {
    // Create user credentials
    credentials = {
      username: 'username',
      password: 'M3@n.jsI$Aw3$0m3'
    };

    // Create a new user
    user = new User({
      firstName: 'Full',
      lastName: 'Name',
      displayName: 'Full Name',
      email: 'test@test.com',
      username: credentials.username,
      password: credentials.password,
      provider: 'local'
    });

    // Save a user to the test db and create new Tweet
    user.save(function () {
      tweet = {
        name: 'Tweet name'
      };

      done();
    });
  });

  it('should be able to save a Tweet if logged in', function (done) {
    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Tweet
        agent.post('/api/tweets')
          .send(tweet)
          .expect(200)
          .end(function (tweetSaveErr, tweetSaveRes) {
            // Handle Tweet save error
            if (tweetSaveErr) {
              return done(tweetSaveErr);
            }

            // Get a list of Tweets
            agent.get('/api/tweets')
              .end(function (tweetsGetErr, tweetsGetRes) {
                // Handle Tweets save error
                if (tweetsGetErr) {
                  return done(tweetsGetErr);
                }

                // Get Tweets list
                var tweets = tweetsGetRes.body;

                // Set assertions
                (tweets[0].user._id).should.equal(userId);
                (tweets[0].name).should.match('Tweet name');

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should not be able to save an Tweet if not logged in', function (done) {
    agent.post('/api/tweets')
      .send(tweet)
      .expect(403)
      .end(function (tweetSaveErr, tweetSaveRes) {
        // Call the assertion callback
        done(tweetSaveErr);
      });
  });

  it('should not be able to save an Tweet if no name is provided', function (done) {
    // Invalidate name field
    tweet.name = '';

    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Tweet
        agent.post('/api/tweets')
          .send(tweet)
          .expect(400)
          .end(function (tweetSaveErr, tweetSaveRes) {
            // Set message assertion
            (tweetSaveRes.body.message).should.match('Please fill Tweet name');

            // Handle Tweet save error
            done(tweetSaveErr);
          });
      });
  });

  it('should be able to update an Tweet if signed in', function (done) {
    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Tweet
        agent.post('/api/tweets')
          .send(tweet)
          .expect(200)
          .end(function (tweetSaveErr, tweetSaveRes) {
            // Handle Tweet save error
            if (tweetSaveErr) {
              return done(tweetSaveErr);
            }

            // Update Tweet name
            tweet.name = 'WHY YOU GOTTA BE SO MEAN?';

            // Update an existing Tweet
            agent.put('/api/tweets/' + tweetSaveRes.body._id)
              .send(tweet)
              .expect(200)
              .end(function (tweetUpdateErr, tweetUpdateRes) {
                // Handle Tweet update error
                if (tweetUpdateErr) {
                  return done(tweetUpdateErr);
                }

                // Set assertions
                (tweetUpdateRes.body._id).should.equal(tweetSaveRes.body._id);
                (tweetUpdateRes.body.name).should.match('WHY YOU GOTTA BE SO MEAN?');

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should be able to get a list of Tweets if not signed in', function (done) {
    // Create new Tweet model instance
    var tweetObj = new Tweet(tweet);

    // Save the tweet
    tweetObj.save(function () {
      // Request Tweets
      request(app).get('/api/tweets')
        .end(function (req, res) {
          // Set assertion
          res.body.should.be.instanceof(Array).and.have.lengthOf(1);

          // Call the assertion callback
          done();
        });

    });
  });

  it('should be able to get a single Tweet if not signed in', function (done) {
    // Create new Tweet model instance
    var tweetObj = new Tweet(tweet);

    // Save the Tweet
    tweetObj.save(function () {
      request(app).get('/api/tweets/' + tweetObj._id)
        .end(function (req, res) {
          // Set assertion
          res.body.should.be.instanceof(Object).and.have.property('name', tweet.name);

          // Call the assertion callback
          done();
        });
    });
  });

  it('should return proper error for single Tweet with an invalid Id, if not signed in', function (done) {
    // test is not a valid mongoose Id
    request(app).get('/api/tweets/test')
      .end(function (req, res) {
        // Set assertion
        res.body.should.be.instanceof(Object).and.have.property('message', 'Tweet is invalid');

        // Call the assertion callback
        done();
      });
  });

  it('should return proper error for single Tweet which doesnt exist, if not signed in', function (done) {
    // This is a valid mongoose Id but a non-existent Tweet
    request(app).get('/api/tweets/559e9cd815f80b4c256a8f41')
      .end(function (req, res) {
        // Set assertion
        res.body.should.be.instanceof(Object).and.have.property('message', 'No Tweet with that identifier has been found');

        // Call the assertion callback
        done();
      });
  });

  it('should be able to delete an Tweet if signed in', function (done) {
    agent.post('/api/auth/signin')
      .send(credentials)
      .expect(200)
      .end(function (signinErr, signinRes) {
        // Handle signin error
        if (signinErr) {
          return done(signinErr);
        }

        // Get the userId
        var userId = user.id;

        // Save a new Tweet
        agent.post('/api/tweets')
          .send(tweet)
          .expect(200)
          .end(function (tweetSaveErr, tweetSaveRes) {
            // Handle Tweet save error
            if (tweetSaveErr) {
              return done(tweetSaveErr);
            }

            // Delete an existing Tweet
            agent.delete('/api/tweets/' + tweetSaveRes.body._id)
              .send(tweet)
              .expect(200)
              .end(function (tweetDeleteErr, tweetDeleteRes) {
                // Handle tweet error error
                if (tweetDeleteErr) {
                  return done(tweetDeleteErr);
                }

                // Set assertions
                (tweetDeleteRes.body._id).should.equal(tweetSaveRes.body._id);

                // Call the assertion callback
                done();
              });
          });
      });
  });

  it('should not be able to delete an Tweet if not signed in', function (done) {
    // Set Tweet user
    tweet.user = user;

    // Create new Tweet model instance
    var tweetObj = new Tweet(tweet);

    // Save the Tweet
    tweetObj.save(function () {
      // Try deleting Tweet
      request(app).delete('/api/tweets/' + tweetObj._id)
        .expect(403)
        .end(function (tweetDeleteErr, tweetDeleteRes) {
          // Set message assertion
          (tweetDeleteRes.body.message).should.match('User is not authorized');

          // Handle Tweet error error
          done(tweetDeleteErr);
        });

    });
  });

  it('should be able to get a single Tweet that has an orphaned user reference', function (done) {
    // Create orphan user creds
    var _creds = {
      username: 'orphan',
      password: 'M3@n.jsI$Aw3$0m3'
    };

    // Create orphan user
    var _orphan = new User({
      firstName: 'Full',
      lastName: 'Name',
      displayName: 'Full Name',
      email: 'orphan@test.com',
      username: _creds.username,
      password: _creds.password,
      provider: 'local'
    });

    _orphan.save(function (err, orphan) {
      // Handle save error
      if (err) {
        return done(err);
      }

      agent.post('/api/auth/signin')
        .send(_creds)
        .expect(200)
        .end(function (signinErr, signinRes) {
          // Handle signin error
          if (signinErr) {
            return done(signinErr);
          }

          // Get the userId
          var orphanId = orphan._id;

          // Save a new Tweet
          agent.post('/api/tweets')
            .send(tweet)
            .expect(200)
            .end(function (tweetSaveErr, tweetSaveRes) {
              // Handle Tweet save error
              if (tweetSaveErr) {
                return done(tweetSaveErr);
              }

              // Set assertions on new Tweet
              (tweetSaveRes.body.name).should.equal(tweet.name);
              should.exist(tweetSaveRes.body.user);
              should.equal(tweetSaveRes.body.user._id, orphanId);

              // force the Tweet to have an orphaned user reference
              orphan.remove(function () {
                // now signin with valid user
                agent.post('/api/auth/signin')
                  .send(credentials)
                  .expect(200)
                  .end(function (err, res) {
                    // Handle signin error
                    if (err) {
                      return done(err);
                    }

                    // Get the Tweet
                    agent.get('/api/tweets/' + tweetSaveRes.body._id)
                      .expect(200)
                      .end(function (tweetInfoErr, tweetInfoRes) {
                        // Handle Tweet error
                        if (tweetInfoErr) {
                          return done(tweetInfoErr);
                        }

                        // Set assertions
                        (tweetInfoRes.body._id).should.equal(tweetSaveRes.body._id);
                        (tweetInfoRes.body.name).should.equal(tweet.name);
                        should.equal(tweetInfoRes.body.user, undefined);

                        // Call the assertion callback
                        done();
                      });
                  });
              });
            });
        });
    });
  });

  afterEach(function (done) {
    User.remove().exec(function () {
      Tweet.remove().exec(done);
    });
  });
});
