

var contactsService = function ($http) {
	var url = 'http://127.0.0.3/contacts';
	
	return {
		isLoading:true,
		contacts:[
		],
		findIndex:function(id){
			var ln = this.contacts.length;

			for (var i = 0; i < ln; i++) {
				if(this.contacts[i].id == id){
					return i;
					break;
				} else if(i == ln - 1 && this.contacts[i].id != id){
					return -1;
				}
			};
		},
		search:function(q){
			var patt = new RegExp(q, 'i');

			return this.contacts.filter(function(current){
				return current.name.match(patt) || current.phone.match(patt); 
			});
		},
		all:function(){
			var _this = this;

			return $http.get(url)
			.then(function(res){
				_this.contacts = res.data.data;
				_this.isLoading = false;
			});
		},
		create:function(data){
			var _this = this;

			return $http.post(url, data)
			.then(function(res){
				_this.contact.push(data);
			});
		},
		update:function(id, data){
			return $http.post(url + id, data)
			.then(function(res){
			});
		},
		get:function(id){
			return $http.get(url + id)
			.then(function(res){

			});
		},
		delete:function(id){
			return $http.delete(url + id)
			.then(function(res){
			});
		}
	};
}

app.factory('contactsService', ['$http', contactsService]);


