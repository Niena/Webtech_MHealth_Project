<?php
	session_start();	//start session
	if(!isset($_SESSION['username'])){	//check if the user data is in the session
		header("location: login.php");	//if not redirect back to user
	}
	//	$gc_name="";
?>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="style.css">
		<script src="jquery-1.11.0.js"></script>
		<script src="gen.js"></script>
		<script>
					//makes a synchronous call to the page u and return the 
			//result as object
			 var cur_id=0;
			 var com_id=0;	
			 var nid=0;
			
			function myValidation()
			{
				var num=document.getElementById("height").value;

				var obj=document.getElementById("weight").value;

				if(num==""||isNaN(num))
					{
					alert("Child Weight takes numeric");
					}
					
					if(obj==""||isNaN(obj))
					{
					alert("Child Height takes Numeric");
					}
				
			}
			
			
			function syncAjax(u){
				var obj=$.ajax(
					{url:u,
					 async:false
					 }
				);
				return $.parseJSON(obj.responseText);
				
			}	
			
			function add(obj){
				$("#com_id").prop("value", "");
				$("#height").prop("value", "");
				$("#weight").prop("value", "");
				$("#sick_or_not").prop("value", "");
				
				//show the form
				//find where the user clicked and store it in x and y
				var y=event.clientY;
				var x=event.clientX/2;
				//use x and y to set the location of the form
				$("#divAdd").css("top",y);
				$("#divAdd").css("left",x);
				//display the form
				$("#divAdd").fadeIn(500);
			}
			//returns a result object for one vaccine 
			function getVaccine(id){
			     
				var u="gc_action.php?cmd=1&id="+id;
				return syncAjax(u);
			}
			//makes asynchronous call to the save page
			function save(){
				//complete the url
			var vh=$("#height").val();
			var vw=$("#weight").val();	
			var vc=$("#com_id").val();
			var vs=$("#sick_or_not").val();
			
			if(vh==""||isNaN(vh))
					{
					alert("Child Height takes numeric");
					}
				
			else if(vw==""||isNaN(vw))
					{
					alert("Child Weight takes Numeric");
					}
			
			
			else if(vc==""||isNaN(vc))
					{
					alert("Child Weight takes Numeric");
					}
			
			else if(!(vs==""||isNaN(vs)))
					{
					alert("Sick_or_not takes in yes or no");
					}
			else{
				var u="gc_action.php?cmd=2&id="
				+vc+"&vh="
				+vh+"&vw="
				+vw+"&vs="
				+vs;
				
				var r=syncAjax(u);
				location.reload();
				if(r.result==0){
					$("divStatus").text(r.message);
					return;
				}
				$("divStatus").text(r.message);
				cancel();
			}
			}
					
		function search_name(){
			var gc_name=$("#txtSearch").val();
			var u="gc_action.php?cmd=5&vs="
					+gc_name;
			var r=syncAjax(u);
			
			if(r.result==0){
				$("divStatus").text(r.message);
				return;
			}
			//removes the exsisting rows
			$('.row1').remove();
			$('.row2').remove();
				
			var table = document.getElementById('rTable');

			//creates new row with search results
			var counter=0;
			for(i=0;i<r.gChild.length;i++){
				var row=table.insertRow(i+1);
			
				var cell1=row.insertCell(0);
				var cell2=row.insertCell(1);
				var cell3=row.insertCell(2);
			
				var temp=r.gChild[i].cid;
				alert(temp);
				cell1.innerHTML=r.gChild[i].cid;
				cell2.innerHTML=r.gChild[i].fullname;
				cell3.innerHTML="<span class='hotspot' ><a href='gc_details.php?id="+temp+"'>view<span></a>";
				counter++
		
			}
		}
	
		//@param obj displays a report form
		function report(obj){
	
			//show the form
			//find where the user clicked and store it in x and y
			var u="gc_action.php?cmd=6";
			var r=syncAjax(u);
			
			$("#lb").text(r.count);
			var y=event.clientY;
			var x=event.clientX/2;
			//use x and y to set the location of the form
			$("#divReport").css("top",y);
			$("#divReport").css("left",x);
			//display the form
			$("#divReport").fadeIn(500);
		}

		//hides the add form
		function cancel(){
		$("#divAdd").fadeOut(500);
		}
		
		//hides the report form
		function report_cancel(){
			$("#divReport").fadeOut(500);
		}
	
		//$.getJSON(u,saveDone(one data successfully saved");
		function saveDone(data){			
			alert(data);
		}
			
		</script>
	</head>
	<body>
		<table>
			<tr>
				<td colspan="2" id="pageheader">
					health Information System
				</td>
			</tr>
			<tr>
				<td id="mainnav">
					<div class="menuitem">location</div>
					<div class="menuitem">opd cases</div>
					<div class="menuitem">health promotion</div>
					<div class="menuitem">nutrition</div>
					<div class="menuitem"><a href="gc_list.php">child welfare</a></div>
					<div class="menuitem">family planning</div>
					<div class="menuitem"><a href="logout.php">logout<a></div>
				</td>
				<td id="content">
					<div id="divPageMenu">
						<span class="menuitem" >sub districts</span>
						<span class="menuitem" >communities</span>
						<span class="menuitem" >view map</span>
						<input type="text" id="txtSearch">
						<span class="menuitem" onclick="search_name(this)">search</span>		
					</div>
					<div id="divStatus" class="status">
						status message
					</div>
					<span class='hotspot' onclick='report(this)'>   View report</span>
			<span class='hotspot' onclick='add(this)'>Add</span>
					<div id="divContent">
						Child Welfare 
										
			
			
			
	
						<table class="reportTable" width="100%" id="rTable">
							<tr class="header" >
								<td>ID</td>
								<td>Child Name</td>
								<td></td>
							</tr>
<?php


			
			// isset checks if the data exsists and it is valid.  Data sent form the broweser is stored in the request array to be used by the sever
	//if(isset($_REQUEST["fullname"])){
	////	$gc_name=$_REQUEST["fullname"];
	//}
			//creates a growing child object
	include ("growing_child.php");
	$obj= new growing_child();
	if(! $obj->gc_listAll()){
		echo"Error getting all content";
	}

	
	$row=$obj->fetch();
	$row_counter=0;
	while($row){
		
		if($row_counter%2==0){
			$style=" class='row1' ";
		}else{
			$style=" class='row2'  ";
		}	
		$id=$row["cg_id"];
		echo "<tr $style >";
			echo "<td >$id</td>";
			echo "<td ><a href='gc_details.php?id=$id'>$row[fullname]</a></td>";
			echo "<td ><span class='hotspot' ><a href='gc_details.php?id=$id'>view<span></a></td>";
			
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
	<div id="divAdd" class="popupForm">
		<table class="tableForm" >
					<tr>
						<td class="label">Hospital ID: </td>
						<td class="field"><input type="text" value="" id="com_id" ></td>
					</tr>
					<tr>
						<td class="label">Height:</td> 
						<td class="field"><input type="text" value="" id="height" >
						</td>
					</tr>
					<tr>
						<td class="label">Weight:</td>
						<td class="field"><input type="text" value="" id="weight" >
						</td>
					</tr>
					<tr>
						<td class="label">Sick_or_Not:</td>
						<td class="field"><input type="text" value="" id="sick_or_not" >
						</td>
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
	
	
	
			<div id="divReport" class="popupForm">
		<table class="tableForm" >
					<tr>
						<td class="label"><?php echo"Total number of Sick people: "?></td> <td class="label" id="lb"> </td>
					</tr>		
					<tr>
						<td class="label" id="lb"> </td>
						<td class="field">
							<input type="button" value="ok" onclick="report_cancel()" >
						</td>
					</tr>
			</table>
				
	</div>
	
		
	
	</body>
</html>	