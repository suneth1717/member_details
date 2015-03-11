<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('url'));
        $this->load->database();
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('array');
        $this->load->library('form_validation');
    }

    function index() {
        $this->load->helper(array('form'));
        $this->load->view('login_view');
    }

    function signUp() {
        $data['message'] = $this->session->flashdata('message');
        $this->load->view('signUp_view', $data);
    }

    function signup_data_save() {
        $data = array(
            'username' => $this->input->post('username'),
            'pw' => $this->input->post('password')
        );
        $result = $this->user->insert_signup_data($data);
        if ($result == true) {
            $this->session->set_flashdata('message', '1');
            redirect('login/signUp');
        } else {

            $this->session->set_flashdata('message', '2');
            redirect('login/signUp');
        }
    }

    function check_username() {
      $target = isset($_POST['target']) ? $_POST['target'] : 'default_target_value';
       $result=$this->user->check_username($target);
        if($result==false){
           $output=true;
        echo json_encode($output); 
        }else{
            $output=false;
        echo json_encode($output);
        }
       
    }

}
?>

