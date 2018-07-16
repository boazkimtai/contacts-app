
var contactsCtrl = function ($scope, $rootScope,  $location, contactsService, authService) {
	$scope.contacts = contactsService.contacts;
	$scope.isLoading = contactsService.isLoading;
	
	contactsService.all()
	.then(function(){
		$scope.contacts = contactsService.contacts;
		$scope.isLoading = false;
	})
	.catch(function(e){
		console.log(e);
	});

	$scope.config = {
		axis:'y',
    	autoHideScrollbar: true,
    	theme: 'dark',
    	advanced:{
    	    updateOnContentResize: true
    	},
    	setHeight: 200,
     	scrollInertia: 0
    }

	$scope.search = function(){
		if(!$scope.q){
			$scope.contacts = contactsService.contacts;
			return;
		} else {
			$scope.contacts = contactsService.search($scope.q.toString());
		}
	}

	$scope.logout = function(){
		authService.logout();
	}

	$rootScope.$on('redirect-to-index', function(){
	});
};

contacts.controller('ContactsCtrl', ['$scope', '$rootScope', '$location', 'contactsService', 'authService', contactsCtrl]);
