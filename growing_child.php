<?php
	include_once("adb.php");

	class growing_child extends adb{
		function growing_child(){
			adb::adb();	
		}
//have used
		//allows for data entry
		 function add_gcDetail($community_member_id,$height,$weight,$sick_or_not){
			return $this->query("insert into growing_child(community_member_id,height,weight,sick_or_not) 
		  values('$community_member_id','$height','$weight','$sick_or_not')");
		}
//have used		
		//deletes a row
		function delete_gcDetail($id){
			return $this->query("delete from growing_child where growing_child.cg_id=$id");
		}
//have used
		//updates thie information of a child
		function update_gcDetails($cg_id,$cm_id,$height,$weight,$health){

			return $this->query("update growing_child set community_member_id='$cm_id',weight='$weight', height='$height', sick_or_not='$health' WHERE cg_id= $cg_id");
		}
//have used		
	// displays the child welfare id, the community id, the fullname, the height, the weight and the health status of a growing child
		function details_gc($id){
		$query="select cg_id, growing_child.community_member_id,fullname, height, weight,sick_or_not from growing_child,community_members where growing_child.community_member_id=community_members.community_member_id and cg_id= $id";
		if(!$this->query($query)){
				return false;
			}
			return $this->fetch();
		
			}
//have used		
		//a query to search for childeren with a particular name
		function search_gc($gc_name){
			$query="select cg_id, fullname, height, weight,sick_or_not from growing_child,community_members where growing_child.community_member_id=community_members.community_member_id and fullname like '%$gc_name%'";
			
			if(!$this->query($query)){
				return false;
			}
			return $this->fetch();
			
		}
		
		//have used list
		function gc_listAll(){
			return $this->query("select cg_id, fullname, height, weight,sick_or_not from growing_child,community_members where growing_child.community_member_id=community_members.community_member_id");
		}
//have used		
		//a query to count the number children who are sick
		function number_sick(){
			$query="select count(*) As number from growing_child  where sick_or_not='yes'" ;
			if(!$this->query($query)){
				return false;
			}
			return $this->fetch();	
		}
		
		
		//The query below were not used in this ajax version of the project
		
		// a query to select children of a particular age
		function child_age($age){
		return $this->query("select * from community_members where age =$age");
		}

		// a query to select children who are under a particular weight
		function underWeight(){
		return $this->query("select * from growing_child where weight<2.00");
		}
		
		//a query to list everything in the table
		function listgc(){
			return $this->query("select fullname, community_member_id from community_members");
		}
		
		//a query to get a paticular detail
		function one_gc($gc_id){
			return $this->query("select community_member_id,height, weight,sick_or_not from growing_child where cg_id= $gc_id");
		}

		//a query to the nutrition id of chidren
		//function n_id($cm_id){
		//	return $this->query("select n_id FROM nutrition where community_member_id= $cm_id");
		//}
	}

?>