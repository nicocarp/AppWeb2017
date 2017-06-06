(function () {
  'use strict';

  angular
    .module('tweets')
    .run(menuConfig);

  menuConfig.$inject = ['menuService'];

  function menuConfig(menuService) {
    // Set top bar menu items
    menuService.addMenuItem('topbar', {
      title: 'Tweets',
      state: 'tweets',
      type: 'dropdown',
      roles: ['*']
    });

    // Add the dropdown list item
    menuService.addSubMenuItem('topbar', 'tweets', {
      title: 'List Tweets',
      state: 'tweets.list'
    });

    // Add the dropdown create item
    menuService.addSubMenuItem('topbar', 'tweets', {
      title: 'Create Tweet',
      state: 'tweets.create',
      roles: ['user']
    });

    /* PROBANDO ANALISIS DE TWITS*/
    menuService.addSubMenuItem('topbar', 'tweets', {
      title: 'Analisis de Tweets',
      state: 'tweets.analisis',
      roles: ['user']
    });
    /* FIN*/
  }
}());
