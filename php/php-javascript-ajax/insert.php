<?php
	$nfirstname=$_GET['nfirstname']; 
	$nlastname=$_GET['nlastname']; 
	$nemail=$_GET['nemail']; 
	$nphone=$_GET['nphone']; 
	$nknow=$_GET['nknow']; 
	$firstname=$_GET['firstname']; 
	$lastname=$_GET['lastname']; 
	$school=$_GET['school'];
	$phone=$_GET['phone'];
	$address=$_GET['address'];
	$city=$_GET['city'];
	$state=$_GET['state'];
	$zip=$_GET['zip'];
	$rules=$_GET['rules'];
	$comments=$_GET['comments'];
	$returncode = 0;
	$errormessage = '';
	$con;
	if($_SERVER["HTTP_HOST"] == "americasgreatestschoolnurse.com" || $_SERVER["HTTP_HOST"] == "www.americasgreatestschoolnurse.com"){
		$con=mysqli_connect("172.99.97.152","591040_agsn","Revd@1234","591040_agsn");
	} else {
		$con=mysqli_connect("172.99.97.110","591040_agsnc_stg","Revd@1234","591040_agsn_stg");
	}	
	// Check connection
	if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
	$con->query("SET @ReturnCode = -1");
	$con->query("SET @ErrorMessage = ''");
	$con->query("SET @InNFirstName = '".$nfirstname."'");
	$con->query("SET @InNLastName = '".$nlastname."'");
	$con->query("SET @InNEmail = '".$nemail."'");
	$con->query("SET @InNPhone = '".$nphone."'");
	$con->query("SET @InNKnow = '".$nknow."'");
	$con->query("SET @InFirstName = '".$firstname."'");
	$con->query("SET @InLastName = '".$lastname."'");
	$con->query("SET @InSchool = '".$school."'");
	$con->query("SET @InHomeowner = '".$homeowner."'");
	$con->query("SET @InPhone = '".$phone."'");
	$con->query("SET @InAddress = '".$address."'");
	$con->query("SET @InCity = '".$city."'");
	$con->query("SET @InState = '".$state."'");
	$con->query("SET @InZip= '".$zip."'");
	$con->query("SET @InComments= '".$comments."'");
	$con->query("SET @InRules= '".$rules."'");
	if(!$con->query("CALL ins_nomination(@ReturnCode, @ErrorMessage, @InNFirstName, @InNLastName, @InNEmail, @InNPhone, @InNKnow, @INFirstName, @InLastName, @InSchool, @InPhone, @InAddress, @InCity, @InState, @InZip, @InComments, @InRules)"))
		die("CALL failed: (" . $con->errno . ") " . $con->error);
	$select = $con->query('SELECT @ReturnCode, @ErrorMessage');
	$result = $select->fetch_assoc();
	mysqli_close($con);
	echo '{"d":{"__type":"Contact.Status","ReturnCode":'.$result['@ReturnCode'].',"ErrorMessage":"'.$result['@ErrorMessage'].'"}}';