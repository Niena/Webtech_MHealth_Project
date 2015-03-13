
<?php

	include_once("adb.php");
	
	class school_feeding extends adb{
		
			function school_feeding(){
				adb::adb();
			}

			//allows for data entry
			function add_sfdetail($nStudents,$n_sfStudents,$date,$s_id){
			return $this->query("insert into school_feeding(num_students,num_students_feeding_pro,date_of_collection,school_id) 
			values('$nStudents','$n_sfStudents','$date','$s_id')");
			}
			
		   //deletes a row
			function delete_school($sid){
			return $this->query("delete from school_feeding where sf_id=$sid");
			}
			
			//edit a row
			function update_sFeeding($id,$nStudents,$n_sfStudents,$date,$s_id){
			return $this->query ("update school_feeding set num_students='$nStudents',num_students_feeding_pro='$n_sfStudents',date_of_collection='$date',school_id='$s_id'
			where sf_id=$id");
			}

			// this function runs a query to select date based on given month
			 function searchByMonth($month){
		     return $this->query("select * from school_feeding where year(date)='$month'");
		    }
			
			//this function selects all the rows in the school feeding table
			function listAll()
			{ return $this->query("select * from school_feeding");

			}
			
			////this function selects all the rows in the school feeding table and displays the school name instead of school id
			function listAll2()
			{ return $this->query("select  sf_id,num_students,num_students_feeding_pro,date_of_collection,school_name from school_feeding,schools
			where school_feeding.school_id=schools.school_id group by sf_id");

			}
			
			
			//this fuction selects a whole row based on given id
			function listID($sid){
			 return $this->query("select * from school_feeding where sf_id='$sid'");

			}
			
			//this function selects all the schools based on the given id
			function searchBySchoolID($school)
			{ return $this->query("select * from school_feeding where school_id='$school'");

			}
			
			//this function selects all the rows with any value that is similar to the search keyword
			function generalSearch($var){
			return $this->query("select sf_id,num_students,num_students_feeding_pro,date_of_collection,school_namefrom school_feeding,schools
			where (sf_id=$var or num_students_feeding_pro =$var or school_name like '%$var%' or date_of_collection=$var)");
			}
			
            //This function lists all the schools and school names
			function listSchools(){
			return $this->query("select school_id,school_name from schools");
			}


}

?>
