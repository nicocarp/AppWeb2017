(function() {
  'use strict';

  angular
    .module('tweets')
    .controller('AnalisisTweetsController', AnalisisTweetsController);

  AnalisisTweetsController.$inject = ['$scope','$state', '$window','$resource', 'Authentication'];


  
  function AnalisisTweetsController($scope,$state, $window, $resource,Authentication, tweet) {
    var vm = this;
    this.tweet = tweet;
    this.probando = [];
    // Analisis tweets controller logic
    // ...
    this.start_analisis = start_analisis;
    init();

    /* INICIAMOS MAPA*/
    function init() {
      var uluru = {lat: -25.363, lng: 131.044};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
    }
    function start_analisis(form_valid){
      // API google maps key AIzaSyCQubOV6_OWyeGdALUwdPPpT2fVGLAUeB0
      console.log(this.tweet);

      console.log("subit");
      
      /* Tirando fruta */
      var probando  = $resource('/api/analisis').query();
      console.log("VER");
      console.log(probando);   

      /* fin fruta*/
    

      //$state.go('tweets.list');
    }
  }
})();
