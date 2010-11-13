<?php
class Hookbox extends Controller
{
  public function __construct()
  {
    parent::__construct();
    
    // All output of this controller is going to be JSON, so
    // set appropriate headers
    $this->output->set_header('Content-type: application/json');
  }
  
  /**
   * Hookbox 'connect' callback. Is called by the hookbox
   * server whenever a browser wants to establish a connection
   * to hookbox.
   *
   * @return json
   * @author Ian Murray
   */
  public function connect()
  {
    // If the user is logged in ... then return the nickname
    // in the cookie
    $user = $this->session->userdata('user');
    if ($user !== FALSE)
    {
      // He's logged in, he can connect to the Hookbox push server
      echo json_encode(array(
        TRUE, array(
          'name' => $user['nickname']
        )
      ));
    }
    else
    {
      // He's not logged in, don't allow him to connect to the
      // hookbox server
      echo '[false, {}]'; // Can't use json_encode here, since the 
                          // "{}" part can't be done with that function
                          // (I think). Hookbox required an object there
                          // and not an array (json_encode would output
                          // [false, []] ).
    }
  }
  
  /**
   * Hookbox callback to create channels
   *
   * @return json
   * @author Ian Murray
   */
  public function create_channel()
  {
    // Only allow creation of the main channel. 
    // TODO: Multiple channel support
    
    if ($this->input->post('channel_name') == 'hookchat')
    {
      echo json_encode(array(
        TRUE,
        array(
          'history_size' => 20,   // 20 rows of history
          'reflective'   => TRUE, // This means that every message sent by
                                  // someone is pushed back to them.
          'presenceful'  => TRUE  // This allows the clients to know which users
                                  // are subscribed to a channel
        )
      ));
    }
    else
    {
      echo '[false, {}]';
    }
  }
  
  /**
   * Hookbox callback to subscribe to channels
   *
   * @return void
   * @author Ian Murray
   */
  public function subscribe()
  {
    // For now allow all subscriptions.
    // Later we can validate this so that we can have private
    // rooms.
    echo '[true, {}]';
  }
  
  /**
   * Hookbox callback to disconnect from the server
   *
   * @return void
   * @author Ian Murray
   */
  public function disconnect()
  {
    // Allow all disconnections
    echo '[true, {}]';
  }
  
  /**
   * Hookbox callback that's called when a user is disconnected.
   *
   * @return void
   * @author Ian Murray
   */
  public function unsubscribe()
  {
    // Allow all unsubscriptions
    echo '[true, {}]';
  }
  
  /**
   * Hookbox callback for destroying channels.
   *
   * @return void
   * @author Ian Murray
   */
  public function destroy_channel()
  {
    echo '[true, {}]';
  }
  
  /**
   * Publish callback. This validates whether a message is allowed
   * to be published by someone on a certain channel.
   *
   * @return void
   * @author Ian Murray
   */
  public function publish()
  {
    // Allow all messages from logged in people for now
    if ($this->session->userdata('user'))
    {
      echo '[true, {}]';
    }
  }
}
