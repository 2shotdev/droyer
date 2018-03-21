<?php
	$action=$_GET['action']; 
	$email=$_GET['email']; 
	$voteid=$_GET['voteid']; 
	$votename=$_GET['votename']; 
	$votestate=$_GET['votestate']; 
	$pincode=$_GET['pincode']; 
	$datecreated= date("Y-m-d");
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
	$con->query("SET @InAction = '".$action."'");
	$con->query("SET @InEmail = '".$email."'");
	$con->query("SET @InVoteId = '".$voteid."'");
	$con->query("SET @InVoteName = '".$votename."'");
	$con->query("SET @InVoteState = '".$votestate."'");
	$con->query("SET @InPinCode = '".$pincode."'");
	$con->query("SET @InDateCreated = '".$datecreated."'");
	if(!$con->query("CALL ins_vote(@ReturnCode, @ErrorMessage, @InAction, @InEmail, @InVoteId, @InVoteName, @InVoteState, @InPinCode, @InDateCreated)"))
		die("CALL failed: (" . $con->errno . ") " . $con->error);
	$select = $con->query('SELECT @ReturnCode, @ErrorMessage');
	$result = $select->fetch_assoc();
	mysqli_close($con);
	echo '{"d":{"__type":"Contact.Status","ReturnCode":'.$result['@ReturnCode'].',"ErrorMessage":"'.$result['@ErrorMessage'].'"}}';