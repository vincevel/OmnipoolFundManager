<?php



$inputs["full_name"] =  "";
$inputs["first_name"] = $_POST["q3_fullName3"]["first"];
$inputs["middle_name"] = $_POST["q3_fullName3"]["middle"];
$inputs["last_name"] = $_POST["q3_fullName3"]["last"];

$inputs["phone_no"] = $_POST["q6_phoneNumber6"]["area"] . "-" .$_POST["q6_phoneNumber6"]["phone"];
$inputs["password1"] = $_POST["pq14_country"];
$inputs["password2"] = $_POST["pq14_country2"];
$inputs["email"] = $_POST["q4_email4"];

$inputs["country"] = $_POST["q14_country"];

$inputs["address_line1"] = $_POST["addr_line1"];
$inputs["address_line2"] = $_POST["addr_line2"];
$inputs["city"] = $_POST["city"];
$inputs["state_province"] = $_POST["state"];
$inputs["postal_zip_code"] = $_POST["postal"];


$inputs["beneficiary1_first_name"] = $_POST["q27_beneficiary1"]["first"];
$inputs["beneficiary1_middle_name"] = $_POST["q27_beneficiary1"]["middle"];
$inputs["beneficiary1_last_name"] = $_POST["q27_beneficiary1"]["last"];
$inputs["beneficiary1_relationship"] = $_POST["q28_relationship"];

$inputs["beneficiary2_first_name"] = $_POST["q29_beneficiary2"]["first"];
$inputs["beneficiary2_middle_name"] = $_POST["q29_beneficiary2"]["middle"];
$inputs["beneficiary2_last_name"] = $_POST["q29_beneficiary2"]["last"];
$inputs["beneficiary2_relationship"] = $_POST["q30_relationship30"];

$inputs["beneficiary3_first_name"] = $_POST["q31_beneficiary3"]["first"];
$inputs["beneficiary3_middle_name"] = $_POST["q31_beneficiary3"]["middle"];
$inputs["beneficiary3_last_name"] = $_POST["q31_beneficiary3"]["last"];
$inputs["beneficiary3_relationship"] = $_POST["q32_relationship32"];




$inputs["name_id_first_name"] = $_POST["q121_nameAs"]["first"];
$inputs["name_id_middle_name"] = $_POST["q121_nameAs"]["middle"];
$inputs["name_id_last_name"] = $_POST["q121_nameAs"]["last"];
$inputs["name_id_suffix"] = $_POST["q121_nameAs"]["suffix"];


$inputs["kind_id"] = $_POST["q122_kindOf"];
$inputs["id_number"] = $_POST["q125_idNumber"];
$inputs["date_issue"] = $_POST["q123_dateOf"]["year"] ."=". $_POST["q123_dateOf"]["month"] ."-" . $_POST["q123_dateOf"]["day"];

$inputs["place_issue"] = $_POST["q124_placeOf"];

$inputs["govt_id_pic"] = $_POST["temp_upload"]["q126_uploadPicture"][0];

//$inputs["item"] = $_POST["pq14_country2"];
/*
   
    


*/
?>
