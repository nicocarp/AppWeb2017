(function() {
  'use strict';

  angular
    .module('tweets')
    .controller('AnalisisTweetsController', AnalisisTweetsController);

  AnalisisTweetsController.$inject = ['$scope','$state', '$window','$resource', 'Authentication'];


  
  function AnalisisTweetsController($scope,$state, $window, $resource,Authentication, tweet) {
    var vm = this;
    if (!tweet)
      this.tweet = {'latlong':0};
    else
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
          center:   {lat: -43.24895, lng: -65.30505}
        });
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;
        // Try HTML5 geolocation.
        map.addListener('click', function(e) {
          $scope.vm.tweet.latlong = e.latLng.lat()+', '+e.latLng.lng();
          $scope.vm.tweet.nombre_loc = geocodeLatLng(geocoder, map, infowindow);
          $scope.$apply();          
      });
        var marker = new google.maps.Marker({
          position: {lat: -43.24895, lng: -65.30505},
          map: map
        });

        function geocodeLatLng(geocoder, map, infowindow) {
          var input = $scope.vm.tweet.latlong;          
          var latlngStr = input.split(',', 2);
          var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
          geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK' && results[1])  {
                $scope.vm.tweet.nombre_loc = results[1].formatted_address;
                $scope.$apply();
              }
            else {                
                $scope.vm.tweet.nombre_loc = "Not found";
                $scope.$apply();                
                //window.alert('No results found'); MOSTRAR ERROR ANGULAR
              }            
          });
       }
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
