<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//LOCATION : application - controller - Auth.php

class Auth extends CI_Controller {

    private $app_name;

    public function __construct(){
        parent::__construct();
        $this->load->model('Common_model','common_model');
        $this->load->model('admin_model');
        $this->load->model('Setting_model');

        $app_setting = $this->Setting_model->get_details();
        
        $this->app_name=$app_setting->app_name;
    }

    public function index(){
        $data = array();

        if($this->session->userdata('is_login') == TRUE){
            redirect(base_url() . 'admin/dashboard', 'refresh');
        }

        $data['page_title'] = $this->lang->line('login_lbl');
        $this->load->view('admin/page/login', $data);
    }

    public function forgot_password(){
        $data = array();

        $data['page_title'] = $this->lang->line('forgot_password_lbl');
        $this->load->view('admin/page/forgot_password', $data);
    }

    public function login(){ 
  
        $this->form_validation->set_rules('username', 'Username', 'required');  
        $this->form_validation->set_rules('password', 'Password', 'required'); 

        if($this->form_validation->run())  
        {
             if($_POST)
             { 
                $query = $this->admin_model->validate_admin();
                
                //-- if valid
                if($query){
                    $data = array();
                    foreach($query as $row){
                        $data = array(
                            'id' => $row->id,
                            'username' => $row->username,
                            'email' =>$row->email,
                            'is_login' => TRUE
                        );
                        $this->session->set_userdata($data);
                        $url = base_url('dashboard');
                    }
                    redirect(base_url() . 'admin/dashboard', 'refresh');
                }else{

                    $message = array('message' => $this->lang->line('invalid_login_msg'),'class' => 'alert-danger');
                    $this->session->set_flashdata('response_msg', $message);
                    $this->index();
                }
                
            }
            else{
                redirect(base_url() . 'admin', 'refresh');
            }
        }
        else  
        {  
            $message = array('message' => $this->lang->line('input_required'),'class' => 'alert-danger');
            $this->session->set_flashdata('response_msg', $message);
            redirect(base_url() . 'admin');
        }
    }

    public function forgot_password_form(){ 
  
        $this->form_validation->set_rules('email', $this->lang->line('email_require_lbl'), 'required');

        if($this->form_validation->run())  
        {
             if($_POST)
             { 

                $email=$this->input->post('email');

                $query = $this->admin_model->validate_admin_date(array('email' => $email));
                
                //-- if valid
                if($query){
                    $data = array();
                    $row=$query[0];

                    $info['new_password']=get_random_password();

                    $updateData = array(
                        'password' => md5($info['new_password'])
                    );

                    $data_arr = array(
                        'name' => $row->username,
                        'email' => $row->email,
                        'password' => $info['new_password']
                    );

                    $subject = $this->app_name.' - '.$this->lang->line('forgot_password_lbl');

                    $body = $this->load->view('admin/emails/forgot_password.php',$data_arr,TRUE);

                    if(send_email($row->email, $row->username, $subject, $body))
                    {
                        $this->common_model->update($updateData, $row->id,'tbl_admin');

                        $message = array('success' => '1','message' => $this->lang->line('password_sent'),'class' => 'alert-success');
                        $this->session->set_flashdata('response_msg', $message);

                        redirect(base_url() . 'admin');
                    }
                    else{
                        $message = array('success' => '0','message' => $this->lang->line('email_not_sent'),'class' => 'alert-danger');

                        redirect(base_url() . 'admin/forgot-password');
                    }
                    
                }else{

                    $message = array('message' => $this->lang->line('email_not_found'),'class' => 'alert-danger');
                    $this->session->set_flashdata('response_msg', $message);
                    redirect(base_url() . 'admin/forgot-password');
                }
                
            }
            else{
                redirect(base_url() . 'admin/forgot-password');
            }
        }
        else  
        {  
            $message = array('message' => $this->lang->line('email_require_lbl'),'class' => 'alert-danger');
            $this->session->set_flashdata('response_msg', $message);
            redirect(base_url() . 'admin/forgot-password');
        }
    }

    public function logout(){

        $array_items = array('id', 'username', 'email', 'is_login');

        $this->session->unset_userdata($array_items);

        redirect(base_url() . 'admin', 'refresh');
    }

}