    var app = angular.module('myApp',[]);
    
     app.controller('PatientPeofileCtrl',function($scope){
        $scope.tabIndex = 1;
        $scope.uploadNew = false;
        $scope.tab = function(index){
            $scope.tabIndex = index;
        }

        $scope.drugs = [1];
        $scope.count = 1;
        $scope.addDrug = function(){
        	$scope.drugs.push(++$scope.count);
        }

        $scope.removeDrug = function($index){
        	$scope.drugs.splice($scope.drugs.indexOf($index),1);
        	console.log($scope.drugs);
        }

        $scope.tests = [1];
        $scope.testCount = 1;

        $scope.addTest = function(){
        	$scope.tests.push(++$scope.testCount);
        }

        $scope.removeTest = function($index){
        	$scope.tests.splice($scope.tests.indexOf($index),1);
        	console.log($scope.tests);
        }

    });

    