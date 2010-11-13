<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Hookchat - Main</title>
    
    <script type="text/javascript" charset="utf-8" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>js/hookbox.lib.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo base_url() ?>js/hookbox.js" type="text/javascript" charset="utf-8"></script>
    
    <style type="text/css" media="screen">
      body 
      {
        background: #D0E9FF;
        font-family: "Arial";
      }
      
      a:link, a:active, a:visited 
      {
        color: #000;
        text-decoration: underline;
      }
      
      a:hover 
      {
        text-decoration: none;
      }
      
      .box
      {
        position: absolute;
        width: 500px;
        height: 400px;
        top: 50%;
        left: 50%;
        margin-left: -255px; /* +5 because of padding */
        margin-top: -205px; /* idem */
        
        border: 5px solid #1654C5;
        background: #628ED4;
        
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        
        -webkit-box-shadow: 0 0 10px #666;
        -moz-box-shadow: 0 0 10px #666;
        box-shadow: 0 0 10px #666;
        
        padding: 10px;
      }
      
      .box p
      {
        padding: 0;
        margin: 0 0 10px 0;
        font-size:20px;
        font-weight: bold;
      }
      
      .box input[type=text]
      {
        font-size:14px;
        font-family: "Arial";
        width: 494px;
        margin-top: 5px;
        
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        
        background: #BBDFFF;
        
        border: 0px;
        
        padding:2px;
      }
      
      .box small.errors
      {
        color: #AF1F00;
        font-weight: bold;
      }
      
      .box div#hookchat
      {
        background: #BBDFFF;
        
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        
        width:100%;
        height:340px;
        
        overflow-y: auto;
      }
      
      .box div#hookchat p
      {
        font-size:14px;
        font-weight: normal;
        margin:5px;
      }
      
      .box div#hookchat p span.nickname
      {
        font-weight: bold;
      }
      
      .box .logout-link
      {
        float: right;
        font-size:12px;
        padding-top:5px;
      }
    </style>
    
    <script type="text/javascript" charset="utf-8">
      $(function(){
        $('#logout_link').click(function(){
          // Cancel subscription and logout
          hb_subscription.cancel();
          location.href = '<?php echo site_url('chat/logout') ?>';
        });
        
        // ---------------------------------------------------------------
        
        $('#message').keyup(function(e) {
          if(e.keyCode == 13) {
            console.log('Sending message ...');
            hb_conn.publish('hookchat', $('#message').val()); // Send the message
            $('#message').val(''); // Empty the text field
          }
        });
      });
    </script>
  </head>
  <body>
    <div class="box">
      <p> 
        Hookchat (<span id="users_connected">0</span> users connected)
        <a id="logout_link" href="javascript:;" class="logout-link">Logout</a>
      </p>
      <div id="hookchat"> 
        
      </div>
      <input type="text" name="message" id="message" placeholder="Enter a message ...">
    </div>
  </body>
</html>