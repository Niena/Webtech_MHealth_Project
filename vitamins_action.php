<?php
	include("gen.php");
	$cmd=get_datan("cmd");
	switch($cmd){
		case 1:
			//get one vaccine based on id
			get_vitamin();
			break;
			
			
		case 2:delete_vitamin();
		break;


		case 3:
		update_vitamin();
		break;
		
		case 4:
		add_vitamin();
		break;
		
		default:
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","unknown command");
			echo "}";		
			
	}
	
	
	function get_vitamin(){
		include_once("vitamins_functions.php");
		
		$id=get_datan("id");
		$v=new vitamins();
		$row=$v-> select_name($id);
		if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","vitamins not found");
			echo "}";
			return;
		}
		
		
		echo "{";
			echo jsonn("result",1) .",";
			echo '"vitamins":{';
			echo jsonn("id",$id).",";
			//name
			echo jsons("v_name",$row['v_name']).","; ;
			//Quantity
			echo jsonn("quantity",$row['quantity']) ;
			//url
		//	echo jsons("url",$row['url']);
			echo "}";
		echo "}";
	}
	
	function update_vitamin(){
	include_once("vitamins_functions.php");
		$v=new vitamins();
		$id=get_datan("id");
		$quantity=get_datan('quantity');
		$v_name=get_data ('v_name');
		
		if(!$id){
			echo ' {"result":0, "message":"id not found"   }  ';
			return;		
		}
		
		
		if(!$v->update_vitamin($id,$v_name,$quantity) ){
			echo '{"result" :0, "message": "id not found"  }';
		}
		
		else{
		echo ' { " result": 1, "message": "updated" }';
			}
	
	}
	
		
	function get_all(){
	
	include_once("vaccines.php");
		
		//$id=get_datan("id");
		$v=new vaccines();
		$row=$v->get_all_vaccines();
		if(!$row){
			echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","vaccine not found");
			echo "}";
			return;
		}
	
	
		echo "{";
			echo jsonn("result",1) .",";
			echo '"vaccine":{';
			
			//echo jsonn("id",$id);
			//name
			echo jsons("v_name",$row['vaccine_name']) ;
			//schedule
			echo jsonn("schedule",$row['schedule']) ;
			//url
			echo jsons("url",$row['url']);
			echo "}";
		echo "}";
	
	
	}

	function delete_vitamin(){
	include_once("vitamins_functions.php");
		
		$v=new vitamins();
		$id=get_datan("id");
		
	
		if(!$v->delete_vitamin($id)){
		echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Error with deletion");
			echo "}";
			return;
		}
		else {
		echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Deleted!");
			echo "}";
			
		
		}
	
	}
	
	function add_vitamin(){
	include_once("vitamins_functions.php");
		
		$v=new vitamins();
		$v_name=get_data("v_name");
		$quantity=get_datan("quantity");
	
		if(!$v->add_vitamin($v_name, $quantity)){
		echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","Error with deletion");
			echo "}";
			return;
		}
		else {
		echo "{";
			echo jsonn("result",0). ",";
			echo jsons("message","successfully added!");
			echo "}";
			
		
		}
	
	}
	
	
	
?>