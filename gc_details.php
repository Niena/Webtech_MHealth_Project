
<?php
	session_start();	//start session
	if(!isset($_SESSION['username'])){	//check if the user data is in the session
		header("location: login.php");	//if not redirect back to user
	}
		$gc_name="";
?>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="style.css">
		<script src="jquery-1.11.0.js"></script>
		<script src="gen.js"></script>
		<script>
		
			 var cur_id=0;
			 var com_id=0;	
			
			 var t;
			//makes a synchronous call to the page u and return the 
			//result as object 
			function syncAjax(u){
				var obj=$.ajax(
					{url:u,
					 async:false
					 }
				);
				return $.parseJSON(obj.responseText);
				
			}
			
			function gc_delete(obj, id){
				cur_id=id;
				//show the form
				//find where the user clicked and store it in x and y
				var y=event.clientY;
				var x=event.clientX/2;
				//use x and y to set the location of the form
				$("#divDelete").css("top",y);
				$("#divDelete").css("left",x);
				//display the form
				$("#divDelete").fadeIn(500);
			
			}
			
			function edit(obj,id){
				cur_id=id;
				var r=getVaccine(id);
				if(r.result==0){
					//show error message
					//document.getElementById("divStatus").innerHTML=r.message;
					//or
					showStatus(r.message);
					return;
				}
				//document.getElementById("divStatus").innerHTML=r.message;
				//get the data from object r and put it in the form
				$("#fullname").prop("value", r.gChild.fullname);
				$("#height").prop("value", r.gChild.height);
				$("#weight").prop("value", r.gChild.weight);
				$("#sick_or_not").prop("value", r.gChild.sick_or_not);
				
				//show the form
				//find where the user clicked and store it in x and y
				var y=event.clientY;
				var x=event.clientX/2;
				//use x and y to set the location of the form
				$("#divEdit").css("top",y);
				$("#divEdit").css("left",x);
				//display the form
				$("#divEdit").fadeIn(500);
			}
			
			//returns a result object for one vaccine 
			function getVaccine(id){
			     t=id;
				var u="gc_action.php?cmd=1&id="+id;
				return syncAjax(u);
			}
			
			//makes asynchronous call to the save page
			function save(){
			//gets values from the text feilds and stores them in variables
				var vf=$("#fullname").val();
				var vh=$("#height").val();
				var vw=$("#weight").val();
				var vs=$("#sick_or_not").val();
				var vc=$("#com_id").val();
				//checks if given height is numeric
				if(vh==""||isNaN(vh))
					{
					alert("Child Height takes numeric");
					}
				//checks if given weight is numeric	
				else if(vw==""||isNaN(vw))
					{
					alert("Child Weight takes Numeric");
					}
			
				//checks if given hospital ID is numeric
				else if(vc==""||isNaN(vc))
					{
					alert("Child Hospital ID must be Numeric");
					}
				//checks of sick_or_not is not numeric
				else if(!(vs==""||isNaN(vs)))
					{
					alert("Sick_or_not takes in 'yes' or 'no'");
					}
			
				else{
			
					var u="gc_action.php?cmd=3&id="
					+t+"&vh="
					+vh+"&vw="
					+vw+"&vs="
					+vs+"&vc="
					+vc;
				
					syncAjax(u);
					location.reload();
					if(r.result==0){
						showStatus(r.message);
					return;
					}
					showStatus(r.message);
					cancel();
				}
			}
		
			//deletes a child welfare detail of a person
			function yes(){
				var u="gc_action.php?cmd=4&id="
				+cur_id;
			
				syncAjax(u);
				location.reload();	
			}
		
			//hides the edit form
			function cancel(){
				$("#divEdit").fadeOut(500);
			}
		
			//Hides the delete form
			function del_cancel(){
				$("#divDelete").fadeOut(500);
			}
			
	
			function saveDone(data){	
				alert(data);
			}
			
			//@ param msg displays a given message on the messages status bar
			function showStatus(msg){
				var obj=document.getElementById('divStatus');
				$("#divStatus").prop("value", obj.innerHTML=msg);
			}
			
			
		</script>
	</head>
	<body>
	<?php
			//creates an object of the growing class
			include ("growing_child.php");
			$obj=new growing_child();

			if(!isset($_REQUEST["id"])){
				echo "no id";
				exit();
			}
			$vid=$_REQUEST["id"];
			
			//calls the query that shows the details of a child
			$row=$obj->details_gc($vid);
						
	?>
		<table>
			<tr>
				<td colspan="2" id="pageheader">
					<h1>Child Welfare Information</h1>
				</td>
			</tr>
			
			<tr>
				<td id="mainnav">
					<div class="menuitem">location</div>
					<div class="menuitem">opd cases</div>
					<div class="menuitem">health promotion</div>
					<div class="menuitem">nutrition</div>
					<div class="menuitem"><a href="gc_list.php">child welfare </a></div>
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
					</div>
					<div id="divStatus" class="status">
						status message
					</div>
					<div id="divContent">
						Child Welfare Details
		
						<table class="reportTable" width="100%" >
							<tr class="header" >
								<?php	echo'<td>'.	$row["fullname"].'</td>'?>
								<td></td>
								<td></td>
								
							</tr>

		<?php


				//Displays the headings in the child growth table
				echo"<tr>";
					echo"<td>";
						echo	"Height";
					echo"</td><td>";
						echo	"Weight";
					echo"</td><td>";
						echo	"Sick or Not";
					echo"</td><td>";
						echo	"Edit";
					echo"</td><td>";
						echo	"Delete";
				echo"</tr>";
				
					
				//Displays the fullname, height and weight of every one in the child growth table
							$id=$row["cg_id"];
					echo"<tr><td>"	;
						echo	$row["height"];
					echo"</td><td>";
						echo	$row["weight"];
					echo"</td><td>";
						echo	$row["sick_or_not"];
											
					echo"</td><td>";
						echo "<span class='hotspot' onclick='edit(this,$vid)'>edit<span></td>";
										
					echo"</td><td>";
						echo "<span class='hotspot' onclick='gc_delete(this,$vid)'>delete<span></td>";	
						
			
		?>

	
						</table>
					</div>
				</td>
			</tr>
		</table>
	<div id="divEdit" class="popupForm">
		<table class="tableForm" >
					<tr>
						<td class="label">Fullname: </td>
						<td class="field"><input type="text" value="" id="fullname" ></td>
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
						<td class="field"><input type="hidden" value="<?php echo $row['community_member_id'] ?>" id="com_id" ></td>
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
	


	<div id="divDelete" class="popupForm">
		<table class="tableForm" >
					<tr>
						<td class="label"><?php echo"Are you sure you want to delete ". $row['fullname']."?"?></td>
					</tr>		
					<tr>
						<td class="label"></td>
						<td class="field">
							<input type="button" value="yes" onclick="yes()" >
							<input type="button" value="no" onclick="del_cancel()" >
						</td>
					</tr>
			</table>
				
	</div>

	
	
	</body>
</html>	






















