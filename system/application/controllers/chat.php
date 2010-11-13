<?php
class Chat extends Controller
{
  /**
   * The constructor.
   *
   * @author Ian Murray
   */
  public function __construct()
  {
    parent::__construct();
    
    // Clean old nicknames from db
    $this->__clean_db();
  }
  
  /**
   * Cleans any nicknames older than 15 mins
   *
   * @return void
   * @author Ian Murray
   */
  private function __clean_db()
  {
    $this->db->select('nickname, last_message')
             ->from('users');
    
    $query = $this->db->get();
    
    foreach($query->result_array() as $user)
    {
      if (time() - $user['last_message'] >= 900)
      {
        // Delete users not active for 15 minutes
        $this->db->where('nickname', $user['nickname'])
                 ->delete('users');
      }
    }
  }
  
  /**
   * This just redirects to our main method.
   *
   * @return void
   * @author Ian Murray
   */
  public function index()
  {
    redirect('chat/main');
  }
  
  /**
   * Logs users in.
   *
   * @return void
   * @author Ian Murray
   */
  public function login()
  {
    if ($this->session->userdata('user') === FALSE)
    {
      // We need to log him in.
      $this->load->library('form_validation');
      
      $this->form_validation->set_rules(array(
        array('field' => 'nickname', 'label' => 'nickname', 'rules' => 'required|max_length[64]|trim|strip_tags|callback_check_db'),
      ));
      
      if ($this->form_validation->run() === FALSE)
      {
        // Login failed
        $this->load->view('login');
      }
      else
      {
        // Save the nickname
        $this->db->insert('users', array(
          'nickname' => $this->input->post('nickname'),
          'last_message' => time()
        ));
        
        // "Log him in".
        $this->session->set_userdata('user', array(
          'nickname' => $this->input->post('nickname')
        ));
        
        // Redirect him to the chat itself.
        redirect('chat/main');
      }
    }
    else
    {
      redirect('chat/main');
    }
  }
  
  /**
   * Callback for the login method's form validation. Checks if nickname isn't taken.
   *
   * @param string $nickname 
   * @return boolean
   * @author Ian Murray
   */
  public function check_db($nickname)
  {
    $this->db->select('nickname')
                      ->from('users')
                      ->where('nickname', $nickname);
                      
    $query = $this->db->get();
    
    if ($query->num_rows() > 0)
    {
      // The nickname is taken. Too bad.
      $this->form_validation->set_message('check_db', 'The nickname is taken.');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }
  
  /**
   * The chat itself.
   *
   * @return void
   * @author Ian Murray
   */
  public function main()
  {
    if ($this->session->userdata('user') === FALSE)
    {
      redirect('chat/login');
      return; // Without this, the execution continues.
    }
    
    $this->load->view('main');
  }
  
  /**
   * Destroy user info.
   *
   * @return void
   * @author Ian Murray
   */
  public function logout()
  {
    $this->session->set_userdata('user', FALSE);
    $this->session->unset_userdata('user');
    
    redirect('chat/login');
  }
}