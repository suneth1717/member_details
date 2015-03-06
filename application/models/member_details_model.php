<?php
/* * ***************************************************************************
 * File name     : member_details_model.php
 * Project name  : member_details
 * MVC           : model
 * Function      : insert data and retrive data from member_details database member_details_tb table. 
 * *****************************************************************************
 */
class member_details_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function set_details_member($data) {
        return $this->db->insert('member_details_tb', $data);
    }

    public function update_image($data, $image_path1) {
        $upload = array(
            'profile_pic' => $image_path1
        );
        $this->db->where('member_id', $data['member_id']);
        return $this->db->update('member_details_tb', $upload);
    }
    function search_member($id,$name){
        $where = "(member_name LIKE '%".$name."%')";
        $this->db->select('*');
        $this->db->where('member_id',$id);
        $this->db->or_where($where);
        $query=$this->db->get('member_details_tb');
        return $query->result_array();                           
    }
    function get_last_member_id(){
        $this->db->select('member_id');        
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $query=$this->db->get('member_details_tb');
        return $query->result_array();  
    }
    function get_more_details($id){
        $this->db->select('*');
        $this->db->where('member_id',$id);
        $query=$this->db->get('member_details_tb');
        return $query->result_array();
    }
    function update_details_member($data){
        //echo $data['member_id'];
        $datas=array(
            'birthday'=>$data['birthday'],
            'member_name'=>$data['member_name'],
            'phoneno_m'=>$data['phoneno_m'],
            'phoneno_m2'=>$data['phoneno_m2'],
            'phoneno_h'=>$data['phoneno_h'],
            'personal_address'=>$data['personal_address'],
            'email'=>$data['email'],
            'skype_id'=>$data['skype_id'],
            'profession'=>$data['profession'],
            'company_name'=>$data['company_name'],
            'company_address'=>$data['company_address'],
            'fax_no'=>$data['fax_no']
        );
        $this->db->where('member_id',$data['member_id']);
        return $this->db->update('member_details_tb',$datas);
    }
    function delete_member($id){
        $datas=array('delete_state'=>1);
       $this->db->where('member_id', $id);
        $this->db->update('member_details_tb',$datas); 
    }
}
