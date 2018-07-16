
var app = angular.module('app', 
	[
		'ngRoute',
		'ngCookies',
		'ngScrollbars',
		'contacts'
		]),
	config = function($routeProvider, $locationProvider, $httpProvider){
		$routeProvider
		.when('/', {
		})
		.when('/login', {
		})
		.when('/register', {
		})
		.when('/contacts', {
			templateUrl: './contacts/contacts.html',
			controller: 'ContactsCtrl'
		})
		.when('/contacts/:id', {
			templateUrl: './contacts/contacts.html',
			controller: 'ContactsCtrl'
		})
		.otherwise({
			redirectTo: '/' 
		});
		
		$httpProvider.interceptors.push('reqInterceptor');
	};
	config.$inject = ['$routeProvider', '$locationProvider', '$httpProvider'];

app.
factory('reqInterceptor', ['$cookieStore', function ($cookieStore) {
	return {
		request:function(config){
			var authBasicData =  $cookieStore.get('auth_basic');
				config.headers['Authorization'] = authBasicData;
			return config;	
		}
	};

}])
.run(['$http', '$cookieStore', function ($http, $cookieStore) {
	var authBasicData =  $cookieStore.get('auth_basic');

	$http.defaults.headers.common['Authorization'] = authBasicData;
}]);
	
app.config(config);

