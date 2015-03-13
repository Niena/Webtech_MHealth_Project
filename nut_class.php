<?php
/*
Author: 
Date: 05/05/2014
Description: This page is an ajax request page for the nutrition database
*/


	session_start();	//start session
	if(!isset($_SESSION['username'])){	//check if the user data is in the session
		header("location: login.php");	//if not redirect back to login.php
	}
?>


<html>
	<head>
		<title>Nutrition</title>
		<link rel="stylesheet" href="style.css">
		<script src="jquery-1.11.0.js"></script>
		<script src="gen.js"></script>
		<script>
		     var t;
			/*makes a synchronous call to the page u and return the 
			result as object*/
			function syncAjax(u){
				var obj=$.ajax(
					{url:u,
					 async:false
					 }
				);
				return $.parseJSON(obj.responseText);}
				
			//informs the user about the actions performed
			function showStatus(msg){
				var objDivStatus=document.getElementById("divStatus");
				$("#divStatus").prop("value",objDivStatus.innerHTML=msg);
				}
				
			//returns a result object for one record
			function getNutrition(id){
				t=id;  //global variable has been sent to a record id
				var u="nutritionEdit_json.php?cmd=1&n_id="+id;//url
				return syncAjax(u);

				alert(u);
			}
				
			function saveDone(data){
				
				alert(data);
			}
			
			//shows the edit form
			function edit(obj,id){
				var r=getNutrition(id);
					if(r.result==0){
					//show error message
					showStatus("Could not get the record id ");
					return;}
					else {
					showStatus(" Record id received");
							   
				
				//get the data from object r and puts it in the form
				$("#community_member_id").prop("value",r.nutrition.community_member_id);
				$("#date_of_attendance").prop("value",r.nutrition.date_of_attendance);
				$("#pregnancy_status").prop("value",r.nutrition.pregnancy_status);
				$("#anaemia_status").prop("value",r.nutrition.anaemia_status);
				$("#v_id").prop("value",r.nutrition.v_id);

				
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
			
			//makes a request to update record in nutrition database
			function save(){
				
				var cm_id=document.getElementById("community_member_id").value;
				var dt_att=document.getElementById("date_of_attendance").value;
				var preg_st=document.getElementById("pregnancy_status").value;
				var an_st=document.getElementById("anaemia_status").value;
				var vid=document.getElementById("v_id").value;
				//the url for editing
				var u="nutritionEdit_json.php?cmd=2&n_id="+t+"&community_member_id="+cm_id+"&date_of_attendance="+dt_att+"&pregnancy_status="+preg_st+"&anaemia_status="+an_st+"&v_id="+vid;

				r=syncAjax(u);
				cancel();
				showStatus("Record updated");
				location.reload();

				}
							
			//hides the edit form
			function cancel(){
				//fade out the form in half a second
				$("#divEdit").fadeOut(500);
				showStatus("status message");
				
			}
			
			//shows the delete form
			function deleteForm(obj,id){
				var r=getNutrition(id);
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
				var u="nutritionEdit_json.php?cmd=3&n_id="+t;
				r=syncAjax(u);
				showStatus("record deleted");
				cancelDelete();
				location.reload();
			}
			
			//hides the delete form
			function cancelDelete(){
				//fade out the form in half a second
				$("#divDelete").fadeOut(500);
				
			}
			
			//shows the insert form
			function insert(){
				
				//get the data from object r and put it in the form
				$("#community_member_ids").prop("value","ID");
				$("#date_of_attendances").prop("value","YY-MM-DD");
				$("#pregnancy_status2").prop("value","yes/no");
				$("#anaemia_status2").prop("value","yes/no");
				$("#v_ids").prop("value","vitamin id");

				
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
				var cm_id=document.getElementById("community_member_ids").value;
				var dt_att=document.getElementById("date_of_attendance").value;
				var preg_st=document.getElementById("pregnancy_status2").value;
				var an_st=document.getElementById("anaemia_status2").value;
				var vid=document.getElementById("v_ids").value;
				//the url for inserting
				var u="nutritionEdit_json.php?cmd=4&community_member_id="+cm_id+"&date_of_attendance="+dt_att+"&pregnancy_status="+preg_st+"&anaemia_status="+an_st+"&v_id="+vid;
				location.reload();
			  	r=syncAjax(u);
				showStatus("new record added");
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
						Nutrition
						<table class="reportTable" width="100%" >
							<tr class="header" >
								<td>ID</td>
								<td>Member ID</td>
								<td>Date</td>
								<td>Pregnancy Status</td>
								<td>Anaemia Status</td>
								<td>Vitamin</td>
								<td></td>
								<td></td>
							</tr>
<?php	
	include("nutrition.php");
	$obj=new nutrition();
	if(!$obj->list_n2()){
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
		$id=$row['n_id'];
		echo "<tr $style >";
			echo "<td>$id</td>";
			echo "<td>$row[community_member_id]</td>";
			echo "<td>$row[date_of_attendance]</td>";
			echo "<td>$row[pregnancy_status]</td>";
			echo "<td>$row[anaemia_status]</td>";
			echo "<td>$row[v_name]</td>";
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
						<td class="label">Member ID:</td> 
						<td class="field"><input type="text" value="" id="community_member_id">
						</td>
					</tr>
					<tr>
						<td class="label">Date:</td> 
						<td class="field"><input type="text" value="" id="date_of_attendance">
						</td>
					</tr>
					<tr>
						<td class="label">Pregnancy Status:</td>
						<td class="field"><input type="text" value="" id="pregnancy_status">
						</td>
					</tr>
					<tr>
						<td class="label">Anaemia Status:</td>
						<td class="field"><input type="text" value="" id="anaemia_status">
						</td>
					</tr>
					<tr>
						<td class="label">VID:</td>
						<td class="field"><input type="text" value="" id="v_id">
						</td>
					</tr>
					<tr>
						<td><input type="hidden" value="<?php $id=$row['n_id']?>"id="n_id"></td>
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
						<td class="label">Member ID:</td> 
						<td class="field"><input type="text" value="" id="community_member_ids">
						</td>
					</tr>
					<tr>
						<td class="label">Date:</td> 
						<td class="field"><input type="text" value="" id="date_of_attendances">
						</td>
					</tr>
					<tr>
						<td class="label">Pregnancy Status:</td>
						<td class="field"><input type="text" value="" id="pregnancy_status2">
						</td>
					</tr>
					<tr>
						<td class="label">Anaemia Status:</td>
						<td class="field"><input type="text" value="" id="anaemia_status2">
						</td>
					</tr>
					<tr>
						<td class="label">VID:</td>
						<td class="field"><input type="text" value="" id="v_ids">
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
						<td><input type="hidden" value="<?php $id=$row['n_id']?>"id="record_id"></td>
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