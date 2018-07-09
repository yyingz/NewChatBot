<?php
  // parameters
  $hubVerifyToken = 'nostra_bot';
  $accessToken = "EAAYju4X7cmsBAOZAQVoQi8BPnjtIITeY6NcBYYwVpVZChonNFsJiwxsv1hLhci5MdxFZCbj7hSUJGgOtpNW1xGz1LKLezY24XYoSLOmJ7degYPIwTllMOuHRtinuGInNmdI9ZBLg0mRdFqVEI31qmPoOHxq2ZBcREdEZCDgZCqHBv1rm3yLPvQt";
  
  // check token at setup
  if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
    echo $_REQUEST['hub_challenge'];
    exit;
  }
  // handle bot's anwser
  $input = json_decode(file_get_contents('php://input'), true);
  $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
  $messageText = $input['entry'][0]['messaging'][0]['message']['text'];
  $payload = $input['entry'][0]['messaging'][0]['postback']['payload'];
  
  if (!empty($payload)) {
    $messageText = $payload;
  }
  $response = null;

  //set Message
  if($messageText == "hi") {
      $answer = "Hello";
      //send message to facebook bot
    $response = [
      'recipient' => [ 'id' => $senderId ],
      'message' => [ 'text' => $answer ]
    ];
  }

  if($messageText == "ข้อมูลติดต่อ (Contact Information)") {
      $answer = "NOSTRA Hotline Service
(66)2 266 9940
 nostrahotline@cdg.co.th";
      //send message to facebook bot
      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
      ];
  }

  if($messageText == "แสดงความคิดเห็นเกี่ยวกับแอปพลิเคชัน (Application Feedback)") {
      $answer = "ขอบคุณมากครับ รบกวนแสดงความคิดเห็นของท่านได้เลยครับ :)";
      //send message to facebook bot
      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
      ];
  }

  if($messageText == "ค้นหาสถานที่") {
      $answer = "https://map.nostramap.com/";
      //send message to facebook bot
      $response = [
        'recipient' => [ 'id' => $senderId ],
        'message' => [ 'text' => $answer ]
      ];
  }
 
  $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  if(!empty($input)){
  $result = curl_exec($ch);
  }
  curl_close($ch);
?>