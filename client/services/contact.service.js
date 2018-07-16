
app
.factory('contactService', [function () {
	return {
		contact:null,
		set:function(obj){
			this.contact = obj; 
		},
		getInitials:function(name=" "){
			var prts = name.split(' '),
				ln = prts.length;

			return prts[0].substr(0, 1)+(ln>1?prts[1].substr(0, 1):'').toUpperCase();
		}
	};
}]);