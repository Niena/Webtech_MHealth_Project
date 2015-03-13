<?php
/*
Author: Niena Rahma Alhassan
Date: 05/05/2014
Description: This page is an ajax request page for the school_feeding database
*/


	session_start();	//start session
	if(!isset($_SESSION['username'])){	//check if the user data is in the session
		header("location: login2.php");	//if not redirect back to login.php
	}
?>
<html>
	<head>
		<title>School List</title>
		<link rel="stylesheet" href="style.css">
		<script src="jquery-1.11.0.js"></script>
		<script src="gen.js"></script>
		<script>
			//makes a synchronous call to the page u and return the 
			//result as object
			var t;
			function syncAjax(u){
				var obj=$.ajax(
					{url:u,
					 async:false
					 }
				);
				return $.parseJSON(obj.responseText);}
				
			//informs the user about results in the status bar
			function showStatus(msg){
				var objDivStatus=document.getElementById("divStatus");
				$("#divStatus").prop("value",objDivStatus.innerHTML=msg);
				}
				
			//returns a result object for one record
			function getSchool(id){
				t=id;  //global variable has been sent to a record id
				var u="school_action.php?cmd=1&id="+t;//url
				return syncAjax(u);
			}
				
			function saveDone(data){
				
				alert(data);
			}
			
			//shows the edit form
			function edit(obj,id){
				var r=getSchool(id);
				if(r.result==0){
					//show error message
					showStatus("Could not get the record id ");
					return;}
					else {
					showStatus(" Record id received");
							   
				
				//get the data from object r and put it in the form
				$("#sch_id").prop("value",r.schoolFeeding.id);
				$("#stud_num").prop("value",r.schoolFeeding.num_students);
				$("#sfs_num").prop("value",r.schoolFeeding.sch_fd_stud);
				$("#date_rec").prop("value",r.schoolFeeding.date);
				$("#sch_id").prop("value",r.schoolFeeding.sid);

				
				//show the form
				//find where the user clicked and store it in x and y
				var y=event.clientY;
				var x=event.clientX/2;
				//use x and y to set the location of the form
				$("#divEdit").css("top",y);
				$("#divEdit").css("left",x);
				//display the form
				$("#divEdit").fadeIn(1000);
				}
			}
			
			//makes a request to the response page to update record in school_feeding database
			function save(){
				//complete the url
				var id=document.getElementById("record_id").value;
				var p=document.getElementById("stud_num").value;
				var sfs=document.getElementById("sfs_num").value;
				var d=document.getElementById("date_rec").value;
				var sid=document.getElementById("sch_id").value;
				var u="school_action.php?cmd=2&id="+t+"&p="+p+"&sfs="+sfs+"&d="+d+"&sid="+sid;//url
							
				r=syncAjax(u);
				cancel();
				showStatus("Record updated;refresh page to view changes");

				}
							
			//hides the edit form
			function cancel(){
				//fade out the form in half a second
				$("#divEdit").fadeOut(500);
				showStatus("status message");
				
			}
			
				//shows the delete form
				function deleteForm(obj,id){
				var r=getSchool(id);
				if(r.result==0){
					//show error message
					showStatus("Could not get the record id ");
					return;}
				else {
				    showStatus("id received");				
								
				//show the form
				//find where the user clicked and store it in x and y
				var y=event.clientY;
				var x=event.clientX/2;
				//use x and y to set the location of the form
				$("#divDelete").css("top",y);
				$("#divDelete").css("left",x);
				//display the form
				$("#divDelete").fadeIn(1000);
			   }
			}
				//makes a request and deletes record
				function deleteSave(){
				// url
				var u="school_action.php?cmd=3&id="+t;//url
				r=syncAjax(u);
				showStatus("record deleted;refresh page to see");
				cancelDelete();
			}
			
			//hides the delete form
			function cancelDelete(){
				//fade out the form in half a second
				$("#divDelete").fadeOut(500);
				
			}
			
			//shows the insert form
			function insert(){
				
				//get the data from object r and put it in the form
				$("#stud_nums").prop("value","Enter population(integer)");
				$("#sfs_nums").prop("value","Student number(integer)");
				$("#date_recs").prop("value","YY-MM-DD");
				$("#sch_ids").prop("value","School ID");

				
				//show the form
				//find where the user clicked and store it in x and y
				var y=event.clientY;
				var x=event.clientX/2;
				//use x and y to set the location of the form
				$("#divInsert").css("top",y);
				$("#divInsert").css("left",x);
				//display the form
				$("#divInsert").fadeIn(1000);
			}
			
			//inserts a new school feeding record into the database
			function saveInsert(){
				var p=document.getElementById("stud_nums").value;
				var sfs=document.getElementById("sfs_nums").value;
				var d=document.getElementById("date_recs").value;
				var sid=document.getElementById("sch_ids").value;
				var u="school_action.php?cmd=4&p="+p+"&sfs="+sfs+"&d="+d+"&sid="+sid;//url
			  	r=syncAjax(u);
				showStatus("new record added;refresh page to see");
				cancelInsert();
			}
			
			//hides the insert form			
			function cancelInsert(){
				//fade out the form in half a second
				$("#divInsert").fadeOut(500);
				
			}
			
		</script>
	</head>
	<body>
		<table>
			<tr>
				<td colspan="2" id="pageheader">
					health information system
				</td>
			</tr>
			<tr>
				<td id="mainnav">
					<div class="menuitem">location</div>
					<div class="menuitem">opd cases</div>
					<div class="menuitem">health promotion</div>
					<div class="menuitem"><a href="nut_class.php">nutrition</a></div>
					<div class="menuitem"><a href="school_list.php">child welfare</a></div>
					<div class="menuitem">family planning</div>
					<div class="menuitem"><a href="logout.php">logout<a></div>
				</td>
				<td id="content">
					<div id="divPageMenu">
						<span class="menuitem" >sub districts</span>
						<span class="menuitem" >communities</span>
						<span class="menuitem" >view map</span>
						<input type="text" id="txtSearch">
						<span class="menuitem">search</span>	
						<span class="menuitem"  onclick='insert()'>new record  </span>
					</div>
					<div id="divStatus" class="status">
						status messages
					</div>
					<div id="divContent">
						SchoolFeeding
						<table class="reportTable" width="100%" >
							<tr class="header" >
								<td>ID</td>
								<td>Student number</td>
								<td>schoolfeeding Students</td>
								<td>Date</td>
								<td>School</td>
								<td></td>

								<td></td>
							</tr>
<?php	
	include("school_feeding.php");
	$obj=new school_feeding();
	//lists all the data in a table form
	if(!$obj->listAll2()){
		echo "error";
		exit();
	}
	
	$row=$obj->fetch();
	$row_counter=0;
	while($row){
		
		if($row_counter%2==0){
			$style=" class='row1' ";
		}else{
			$style=" class='row2'  ";
		}	
		$id=$row['sf_id'];
		echo "<tr $style >";
			echo "<td>$id</td>";
			echo "<td>$row[num_students]</td>";
			echo "<td>$row[num_students_feeding_pro]</td>";
			echo "<td>$row[date_of_collection]</td>";
			echo "<td>$row[school_name]</td>";
			echo "<td><span class='hotspot' onclick='edit(this,$id)'>edit<span></td>";
			echo "<td><span class='hotspot' onclick='deleteForm(this,$id)'>delete<span></td>";
		echo "</tr>";
		$row=$obj->fetch();
		$row_counter++;
	}
?>
						</table>
					</div>
				</td>
			</tr>
		</table>
	<div id="divEdit" class="popupForm">
		<table class="tableForm" >
					<tr>
						<td class="label">Student Population: </td>
						<td class="field"><input type="text" value="" id="stud_num" ></td>
					</tr>
					<tr>
						<td class="label">Schoolfeeding Students No:</td> 
						<td class="field"><input type="text" value="" id="sfs_num">
						</td>
					</tr>
					<tr>
						<td class="label">Date:</td>
						<td class="field"><input type="text" value="" id="date_rec">
						</td>
					</tr>
					<tr>
						<td class="label">School_id:</td>
						<td class="field"><input type="text" value="" id="sch_id">
						</td>
					</tr>
					<tr>
						<td><input type="hidden" value="<?php $id=$row['sf_id']?>"id="record_id"></td>
					</tr>
					<tr>
						<td class="label"></td>
						<td class="field">
							<input type="button" value="save" onclick="save()" >
							<input type="button" value="cancel" onclick="cancel()" >
						</td>
					</tr>
			</table>
			</div>
		<div id="divInsert" class="popupForm">
		<table class="tableForm" >
					<tr>
						<td class="label">Student Population: </td>
						<td class="field"><input type="text" value="" id="stud_nums" ></td>
					</tr>
					<tr>
						<td class="label">Schoolfeeding Students No:</td> 
						<td class="field"><input type="text" value="" id="sfs_nums">
						</td>
					</tr>
					<tr>
						<td class="label">Date:</td>
						<td class="field"><input type="text" value="" id="date_recs">
						</td>
					</tr>
					<tr>
						<td class="label">School_id:</td>
						<td class="field"><input type="text" value="" id="sch_ids">
						</td>
					</tr>
					<tr>
						<td class="label"></td>
						<td class="field">
							<input type="button" value="save" onclick="saveInsert()" >
							<input type="button" value="cancel" onclick="cancelInsert()" >
						</td>
					</tr>
			</table>
			</div>
			
			
			<div id="divDelete" class="popupForm">
		<table class="tableForm" >
		             <tr>
						<td class="label">Are you sure that you want to delete record?</td>
					</tr>
					<tr>
						<td><input type="hidden" value="<?php $id=$row['sf_id']?>"id="record_id"></td>
					</tr>
						<tr>
						
							<input type="button" value="delete" onclick="deleteSave()" >
							<input type="button" value="cancel" onclick="cancelDelete()" >
							<td class="label"></td>
						</td>
					</tr>
			</table>
				
	</div>
	</body>
</html>	