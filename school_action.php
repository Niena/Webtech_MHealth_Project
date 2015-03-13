<?php

/*
Author: Niena Rahma Alhassan
Date: 05/05/2014
Description: This page is an ajax response page for the school_feeding database
*/
	include("gen.php");
	$cmd=get_datan("cmd");
	switch($cmd){
		case 1:
			//get all the details for a specified id
			get_school();
			break;
		case 2:
			//edit the record
			update();
			
			break;
		case 3;
			//  delete the record
			delete();
			break;
			case 4;
			//  insert a new record
			insert();
			break;
			/*else display an error message if no command
			is selected*/
		default:
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","unknown command");
			echo "}";
			
	}
	
	//This function will get all the details using a school id
	function get_school(){
		include_once("school_feeding.php");
		
		$id=get_datan("id");
		$v=new school_feeding();//create an object
		$row=$v->listID($id);//get all the details in the record
		$row=$v->fetch();
		//display error message
		if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","school record not found");
			echo "}";
			return;
		}
		
		echo "{";
			echo jsonn("result",1) .",";
			echo '"schoolFeeding":{';
			//record id
			echo jsonn("id",$row['sf_id']). ",";
			//student population
			echo jsonn("num_students",$row['num_students']) . ",";
			//students in the school feeeding programme
			echo jsonn("sch_fd_stud",$row['num_students_feeding_pro']). ",";
			//date of record 
			echo jsons("date",$row['date_of_collection']). ",";
			//get the school using the id
		    echo jsonn("sid",$row['school_id']);
			echo '}';
		echo "}";
		}

	
		
	//This function allows a record to be changed
	function update(){
	//get the details from the request page
	 $id=get_datan("id");
	 $population=get_datan("p");
	 $schfd=get_datan("sfs");
	 $dat=get_data("d");
	$sID=get_datan("sid");
		if(!$id){
				//display error message		
				echo "There is no id";
				}
		include_once("school_feeding.php");		
		$v=new school_feeding();//creates a new school_feeding object
		$row=$v->update_sFeeding($id,$population,$schfd,$dat,$sID);//calls the update method
		if (!$row){
			//display error message
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Could not update schools");
			echo "}";
			return;}
			//display success message
			echo "{";
			echo jsonn("result",1). ",";
			echo jsons("message","school record update, successful");
			echo "}";
			
		}
	
     //This function allows a new record to be added	
	function insert(){
		//get the details from the request page
		$population=get_datan("p");
		$schfd=get_datan("sfs");
		$dat=get_data("d");
		$sID=get_datan("sid");
				
		include_once("school_feeding.php");
		$v=new school_feeding();// creates a new object
		$row=$v->add_sfdetail($population,$schfd,$dat,$sID);//calls add new record method
			if (!$row){
				//display error message
					echo "{";
					echo jsonn("result",0). ",";
					echo jsons("message","Could not update schools");
					echo "}";
					return;}
					
					//display success message
					echo "{";
						echo jsonn("result",1). ",";
						echo jsons("message","school record insertion,successful");
					echo "}";
					
				}
				
	//This function enables deletion			
	function delete(){
		$id=get_datan("id");//takes the id from the request page
		if(!$id){
		//display error message		
		echo "There is no id";
		return;
		}
		include_once("school_feeding.php");
		$v=new school_feeding();//creates a new object
		$row=$v->delete_school($id);//calls the delete method
		  if (!$row){
		  //display error message
		 echo "{";
		 echo jsonn("result",0). ",";
		 echo jsons("message","Could not delete record");
		 echo "}";
		 return;}
		 
		 //display success message					
		echo "{";
		echo jsonn("result",1). ",";
		echo jsons("message","school record deletion,successful");
		echo "}";
		}
					
					

?>