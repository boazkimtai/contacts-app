
(function(){
var auth = function ($http, $cookieStore) {
	var url = 'http://127.0.0.3/auth/login';

	return {
		login:function(data){
			var _this = this,
				authBasicData = _this.encode(data.email, data.password);

			$http.defaults.headers.common['Authorization'] = authBasicData;

			_this.saveAuthData(data.email, data.password);
			console.log($cookieStore.get('auth_basic'));

			return $http.post(url, null)
			.then(function(res){
				if(res.data.status == 'success') {
				}
			});
		},
		autoLogin:function(){
			return $http.post(url, null);
		},
		encode:function(user, pwd){
			return authBasicData =  'Basic ' + btoa(user + ':' + pwd);
		},
		saveAuthData:function(user, pwd){
			$cookieStore.put('auth_basic', this.encode(user, pwd));
		},
		logout:function(){
			$cookieStore.remove('auth_basic');
		}
	};
};

app
.factory('authService', ['$http', '$cookieStore', auth]);
}());