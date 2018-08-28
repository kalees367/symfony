const express = require('express');
const app = express();
var cors = require('cors');
const bodyParser = require('body-parser'); 
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({
    extended: true
}));
// CORS header securiy
app.all('/*', function (req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
   res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
  res.header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type");
  next();
});

var MongoClient = require('mongodb').MongoClient;
var url = "mongodb://localhost:27017/";

// Retrieve all user 
app.get('/users', function (req, res) {
		MongoClient.connect(url, function(err, db) {
	  if (err) throw err;
	  var dbo = db.db("symfony");
	  dbo.collection("users").find().toArray(function(err, result) {
		if (err) throw err;
		console.log(result);
		 return res.send({ result });
		//console.log(result.firstName);
		db.close();
	  });
	});
});

app.post('/users', function (req, res) {
	
		MongoClient.connect(url,  function(err, db) {
	  if (err) throw err;
	  useNewUrlParser: true;
	  var dbo = db.db("symfony");
	  var user_id = "";
	  var first_name = "ayil";
	  var last_name = "amaran";
	  var email_id = "ayil@gmail.com";
	  var mobile = "1234567890";
	  var date_of_birth = "07/05/1988";
	  var education = "B.Tech";
	  var blood_group = "b +ve";
	  var gender = "male";
	  var myobj = { userId:user_id,firstName: first_name, lastName: last_name,emailId:email_id,mobile:mobile,dateOfBirth:date_of_birth,education:education,bloodGroup:blood_group,gender:gender };
	  dbo.collection("users").insertOne(myobj, function(err, res) {
		if (err) throw err;
		console.log("1 document inserted");
		db.close();
	  });
	});
});

//Retrieve user  with id 
 app.get('/users/:id', function (req, res) {
  // let task_id = req.params.id;
	 let task_id = 1;
		MongoClient.connect(url, function(err, db) {
	  if (err) throw err;
	  var dbo = db.db("symfony");
	  var query = { userId: task_id };
	  dbo.collection("users").find(query).toArray(function(err, result) {
		if (err) throw err;
		console.log(result);
		console.log(task_id);
		 return res.send({ result });
		db.close();
	  });
	});
  });
app.listen(3000, function () {
    console.log('Node app is running on port 3000');
});