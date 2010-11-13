var HB_GATEWAY = 'http://localhost:8001';
var HB_CHANNEL = 'hookchat';

var hb_conn;
var hb_subscription;

$(function(){
  // Connect to hookbox server
  hb_conn = hookbox.connect(HB_GATEWAY);
  
  hb_conn.onOpen = function() {
    console.log('Connection to hookbox established!');
  };
  
  hb_conn.onError = function(err) {
    console.log('Connection to hookbox was not established. An error ocurred: ' + err.msg);
  };
  
  hb_conn.onSubscribed = function(channelName, subscription){
    if (channelName == HB_CHANNEL)
    {
      hb_subscription = subscription;
      
      // Update ammount of users connected
      update_connected_users();
      
      // Handle user subscriptions and unsubscriptions
      // This let's us know when people enter the chat
      hb_subscription.onSubscribed = function(frame) {
        console.log('User ' + frame.user + ' has subscribed.');
        update_connected_users();
      }

      hb_subscription.onUnsubscribe = function(frame) {
        console.log('User ' + frame.user + ' has unsubscribed.');
        update_connected_users();
      }
      
      // Handle publish events, ie. when messages arrive.
      hb_subscription.onPublish = function(frame){
        console.log(frame);
        // Update users connected too
        update_connected_users();
        
        $('#hookchat').append('<p><span class="nickname">' + frame.user + '</span>: ' + frame.payload + '</p>');
        
        
        // -----------------------------------------------------------------------------------
        
        //console.log(frame);
        // Is this a jGrowl Alert?
        /*if (frame.payload.type == 'jgrowl')
        {
          // This allows for {site_url()} strings within hookbox messages
          var msg = frame.payload.data.message.replace(/\{method_url\}/g, METHOD_URL);
          
          // Show jGrowl message
          $.jGrowl(msg, {'sticky' : true});
        }
        else if (frame.payload.type == 'new_alarm')
        {
          // Nothing for now
          console.log('---> Received new alarm alert.');
          console.log(frame.payload);
          for (var i in new_alarm_callbacks)
          {
            console.log('---> Calling function #' + i + ' in function callbacks ...');
            new_alarm_callbacks[i](frame.payload.data.alarm_id);
          }
        }*/
      };
    }
  };
  
  hb_conn.subscribe(HB_CHANNEL); // Make the subscription itself.
});

/**
 * Updates the "X users connected" string above the chat
 */
function update_connected_users() 
{
  $('#users_connected').html(
    hb_subscription.presence.length
  );
}