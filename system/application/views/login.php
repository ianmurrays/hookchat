<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Hookchat - Login</title>
    <style type="text/css" media="screen">
      body 
      {
        background: #D0E9FF;
        font-family: "Arial";
      }
      
      .box
      {
        position: absolute;
        width: 360px;
        height: 80px;
        top: 50%;
        left: 50%;
        margin-left: -185px; /* +5 because of padding */
        margin-top: -45px; /* idem */
        
        border: 5px solid #1654C5;
        background: #628ED4;
        
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        
        -webkit-box-shadow: 0 0 10px #666;
        
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
        width: 190px;
      }
      
      .box small.errors
      {
        color: #AF1F00;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <div class="box">
      <p> Enter your nickname to join the chat! </p>
      <?php echo form_open('chat/login'); ?>
        <?php echo form_label('Nickname:', 'nickname'); ?>
        <?php echo form_input(array('name' => 'nickname', 'id' => 'nickname')); ?>
        <?php echo form_submit(array('value' => 'Join Chat!')); ?>
      <?php echo form_close(); ?>
      <?php echo validation_errors('<small class="errors">', '</small>') ?>
    </div>
  </body>
</html>