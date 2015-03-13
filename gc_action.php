<?php
	include("gen.php");
	$cmd=get_datan("cmd");//get datan makes sure that the browser does not show any responses
	//echo "are u called";
	switch($cmd){
		case 1:
			//gets all the child welfare details including the fullname
			get_gChild();
			break;
		case 2:
			//adds a new child welfare detail
			add_gcDetail();
			break;
		case 3:
			//updates any chances made to the child welfare detail
			update_gChild();
			break;
		case 4:
			//deletes a child welfare detail
			del_gDetail();
			break;
		case 5:
			//searches all people with a paticular detail
			search_gc();
			break;
		case 6:
		//get the number of sick children
			report_gc();
			break;
		default:
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","unknown command");
			echo "}";
	}
	
	
	function get_gChild(){
		//creates an object of the growing child class
		include ("growing_child.php");
			$id=get_datan("id");
			$obj=new growing_child();
			//calls the querry that shows the details of a child
			$row=$obj->details_gc($id);
	
			if(!$row){
				echo "{";
				echo jsonn("result",0). ",";
				echo jsons("message","Details not found");
				echo "}";
				return;
			}
			//returns an array object with all the child welfare details including the fullname	
			echo "{";
			echo jsonn("result",1). ",";
			echo '"gChild":{';
			echo jsonn("cg_id",$id). ",";
			echo jsonn("cid",$row['community_member_id'] ).",";
			echo jsons("fullname",$row['fullname']).",";
			echo jsonn("height",$row['height']).",";
			echo jsonn("weight",$row['weight']).",";
			echo jsons("sick_or_not",$row['sick_or_not']);
			echo "}";
			echo "}";
	}
	//add a new child welfaredetail
	function add_gcDetail(){
		$id= get_datan('id');
		$vh= get_datan('vh');
		$vw=get_datan('vw');
		$vs=get_data('vs');
		
		//echo "let it goo";
		if(!$id){
		//display message
			echo'{"result":0,"message":"Unable to add. Non-exsisting hospitail ID"}';
		return;
		}
		include ("growing_child.php");
			$g=new growing_child();
		if(!$g->add_gcDetail($id,$vh,$vw,$vs))
		{
		echo'{"result":0,"message":"Unable to add"}';
		return;
		}
		echo'{"result":1,"message":"One item has sucessfully been add"}';
	}
	
	//updates an changes in the child welfare detail
	function update_gChild(){
		$id= get_datan('id');
		$vh= get_datan('vh');
		$vw=get_datan('vw');
		$vs=get_data('vs');
		$vc=get_datan('vc');
		
		if(!$id){
		//display message
			echo'{"result":0,"message":"not working"}';
		return;
		}
		include ("growing_child.php");
			$g=new growing_child();
		if(!$g->update_gcDetails($id,$vc,$vh,$vw,$vs))
		{
		echo'{"result":0,"message":"unable to update"}';
		return;
		}
		echo'{"result":1,"message":"One item has sucessfully been updated successfully"}';
	}
	
	//deletes a child welfare detail
	function del_gDetail(){
		$id= get_datan('id');

		//echo "let it goo";
		if(!$id){
		//display message
		echo'{"result":0,"message":"not working"}';
		return;
		}
		include ("growing_child.php");
		$g=new growing_child();
		if(!$g->delete_gcDetail($id))
		{
		echo'{"result":0,"message":"unable to delete"}';
		return;
		}
		echo'{"result":1,"message":"One item has sucessfully been deleted"}';
	}
	
	//searches for a child welfare detail
	function search_gc(){
	//creates an object of the growing class
		include ("growing_child.php");
		$vs=get_data("vs");
			$obj=new growing_child();
			//calls the querry that shows the details of a child
			$row=$obj->search_gc($vs);
	
			if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Details not found");
			echo "}";
			return;
		}
				
			echo "{";
			echo jsonn("result",1). ",";
			echo '"gChild":[{';
			echo jsonn("cid",$row['cg_id'] ).",";
			echo jsons("fullname",$row['fullname']).",";
			echo jsonn("height",$row['height']).",";
			echo jsonn("weight",$row['weight']).",";
			echo jsons("sick_or_not",$row['sick_or_not']);
			echo "}]";
		echo "}";
	}
	//get the number of sick children
	function report_gc(){
	
		include ("growing_child.php");
		
		$obj=new growing_child();
		$row=$obj->number_sick();
	
		if(!$row)
			{
			echo'{"result":0,"message":"Unable to retrive report"}';
			return;
			}
		echo "{";
			echo jsonn("count",$row['number']);		
		echo "}";
	}
?>