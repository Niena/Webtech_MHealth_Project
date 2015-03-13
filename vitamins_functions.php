<?php

	include_once("adb.php");
	
	class vitamins extends adb{
	
		function vitamins(){
		adb::adb();
		}
		
	//display all

	function display_all(){

		$query="select * from vitamins ";
		if(!$this->query($query)){return false;}
		return $this->query($query);
		
	}
	
	//update
	
	function update_vitamin($id,$v_name,$quantity){
	
	$query =" update vitamins set v_name ='$v_name', quantity= $quantity where v_id=$id ";
	
	if(!$this->query($query))
	{
		return false;
	}
	
		return $this->query($query);
	
	
	}
	
	//select name
	
	function select_name ($id){
	
		$query="select v_name,quantity from vitamins where v_id =$id";
	
		if(!$this->query($query)){return false;}
	
		return $this->fetch();
	
	}
	
	function get_vitamin($id){
	$query="select * from vitamins where v_id=$id";
	if(!$this->query($query)){
	return false;
	}
	return $this->fetch();
	}
	
	
	function delete_vitamin($id){
	$query="delete from vitamins where v_id=$id";
			
	if(!$this->query($query)){
		return false;
	}
		return true;
	
	}
		
	function add_vitamin($v_name, $quantity){
	
	$query="insert into vitamins (v_name,quantity) values ('$v_name',$quantity)";
			
	
	if(!$this->query($query)){
		return false;
	}
		return true;
	
	}		


}

?>