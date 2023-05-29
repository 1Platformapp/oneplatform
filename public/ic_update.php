<?php 
	
	date_default_timezone_set("Europe/London");

	$mysqli = new mysqli("127.0.0.1","theaudit_dbuser","pwdzat791","theaudit_audition");
	if ($mysqli -> connect_errno) {
	  echo "Failed to connect to MySQL:".$mysqli->connect_error;
	  exit();
	}

	$x = '[]';


	$y = json_decode($x, TRUE);
	$z = $y[0]['Listings']['Data'];

	foreach ($z as $key => $value) {
		
		$notes = mb_convert_encoding($mysqli->real_escape_string($value['Notes']), 'Windows-1252', 'UTF-8');
		$address = mb_convert_encoding($mysqli->real_escape_string($value['Address']), 'Windows-1252', 'UTF-8');
		$address2 = mb_convert_encoding($mysqli->real_escape_string($value['Address2']), 'Windows-1252', 'UTF-8');
		$address3 = mb_convert_encoding($mysqli->real_escape_string($value['Address3']), 'Windows-1252', 'UTF-8');
		$address4 = mb_convert_encoding($mysqli->real_escape_string($value['Address4']), 'Windows-1252', 'UTF-8');
		$address5 = mb_convert_encoding($mysqli->real_escape_string($value['Address5']), 'Windows-1252', 'UTF-8');
		$name = mb_convert_encoding($mysqli->real_escape_string($value['Name']), 'Windows-1252', 'UTF-8');
		$sortName = mb_convert_encoding($mysqli->real_escape_string($value['SortName']), 'Windows-1252', 'UTF-8');
		$region = mb_convert_encoding($mysqli->real_escape_string($value['Region']), 'Windows-1252', 'UTF-8');
		$city = mb_convert_encoding($mysqli->real_escape_string($value['City']), 'Windows-1252', 'UTF-8');
		$email = mb_convert_encoding($mysqli->real_escape_string($value['Email']), 'Windows-1252', 'UTF-8');
		$telephone = mb_convert_encoding($mysqli->real_escape_string($value['Tel']), 'Windows-1252', 'UTF-8');
		$website = mb_convert_encoding($mysqli->real_escape_string($value['Website']), 'Windows-1252', 'UTF-8');
		$website2 = mb_convert_encoding($mysqli->real_escape_string($value['Website2']), 'Windows-1252', 'UTF-8');
		$twitter = mb_convert_encoding($mysqli->real_escape_string($value['Twitter']), 'Windows-1252', 'UTF-8');
		$facebook = mb_convert_encoding($mysqli->real_escape_string($value['Facebook']), 'Windows-1252', 'UTF-8');
		$youtube = mb_convert_encoding($mysqli->real_escape_string($value['Youtube']), 'Windows-1252', 'UTF-8');
		$instagram = mb_convert_encoding($mysqli->real_escape_string($value['Instagram']), 'Windows-1252', 'UTF-8');
		$soundcloud = mb_convert_encoding($mysqli->real_escape_string($value['SoundCloud']), 'Windows-1252', 'UTF-8');
		$postcode = mb_convert_encoding($mysqli->real_escape_string($value['Postcode']), 'Windows-1252', 'UTF-8');
		$isFavourite = $value['IsFavourite'] != '' ? 1 : NULL;
		$inSurvivalGuide = $value['InSurvivalGuide'] != '' ? 1 : NULL;

		$checkQuery = 'SELECT * FROM aud_industry_contacts WHERE contact_id="'.$value['Id'].'"';
        $check = mysqli_query($mysqli, $checkQuery);
        if(mysqli_num_rows($check) == 0){

        	$sql = "INSERT INTO aud_industry_contacts (contact_id, name, sort_name, region, region_id, category_id, city_id, city, email, telephone, website, website2, address, address2, address3, address4, address5, postcode, twitter, facebook, youtube, instagram, soundcloud, is_favourite, group_id, in_survival_guide, guide_start_date, guide_end_date, notes)
        	VALUES ('".$value['Id']."', '".$name."', '".$sortName."', '".$region."', '".$value['RegionId']."', '".$value['CategoryId']."', '".$value['CityId']."', '".$city."', '".$email."', '".$telephone."', '".$website."', '".$website2."', '".$address."', '".$address2."', '".$address3."', '".$address4."', '".$address5."', '".$postcode."', '".$twitter."', '".$facebook."', '".$youtube."', '".$instagram."', '".$soundcloud."', '".$isFavourite."', '".$value['GroupId']."', '".$inSurvivalGuide."', '".$value['GuideStartDate']."', '".$value['GuideEndDate']."', '".$notes."')";
        	
        	if ($mysqli->query($sql) === TRUE) {
        	  
        	}else {
        	  echo "Insert Error: For:: " .$value['Id'].' :: '. $sql . "<br>" . $mysqli->error;
        	}
        }else{

        	$update = "UPDATE aud_industry_contacts SET name='".$name."', sort_name='".$sortName."', region='".$region."', region_id='".$value['RegionId']."', category_id='".$value['CategoryId']."', city_id='".$value['CityId']."', city='".$city."', email='".$email."', telephone='".$telephone."', website='".$website."', website2='".$website2."', address='".$address."', address2='".$address2."', address3='".$address3."', address4='".$address4."', address5='".$address5."', postcode='".$postcode."', twitter='".$twitter."', facebook='".$facebook."', youtube='".$youtube."', instagram='".$instagram."', soundcloud='".$soundcloud."', is_favourite='".$isFavourite."', group_id='".$value['GroupId']."', in_survival_guide='".$inSurvivalGuide."', guide_start_date='".$value['GuideStartDate']."', guide_end_date='".$value['GuideEndDate']."', notes='".$notes."', updated_at='".date('Y-m-d H:i:s')."' WHERE contact_id=".$value['Id'];

        	if ($mysqli->query($update) === TRUE) {
        		
        	}else {
        		echo "Update Error: For:: " .$value['Id'].' :: '. $update . "<br>" . $mysqli->error;
        	}
        }
		
	
	}

	echo 'done';exit;

?>