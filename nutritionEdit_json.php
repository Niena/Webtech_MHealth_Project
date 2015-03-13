<?php
/*
Author:
Date:05/05/2014
Description:Ajax response implementation of the nutrition class
*/


	include("gen.php");
	$cmd=get_datan("cmd");
	switch($cmd){
		case 1:
			//get one id
			getDetails();
			break;
		case 2:
			//edit the record
			update_nutrition();
			
			break;
		case 3;
			//  delete the record
			delete_Detail();
			break;
			case 4;
			//  insert a record
			insert_Detail();
			break;
		default:
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","unknown command");
			echo "}";
			
	}
	
	//gets all the details in a record using specified id
	function getDetails(){
		include_once("nutrition.php");
		
		$id=get_datan("n_id");
		$v=new nutrition();
		$row=$v->list_One($id);//calls method to list details
		$row=$v->fetch();
		//error message
		if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","nutrition record not found");
			echo "}";
			return;
		}
		//success message		
		echo "{";
			echo jsonn("result",1) .",";
			echo '"nutrition":{';
			//record id
			echo jsonn("n_id",$row['n_id']). ",";
			//community member id
			echo jsonn("community_member_id",$row['community_member_id']) . ",";
			//date that member visited hospital
			echo jsons("date_of_attendance",$row['date_of_attendance']). ",";
			//is the person is pregnant 
			echo jsons("pregnancy_status",$row['pregnancy_status']). ",";
			//is the person is anaemic
			echo jsons("anaemia_status",$row['anaemia_status']). ",";
			//the vitamins that the person is on
		    echo jsonn("v_id",$row['v_id']);
			echo '}';
		echo "}";
		}

	
		
	//Function to change an existing record
	function update_nutrition(){
	 //gets the data from request page
	$n_id=get_datan('n_id');
	$cm_id = get_datan('community_member_id');
	$date_of_attendance=get_data('date_of_attendance');
	$pregnancy_status=get_data('pregnancy_status');
	$anaemia_status=get_data('anaemia_status');
	$v_id=get_datan('v_id');
		if(!$n_id){
		//error message		
		echo "There is no id";
		}
		include_once("nutrition.php");
		$v=new nutrition();
		//calls update method
		$row=$v->update_n($n_id,$cm_id,$date_of_attendance,$pregnancy_status,$anaemia_status,$v_id);
		 if (!$row){
		 //error message
		   echo "{";
		   echo jsonn("result",0). ",";
		   echo jsons("message","Could not update nutrition");
		   echo "}";
	       return;}
		//success message
		 echo "{";
		 echo jsonn("result",1). ",";
		 echo jsons("message","nutrition record update, successful");
		echo "}";
			}
			
	//inserts a new record into the nutrition table	
	function insert_Detail(){
	 $cm_id = get_datan('community_member_id');
	 $date_of_attendance=get_data('date_of_attendance');
	 $pregnancy_status=get_data('pregnancy_status');
	 $anaemia_status=get_data('anaemia_status');
	 $v_id=get_datan('v_id');
				
	   include_once("nutrition.php");
	   $v=new nutrition();
	   //calls method to insert
	   $row=$v->add_n($cm_id,$date_of_attendance,$pregnancy_status,$anaemia_status,$v_id);
		if (!$row){
		//error message
		 echo "{";
		 echo jsonn("result",0). ",";
		 echo jsons("message","Could not add");
		 echo "}";
		 return;}
		//success message
		echo "{";
		echo jsonn("result",1). ",";
		echo jsons("message","nutrition record added, successful");
		echo "}";
		}
				

	//function to delete details using specified id
	function delete_Detail(){
		$id=get_datan("n_id");
		if(!$id){
		//error message		
		echo "There is no id";
		return;
				}
		include_once("nutrition.php");
		$v=new nutrition();
		$row=$v->delete_n($id);//calls the delete method
		 if (!$row){
		 //error message
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Could not delete record");
			echo "}";
			return;}
		//success message
			echo "{";
			echo jsonn("result",1). ",";
			echo jsons("message","nutrition record deletion,successful");
		    echo "}";
			}
					
					

?>