<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{

		$this->load->view('login');
	}

	// Check for user login process
	public function login_process() {
		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			if(isset($this->session->userdata['logged_in'])){
				redirect('dashboard');
			}else{
				redirect('');
			}
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->Queries->login($data);

			if ($result == TRUE) {

				$username = $this->input->post('username');
				$result = $this->Queries->read_user_information($username);
				if ($result != false) {
					if($result[0]->user_blocked == 1) {
						$session_data = array(
							'username' => $result[0]->user_name,
							'userid' => $result[0]->id,
							'user_image' => $result[0]->user_image,
							'user_fullname' => $result[0]->user_fullname,
							'user_type' => $result[0]->user_type,
							'companyid' => $result[0]->companyid,
							'branchid' => $result[0]->branchid,
							'activebranchid' => $result[0]->branchid,
							'user_role' => $this->Queries->read_role_info($result[0]->user_type)->role_details,
							'user_department' => $this->Queries->read_role_info($result[0]->user_type)->department_id,
						);

						if($result[0]->user_type != 1){
                            $this->activateCompany($result[0]->companyid); //call function
                        }
						// Add user data in session
						$this->session->set_userdata('logged_in', $session_data);
						redirect('dashboard');
					}else{
						$this->session->set_flashdata('error_msg','Your Account Had been Blocked! Please Contact Administrator.');
						redirect('');
					}
				}
			} else {
				$this->session->set_flashdata('error_msg','Invalid Username & Password');
				redirect('');
			}
		}
	}

    public function activateCompany($id=0){
        $this->load->model("settings_model");
        if ($id !== 0) {
            $account = $this->settings_model->getAccountByID($id);
            if ($account) {
                $new_config['hostname'] = HOSTNAME;
                $new_config['username'] = DBUSERNAME;
                $new_config['password'] = DBPASSWORD;
                $new_config['database'] = DBNAME;
                $new_config['dbdriver'] = DBTYPE;
                $new_config['dbprefix'] = strtolower($account->db_prefix);
                $new_config['db_debug'] = TRUE;
                $new_config['cache_on'] = FALSE;
                $new_config['cachedir'] = "";
                $new_config['schema'] 	= $account->db_schema;
                $new_config['port'] 	= DBPORT;
                $new_config['char_set'] = "utf8";
                $new_config['dbcollat'] = "utf8_general_ci";
                if ($account->db_persistent) {
                    $new_config['pconnect'] = TRUE;
                } else {
                    $new_config['pconnect'] = FALSE;
                }
                $this->load->database($new_config);
                if (!$this->check_database($new_config)) {
                    $this->session->set_flashdata('warning', lang('user_cntrler_activator_db_con_warning'));
                    redirect('Account/admin/');
                }else{
                    $this->session->set_userdata('active_account', $account);
                    $this->session->set_userdata('active_account_config', $new_config);
                    $this->session->set_userdata('active_account_id', $account->id);
                    $this->session->userdata["logged_in"]["companyid"]=$account->id;
                    $this->session->set_flashdata('message', lang('user_cntrler_activator_activate_success'));
                    redirect('Account/dashboard');
                }
            }else{
                $this->session->set_flashdata('error', lang('user_cntrler_activate_account_not_found_error'));
                redirect('Account/admin/');
            }
        }
    }
    // Verify mysql db (DB1) connection
    public function check_database($config)
    {
        //  Check if using mysqli driver
        if( $config['dbdriver'] === 'mysqli' )
        {
            // initilize mysqli connection
            @$mysqli = new mysqli( $config['hostname'] , $config['username'] , $config['password'] , $config['database'] );
            // Check database connection
            if( !$mysqli->connect_error )
            {
                // if no connection errors are found close connection and return true
                @$mysqli->close();
                return true;
            }
        }
        // else return false
        return false;
    }

    // Verify mysql db (DB1) connection
    public function activeBranch()
    {
        $this->form_validation->set_rules('branchid', 'Branch Id', 'required');
        if($this->form_validation->run()) {
            $data = $this->input->post();
            $id = StringRepair($data['branchid']);
            $companyid = $this->session->userdata["logged_in"]["companyid"];
            if($id != 0) {
                $query = "select * from " . ACC_BRANCH . " where id=" . $id . " and companyid=" . $companyid;
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $this->session->set_flashdata('success', 'Branch Activated Successfully');
                    $this->session->userdata["logged_in"]["activebranchid"] = $res->id;
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('error', 'No Such Branch Exists');
                    redirect('Dashboard');
                }
            }else{
                $this->session->set_flashdata('success', 'All Branches Activated Successfully');
                $this->session->userdata["logged_in"]["activebranchid"] = 0;
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
