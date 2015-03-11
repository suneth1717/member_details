<?php
Class user extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('id, username, password');
   $this -> db -> from('users');
   $this -> db -> where('username', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 function insert_signup_data($data){
     $data1=array(
         'username'=> $data['username'],
         'password'=> MD5($data['pw'])
     );
     return $result=$this->db->insert('users',$data1);
 }
 function check_username($username){
     $this->db->select('username');
     $this->db->from('users');
     $this->db->where('username',$username);
     $query=$this->db->get();
     return $query->result(); 
 }
}
?>
