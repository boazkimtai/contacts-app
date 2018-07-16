
	app.directive('loginForm', ['authService', '$location', function (authService, $location) {
		return {
			restrict: 'E',
			scope:{
			},
			link: function (scope, elem, attrs) {
				scope.user = {
					email:null,
					password:null
				};

				scope.error = '';

				scope.isSaving = false;

				scope.login = function(){
					scope.isSaving = true;

					authService.login(scope.user)
					.then(function(res){
						$location.path('/contacts');

						scope.isSaving = false;
					})
					.catch(function(e){
						scope.isSaving = false;

						if(e.data.code == 'BAD_AUTHENTICATION_DATA'){
							scope.error = 'Wrong email or password';
						} else {
							scope.error = 'An error ocurred. Try again';
						}
					});
				}
			},
			templateUrl:'./partials/login-form.html',
		};
	}])
	.directive('registerForm', ['registerService', '$location', function (registerService, $location) {
		return {
			restrict: 'E',
			scope:{
			},
			link: function (scope, elem, attrs) {
				scope.user = {
					name:"",
					email:"",
					password:""
				};

				scope.error = '';

				scope.isSaving = false;

				scope.register = function(){
					scope.isSaving = true;
					scope.emailExists = false;

					scope.$watch('user.email', function(a, b){
						scope.emailExists = false;
					});

					return registerService.create(scope.user)
					.then(function(){
						scope.user = {
							name:'',
							email:'',
							password:''
						};

						scope.isSaving = false;

						$location.path('/contacts');
					})
					.catch(function(e){
						if(e.data.errors.email) {
							scope.emailExists = true;
						} else {
							scope.error = 'An error occured. Try again';
						}
						
						scope.isSaving = false;
					});
				}
			},
			templateUrl:'./partials/register-form.html'
		};
	}])
	.directive('srformBucket', ['$rootScope', 'authService', '$location', '$routeParams', '$cookieStore',
		function ($rootScope, authService, $location, $routeParams, $cookieStore) {
		return {
			restrict: 'A',
			scope:true,
			link: function (scope, elem, attrs) {
				scope.tab = null;

				scope.switchTab = function(tab){
					scope.tab = tab;
					$location.path(tab == '0' ? '/login' : '/register');
				};

				scope.loginWithCookies = function(){
					cookies = $cookieStore.get('auth_basic');

					if(cookies){
						authService.autoLogin()
						.then(function(){
							$location.path('/contacts');
						});
					}
				};

				scope.$on('$locationChangeSuccess', function(){
					var path = $location.path();

					if(path == '/' || path == '/login') {
						scope.tab = '0';

						scope.loginWithCookies();
					} else if(path == '/register'){
						scope.tab = '1';

						scope.loginWithCookies();
					} else {
						scope.tab = null;
					}
				});
			}
		};
	}])
	.directive('contactItemCard', ['contactService', '$location', function (contactService, $location) {
		return {
			restrict: 'E',
			scope:{
				data:'=',
			},
			link: function (scope, elem, attrs) {
				scope.cs = contactService;
				scope.isActive = false;
				
				scope.$watch(function(){
					if(contactService.contact){
						scope.isActive = contactService.contact.id == scope.data.id?true:false;
					}
				});

				elem.on('click', function(){
					contactService.contact = scope.data;
					$location.path('/contacts/' + scope.data.id);

					scope.$apply();
				});
			},
			templateUrl:'./partials/contact-item-card.html'
		};
	}])
	.directive('contactItem', 
		['$rootScope', 'contactsService', 'contactService', '$location', '$routeParams', '$cookieStore', 
		function ($rootScope, contactsService, contactService, $location, $routeParams, $cookieStore) {
		return {
			restrict: 'E',
			link: function (scope, elem, attrs) {
				scope.cs = contactService;
				scope.item = null;

				scope.$watch(function(){
					var _id = $routeParams.id,
						cookies = $cookieStore.get('auth_basic');

					if(!cookies){
						contactService.contact = null;

						$location.path('/');
						return;
					}

					if(_id){
						var index = contactsService.findIndex(_id);

						if(index != -1) {
							scope.cs.set(contactsService.contacts[index]);
								setTimeout(function() {
									$location.path('/contacts/' + _id);
								}, 300);
						}
					}
				});
			},
			templateUrl:'./partials/contact-item.html'
		};
	}]);
