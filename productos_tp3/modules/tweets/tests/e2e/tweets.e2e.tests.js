'use strict';

describe('Tweets E2E Tests:', function () {
  describe('Test Tweets page', function () {
    it('Should report missing credentials', function () {
      browser.get('http://localhost:3001/tweets');
      expect(element.all(by.repeater('tweet in tweets')).count()).toEqual(0);
    });
  });
});
