 <?php
	// session_start();	//start session
	// if(!isset($_SESSION['username'])){	//check if the user data is in the session
		// header("location: login.php");	//if not redirect back to user
	// }
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
			var t;
			var addKey=-1;
			function syncAjax(u){			
				var obj=$.ajax(
					{url:u,
					 async:false
					 }
				);
				return $.parseJSON(obj.responseText);
				
			}
			function edit(obj,id,event){
			
				var r=  get_vitamin(id);				
				if(r.result==0){
					return ;
				}
				//get the data from object r and put it in the form
				$("#v_name").prop("value", r.vitamins.v_name );
				$("#quantity").prop("value", r.vitamins.quantity);
			
				//find where the user clicked and store it in x and y
				var y=event.clientY;
				var x=event.clientX/2;
				//use x and y to set the location of the form
				$("#divEdit").css("top",y);
				$("#divEdit").css("left",x);
				//display the form
				$("#divEdit").fadeIn(700);
			}
			
			//Delete function
			function Delete(id){
			t=id;
			var u="vitamins_action.php?cmd=2&id="+t;
			return syncAjax(u);
				// if(r.result==0){
					// return ;
				// }
			
			}
			
			//Add new vitamin
			function add(event){
			
				addKey=1;
				
				 var y=event.clientY;
				 var x=event.clientX/2;
				//use x and y to set the location of the form
				 $("#divEdit").css("top",y);
				 $("#divEdit").css("left",x);
				//display the form
				$("#divEdit").fadeIn(700);
				
			
			}
			
			
			
			//returns a result object for one vaccine 
			function get_vitamin(id){
			t = id;
				var u="vitamins_action.php?cmd=1&id="+t;
				return syncAjax(u);
			}
			//makes asynchronous call to the save page
			function save(){
			
				
				 var v_name= document.getElementById("v_name").value;				
				 var quantity = document.getElementById("quantity").value;
				
				if (addKey>0){
					var u="vitamins_action.php?cmd=4&v_name="+v_name + "&quantity="+quantity;
					}
					
				else{  var u="vitamins_action.php?cmd=3&id="+t+"&v_name="+v_name + "&quantity="+quantity ; }
				
				var r=syncAjax(u);
				
				$.getJSON(u,saveDone);
				
				cancel();
						
			}
			
			function saveDone(data){
				
				alert("Saved Succesfully");
			}
			//hides the form
			function cancel(){
				//fade out the form in half a second
				$("#divEdit").fadeOut(100);
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
					<div class="menuitem">nutrition</div>
					<div class="menuitem">child welfare</div>
					<div class="menuitem">family planning</div>
					<div class="menuitem"><a href="logout.php">logout<a></div>
				</td>
				<td id="content">
					<div id="divPageMenu">
						<span class="menuitem" >sub districts</span>
						<span class="menuitem" >communities</span>
						<span class="menuitem" >view map</span>
						<!--<input type="text" id="txtSearch"> -->
						<span class="hotspot" onclick='add(event)' >Add new Vitamin</span>	
						
						
						
					</div>
					<div id="divStatus" class="status">
						status message
					</div>
					<div id="divContent">
						Vitamins
						<table class="reportTable" width="100%" >
							<tr class="header" >
								<td>ID</td>
								<td>Vitamins</td>
								<td>Quantity</td>
								<td></td>
							</tr>
<?php	
	include("vitamins_functions.php");
	$obj=new vitamins();
	if(!$obj->display_all()){
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
		$id=$row['v_id'];
		echo "<tr $style >";
			echo "<td>$id</td>";
			echo "<td> <a >$row[v_name] </a></td>";
			echo "<td> <a >$row[quantity] </a></td>";
			echo "<td><span class='hotspot' onclick='edit(this,$id,event)'>edit<span></td>";
			echo "<td><span class='hotspot' onclick='Delete($id)'>Delete<span></td>";
			
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
						<td class="label">Vitamins Name: </td>
						<td class="field"><input type="text" value="<?php echo $row['v_name'] ?>" id="v_name" ></td>
					</tr>
					
					<tr>
						<td class="label"> Quantity </td>
						<td class="field"> <input type="text" value="<?php echo $row['quantity'] ?>" id="quantity" ></td>
					</tr>	
					<tr>	
							<input type="button" value="save" onclick="save()" >
							<input type="button" value="cancel" onclick="cancel()" >
						</td>
					</tr>
			</table>
				
	</div>
	</body>
</html>	