/*var  Raspa = angular.module( 'YourApp', ['ngMaterial','ngRoute','materialCalendar','satellizer'] );

Raspa.directive("formmanual",function(){
    return{
        restrict: 'AE',
        scope: {
            clienteDinamico: '=cliente'
        },
        template:'<h1>hola</h1>',
        link: function(scope, elem, attrs){
            var md5=function(s){
                console.debug(s);
            };
        },
        replace:true
        
    }
});*/

Raspa.controller("calendario",function($scope, $filter,$mdDialog, $mdMedia){
     $scope.dayClick = function(date,ev) {
     
         console.log($filter("date") (date, "y-M-d"));
          var useFullScreen = ($mdMedia('sm') || $mdMedia('xs'))  && $scope.customFullscreen;
        $mdDialog.show({
          controller: DialogController,
          templateUrl: 'modalCalendario.html',
          parent: angular.element(document.body),
          targetEvent: ev,
          clickOutsideToClose:true,
          fullscreen: useFullScreen
        })
        .then(function(answer) {
          $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
          $scope.status = 'You cancelled the dialog.';
        });
         
         
    };
    var holidays = {"2015-01-01":[{"name":"Last Day of Kwanzaa","country":"US","date":"2015-01-01"}]}
    
    $scope.setDayContent = function(date) {

        // You would inject any HTML you wanted for
        // that particular date here.
        //return "<p></p>";

        // You could also use an $http function directly.
        /**return $http.get("/some/external/api");*/

        // You could also use a promise.
        /*var deferred = $q.defer();
        $timeout(function() {
            deferred.resolve("<p></p>");
        }, 1000);
        return deferred.promise;*/

    };
    
});

/*Raspa.controller("cargarAchivo", function(){
    
    this.subirArchivo   =   function(){
        var file    =   this.file;
        console.log(file);
    }
});


Raspa.directive("uploaderModel", function($parse){
    return{
        restrict: 'A',
        link: function(scope,iElement,iAttrs){
            iElement.on("change", function(e){
                $parse(iAttrs.uploaderModel).assign(scope, iElement[0].file[0])
            });
        }
    }
});*/