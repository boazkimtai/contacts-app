AfricasTalking API-Key= b70f03c25ec373fe4214e2b80f80278c9b1e929eeae3dcc2dcf04a525c2b6c41
headers - 200, 201, 404, 406
request headers:Api-Key:apikey

body
 {
	status:'error' || 'success',
	message:null || msg,
	data:null || [] || {}
		array - [{}, {}, {}]
}


request headers  'Content-Type:application/json'

/auth/login
	
	-method - POST
	-data - {
		id_no:,
		password:
	}

	response
	{
		...
		data:{
			api_key: 
		}
	}






/requests
	
	data:[
			{"p_code":,"requester_id":,"date":,"rq_no":, "id":, "materials":[
					{"name":,"purpose":,"cost":,"quantity":,"status":,"rq_no":,"id":,"total":},
					...]}
			.....
		]


/requests GET

		
			{"status":"success",
			"message":null,
			"data":
					[{"p_code":"1","requester_id":30234477,"date":"2013-01-01 03:10:10","rq_no":"ZCJAS5","id":15,
							"materials":[
									{"name":"works","purpose":null,"cost":1,"quantity":100,"status":"pending","rq_no":"ZCJAS5","id":30,"total":100},
									{"name":"works","purpose":null,"cost":1000,"quantity":100,"status":"pending","rq_no":"ZCJAS5","id":31,"total":100000}]},

					{"p_code":"1","requester_id":30234477,"date":"2013-01-01 04:39:19","rq_no":"ER1D0M","id":16,
					"materials":[{"name":"works","purpose":null,"cost":1,"quantity":100,"status":"pending","rq_no":"ER1D0M","id":32,"total":100},{"name":"works","purpose":null,"cost":1000,"quantity":100,"status":"pending","rq_no":"ER1D0M","id":33,"total":100000}]},
					}


/requests/{rq_no} GET
	
			{"status":"success",
			"message":null,
			"data":{"p_code":"1","requester_id":30234477,"date":"2013-01-01 03:10:10","rq_no":"ZCJAS5","id":15,
							"materials":[
									{"name":"works","purpose":null,"cost":1,"quantity":100,"status":"pending","rq_no":"ZCJAS5","id":30,"total":100},
									{"name":"works","purpose":null,"cost":1000,"quantity":100,"status":"pending","rq_no":"ZCJAS5","id":31,"total":100000}]}


/requests 	POST
	request body
	{"p_code":"1",
							"materials":[
									{"name":"works","purpose":,"cost":1,"quantity":100},
									{"name":"works","purpose":,"cost":1000,"quantity":100}]}

	response body

	{"status":"success",
			"message":null,
			"data":{"rq_no":code}







material_requests/{id} PUT
	request body
	{"action":"approve" || "reject"}

	response body
	{"status":"success",
			"message":"updated",
			"data":null






/users GET
	{"status":"success","message":null,"data":[{"fullname":"Boaz Kim","department":"works","rank":"0","project_site":"US","phone":"0703700932","id_no":30234477,"id":1}]}

/users/{id} GET

{"status":"success","message":null,"data":{"fullname":"Boaz Kim","department":"works","rank":"0","project_site":"US","phone":"0703700932","id_no":30234477,"id":1}}


/users POST
	request body
	{"fullname":"Boaz Kim","department":"works","rank":"0","project_site":"US","phone":"0703700932","id_no":30234477,"password":""}]}
	response body
	{"status":"success",
			"message":created",
			"data":null

/users/{id} PUT
	request body
	{"fullname":"Boaz Kim","department":"works","rank":"0","project_site":"US","phone":"0703700932","id_no":30234477}]}

	response body
	{"status":"success",
			"message":updated",
			"data":null

/users/{id}/password PUT
	request body
	{password:""}

	response body
	{"status":"success",
			"message":updated",
			"data":null


/users/{id}	DELETE
	response body
	{"status":"success",
			"message":deleted",
			"data":null


/users/{id}/api_key PUT
	response body
	{"status":"success",
			"message":deleted",
			"data":{"api_key":}





