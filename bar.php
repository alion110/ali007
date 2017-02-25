<?php
     
     define('TOKEN', '');
     $update = json_decode(file_get_contents('php://input'));
	 if (isset($update)){
	 $chat_id = $update->message->chat->id;
	 $user_id = $update->message->from->id;
	 $first = $update->message->from->first_name;
     $username = $update->message->from->username;
	 $msg_id = $update->message->message_id;
     $text = $update->message->text;
     $query_id = $update->inline_query->id;
     $query_text = $update->inline_query->query;
	 //commands
	 if($text == '/start'){
		 sendaction($chat_id, 'typing');
		 sendmessage($chat_id, "سلام دوست عزیز به ربات  نامه ساز خوش اومدی \n\n برای ساخت نامه متنی که میخوای نامه بشه رو بفرست 📩📩📩, $msg_id);
		 bot('sendmessage',[
		 'chat_id'=>$chat_id,
		 'text'=>'یکی از گزینه های زیر رو انتخاب کنید',
		 'reply_to_message_id'=>$reply,
		 'reply_markup'=>json_decode(['inline_keyboard'=>[
		 [['text'=>'کانال ما!','url'=>'https://telegram.me/phptm']],
		 [['text'=>'راهنما','text'=>'این ربات فقط جهت سرگرمی ساخته شده \n\nشما با این ربات میتوانید کمی پیام های خود را زیبا کنید']],
		 [['text'=>'سازنده','text'=>'creator: @kingphp']]
		 ]
		 ])
		 ]);
	 }
	 elseif($text == '/creator'){
		 sendmessage($chat_id, "creator: @kingphp \n channel: @phptm", $msg_id)
	 }
	 
		 
	 else{
		 bot('sendmessage',[
		 'chat_id'=>$chat_id,
		 'text'=>'شما یک نامه دارید 📩',
		 'reply_to_message_id'=>$reply,
		 'reply_markup'=>json_encode(['inline_keyboard'=>[
		 [['text'=>'خواندن نامه 📩','text'=>$text]],
		 [['text'=>'اشتراک گذاشتن','swich_inline_query'=>$text]],
		 ]
		 ])
		 ]);
	 }
	 
	 // writted by kingphp
	 
	function bot($method,$datas=[]){
	   $url = 'https://api.telegram.org/bot'.TOKEN.'/'.$method;
	   $ch = curl_init();
	   curl_setopt($ch,CURLOPT_URL,$url);
	   curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	   curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
	   $res = curl_exec($ch);
	   if (curl_error($ch)){
	     var_dump(curl_error($ch));
	   }
	   else{
		  return json_decode($res);
	   }}
	 function sendMessage($chat_id, $text, $reply_to_message_id){
	   bot('sendMessage',[
	   'chat_id'=>$chat_id,
	   'text'=>$text,
	   'parse_mode'=>'html',
	   'reply_to_message_id'=>$reply_to_message_id]);
	 }
	 function sendAction($chat_id, $action){
	   bot('sendChataction',[
	   'chat_id'=>$chat_id,
	   'action'=>$action]);
	 }
?>