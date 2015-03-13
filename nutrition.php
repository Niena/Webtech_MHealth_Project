<?php

	include_once("adb.php");
	
	class nutrition extends adb{
		function nutrition(){
			adb::adb();
		}
		
//allows for data entry
 function add_n($community_member_id,$date_of_attendance,$prenancy_status,$anemia_status,$vid){
    return $this->query("insert into nutrition(community_member_id,date_of_attendance,pregnancy_status,anaemia_status,v_id) 
			values('$community_member_id','$date_of_attendance','$prenancy_status','$anemia_status','$vid')");
}
//deletes a row
function delete_n($n_id){
$delete_query=$this->query("delete from nutrition where n_id= $n_id");
return $delete_query;
}

//count the number of pregnant women
function num_preg_women(){
return $this->query("Select distinct count(*) as 'number of pregnant women'
from community_members

inner join nutrition
on nutrition.community_member_id = community_members.community_member_id and nutrition.pregnancy_status = 'yes'");
}

//number of pregnant women who visit the clinic on a particular day
function numpreg_on_day($date){
return $this->query("select distinct count(community_member_id) 
from nutrition 
where pregnancy_status = 'yes' and date_of_attendance = '$date'");
}

//number of patients who visit the clinic on a particular day
function numpeople_on_day($date){
return $this->query("select distinct count(community_member_id) 
from nutrition 
where date_of_attendance = '$date'");
}

function people(){
return $this->query("Select distinct community_members.fullname
from community_members, nutrition
where nutrition.community_member_id = community_members.community_member_id");
}
//count the number of pregnant women
function num_anaemic(){
return query("Select distinct count(*) as 'number of anaemic people'
from community_members
inner join nutrition
on nutrition.community_member_id = community_members.community_member_id and nutrition.anaemia_status = 'yes'");
}

//edits a row
function update_n($n_id,$community_member_id,$date_of_attendance,$prenancy_status,$anemia_status,$vid){
$update_n=$this->query("update nutrition set community_member_id='$community_member_id',
date_of_attendance='$date_of_attendance',pregnancy_status='$prenancy_status',
anaemia_status='$anemia_status',v_id=$vid where n_id=$n_id");
return $update_n;
}
//lists items in a table
function list_n2(){
return $this->query("select n_id,community_member_id,date_of_attendance,pregnancy_status,
anaemia_status,v_name from nutrition,vitamins where nutrition.v_id=vitamins.v_id group by n_id");
}

//lists all the items in a table
function list_n(){
return $this->query("select * from nutrition");
}
function list_One($n_id){
return $this->query( "select * from nutrition where n_id = $n_id");
}

}


?>