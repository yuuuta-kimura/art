<?php

//////////////////////////////////////
// user/mymail.php
//////////////////////////////////////


function MailBody_user($name,$supportmail,$naiyo) {
	$mail_body = sprintf("%s様", $name);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのご登録ありがとうございます。".PHP_EOL;
	$mail_body .= "引き続き『e-ART』をどうぞよろしくお願いいたします。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "ご申請していただくことにより、下記の一般向け利用規約、プライバシーポリシー、特定商取引に関する表示に同意いただいたものとみなしますので、必ず規約を確認をしてください。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	//$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= file_get_contents('kiyaku_user.txt').PHP_EOL.PHP_EOL;
	//$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

return $mail_body;
}




function MailBody_toiawase($supportmail,$naiyo) {
	
	$mail_body = "====================================================".PHP_EOL;
	$mail_body .= "このメッセージは、e-ART事務局より自動的に送信されています。".PHP_EOL;
	$mail_body .= "===================================================".PHP_EOL;
	$mail_body .= PHP_EOL;	
	$mail_body .= "お問い合わせありがとうございました。".PHP_EOL;
	$mail_body .= "内容を確認の上、e-ART事務局よりメールにてご回答いたします。".PHP_EOL;
	$mail_body .= "スパム及び営業行為については、返信は控えさせていただきます。予めご了承ください。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

	
return $mail_body;
}


function MailBody_order_to_user($name,$supportmail,$naiyo) {
	
	$mail_body = sprintf("%s様", $name);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのご注文ありがとうございます。".PHP_EOL;
	$mail_body .= "注文した作品は、各作家が直接、お客様に1週間以内にご配送いたします。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

	
return $mail_body;
}


function MailBody_order_to_artist($name,$supportmail,$naiyo) {
	
	$mail_body = sprintf("%s様", $name);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』から作品のご注文があります。".PHP_EOL;
	$mail_body .= "アーティスト専用ページにログインし、ご注文をご確認ください。".PHP_EOL;
	$mail_body .= "http://e-art.tokyo/artist/artist_login.php".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "作品は必ず厳重に梱包し、１週間以内にご発送ください。".PHP_EOL;
	$mail_body .= "配送が遅れる場合は、直接お客様にご連絡をしてください。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

	
return $mail_body;
}


function MailBody_cancel_to_user($name,$supportmail,$naiyo) {
	
	$mail_body = sprintf("%s様", $name);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "下記のご注文のキャンセルをされました。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

	
return $mail_body;
}


function MailBody_cancel_to_artist($name,$supportmail,$naiyo) {
	
	$mail_body = sprintf("%s様", $name);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』のご注文がキャンセルされました".PHP_EOL;
	$mail_body .= "アーティスト専用ページにログインし、キャンセル内容をご確認ください。".PHP_EOL;
	$mail_body .= "http://e-art.tokyo/artist/artist_login.php".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

	
return $mail_body;
}



function MySendMail($addr, $title, $body, $from) {

	mb_language("ja");
	mb_internal_encoding("UTF-8");

    //Fromに日本語は入れない

	return mb_send_mail($addr,$title,$body,$from);
}


function MySendMailandCC($addr, $title, $body, $from, $cc) {

	mb_language("ja");
	mb_internal_encoding("UTF-8");

	$from.="\n";
	$from.="Cc:".$cc;

    //Fromに日本語は入れない

	return mb_send_mail($addr,$title,$body,$from);
}

function MailBody_password_user($nickname,$pass,$supportmail) {

	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのログインパスワードを再作成しました。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "下記の新しいパスワードでログインしてください。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= $pass.PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= PHP_EOL;
	$mail_body .= "※ログイン後、すぐにパスワードを変更してください。".PHP_EOL;
	$mail_body .= PHP_EOL;
    $mail_body .= PHP_EOL;
	$mail_body .= "それでは引き続き、『e-ART』をお楽しみください。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL.PHP_EOL;		
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	
	return $mail_body;
}

function MailBody_changeemail_user($nickname,$supportmail) {

	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』にログインするメールアドレスを変更しました".PHP_EOL;
    $mail_body .= PHP_EOL;
	$mail_body .= "それでは引き続き、『e-ART』をお楽しみください。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL.PHP_EOL;		
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	
	return $mail_body;
}


?>
