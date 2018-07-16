var register = function ($http, authService) {
	return {
		create:function(data){
			authService.saveAuthData(data.email, data.password);

			return $http
			.post('http://127.0.0.3/users', data)
			.then(function(res){
			});
		}
	};
};

app.factory('registerService', ['$http', 'authService', register]);