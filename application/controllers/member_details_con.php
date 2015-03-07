<?php

/* * ***************************************************************************
 * File name     : app_con.php
 * Project name  : member_details
 * MVC           : Controller
 * Function      : Insert member details and display in to tables.
 * 
 * *****************************************************************************
 */

class member_details_con extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('member_details_model');
        $this->load->helper(array('url'));
        $this->load->database();
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('array');
        $this->load->library('form_validation');
    }

    /**
     * author R.A.S.P Senanayake. 
     * index()
     * Display web_page view.  /////
     */
    function index() {
        $data['message'] = $this->session->flashdata('message');
        $this->load->view('web_page', $data);
    }

    /**
     * author R.A.S.P Senanayake. 
     * member_data_set()
     * Get form data and save to the database.  
     */
    function member_data_set() {
        $id_result = $this->member_details_model->get_last_member_id();
        $str = $id_result[0]["member_id"];
        $array = str_split($str);
        $numbers = $array[1] . $array[2] . $array[3] . $array[4];
        $num = (int) $numbers + 1;

        if ($num >= 0 && $num <= 9) {
            $member_id = 'M000' . $num;
        } elseif ($num >= 10 && $num <= 99) {
            $member_id = 'M00' . $num;
        } elseif ($num >= 100 && $num <= 999) {
            $member_id = 'M0' . $num;
        } elseif ($num >= 1000 && $num <= 9999) {
            $member_id = 'M' . $num;
        } else {
            echo 'Incorrect member number.';
        }
        $data = array(
            'member_id' => $member_id,
            'birthday' => $this->input->post('dob'),
            'member_name' => $this->input->post('name'),
            'phoneno_m' => $this->input->post('phoneNo1'),
            'phoneno_m2' => $this->input->post('phoneNo2'),
            'phoneno_h' => $this->input->post('phoneNo3'),
            'personal_address' => $this->input->post('address'),
            'email' => $this->input->post('email'),
            'skype_id' => $this->input->post('skype'),
            'profession' => $this->input->post('profession'),
            'company_name' => $this->input->post('company'),
            'company_address' => $this->input->post('companyAdd'),
            'fax_no' => $this->input->post('fax')
        );
        $result = $this->member_details_model->set_details_member($data);

        $quary = null;
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_path = $file['tmp_name'];

        if ($file_name != "" && ($file_type = "image/jpeg" || $file_type = "image/png" || $file_type = "image/gif" ) && $file_size <= 1048576)
            $image_path = 'C:/wamp/www/member_details/images/'; //set the path to the images folder in the server before run.
        $image_path1 = base_url() . 'images' . '/' . $file_name;
        if (move_uploaded_file($file_path, $image_path . $file_name))
            $quary = $this->member_details_model->update_image($data, $image_path1);
        if ($result == true & $quary == true) {

            $this->session->set_flashdata('message', '1');
            redirect('member_details_con/index');
        } else {

            $this->session->set_flashdata('message', '2');
            redirect('member_details_con/index');
        }
    }

    /**
     * author R.A.S.P Senanayake. 
     * index()
     * Display insert_web_page view.  
     */
    function show_serach() {
        $data['message'] = $this->session->flashdata('message');
        $this->load->view('insert_web_page', $data);
    }

    /**
     * author R.A.S.P Senanayake. 
     * show_member_details()
     * Search the data by id or name and dispay in the member_details_display_page view .  
     */
    function show_member_details() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        if ($name == null) {
            $name = 1;
        }

        $data['result'] = $this->member_details_model->search_member($id, $name);
        //var_dump($data);
        //echo $data['result'][0]['delete_state'];
        //echo count($data['result']);
        $y = 0;
        for ($x = 0; $x < count($data['result']); $x++) {
            if ($data['result'][$x]['delete_state'] == 1) {
                $y++;
            }
        }
        if ($y == count($data['result'])) {
            $this->session->set_flashdata('message', '2');
            redirect('member_details_con/show_serach');
        } else {
            $i = 0;
            for ($x = 0; $x < count($data['result']); $x++) {
                if ($data['result'][$x]['delete_state'] == 0) {
                    //echo $x;
                    $newData['result'][$i] = $data['result'][$x];
                    $i++;
                }
            }
            //var_dump($newData);

            if ($data['result'] == false) {
                $this->session->set_flashdata('message', '2');
                redirect('member_details_con/show_serach');
            } else {

                $this->load->view('member_details_display_page', $newData);
            }
        }
    }

    /**
     * author R.A.S.P Senanayake. 
     * more_details()
     * Display more details on more_details_web_page view.  
     */
    function more_details() {
        $id = $this->uri->segment(3);
        $result['result'] = $this->member_details_model->get_more_details($id);
        $this->load->view('more_details_web_page', $result);
    }

    function edit_details() {
        $id = $this->uri->segment(3);
        $result['result'] = $this->member_details_model->get_more_details($id);
        //var_dump($result);
        $this->load->view('edit_member_details', $result);
    }

    function update_member_data() {
        $data = array(
            'member_id' => $this->input->post('member_id'),
            'birthday' => $this->input->post('dob'),
            'member_name' => $this->input->post('name'),
            'phoneno_m' => $this->input->post('phoneNo1'),
            'phoneno_m2' => $this->input->post('phoneNo2'),
            'phoneno_h' => $this->input->post('phoneNo3'),
            'personal_address' => $this->input->post('address'),
            'email' => $this->input->post('email'),
            'skype_id' => $this->input->post('skype'),
            'profession' => $this->input->post('profession'),
            'company_name' => $this->input->post('company'),
            'company_address' => $this->input->post('companyAdd'),
            'fax_no' => $this->input->post('fax')
        );
        $result = $this->member_details_model->update_details_member($data);
    }

    function delete_member() {
        $id = $this->uri->segment(3);
        $result['result'] = $this->member_details_model->get_more_details($id);
        //var_dump($result);
        $this->load->view('delete_member', $result);
    }

    function delete_a_member() {
        $member_id = $this->input->post('member_id');
        //$member_id; 
        $result = $this->member_details_model->delete_member($member_id);
        echo $result;
        if ($result == 1) {
            $this->session->set_flashdata('message', '3');
            redirect('member_details_con/show_serach');
        } else {
            echo "Database error!";
        }
    }
    function deleted_members(){
        $data['result'] = $this->member_details_model->get_deleted_member_details();
        //var_dump($result);
        $this->load->view('old_members_display_page', $data);
    }
    function delete_old_member(){
       $id = $this->uri->segment(3);
        $result['result'] = $this->member_details_model->get_more_details($id);
        //var_dump($result);
        $this->load->view('delete_old_member', $result); 
    }
    function deleteOldMember(){
        $member_id = $this->input->post('member_id');
        //echo $member_id;
        $result = $this->member_details_model->delete_old_member($member_id);
        if ($result == 1) {
            $this->session->set_flashdata('message', '3');
            redirect('member_details_con/show_serach');
        } else {
            echo "Database error!";
        }
    }

}
