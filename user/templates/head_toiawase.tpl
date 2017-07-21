<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>

{literal}

<script>

function set_clickbtn(s_val)
{
	document.frm_toiawase.onbtn.value = s_val;
}
	
	
function check(){

	var flag = 0;

	if(document.frm_toiawase.onbtn.value=="regist"){

		
		if(document.frm_toiawase.text_kenmei.value == ""){
			document.getElementById("error_text_kenmei").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kenmei").innerHTML = "";
		}

		if(document.frm_toiawase.slt_customer.value == ""){
			document.getElementById("error_slt_customer").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_slt_customer").innerHTML = "";

			if(document.frm_toiawase.slt_customer.value == "法人"){
				if(document.frm_toiawase.text_hojin.value == ""){
					document.getElementById("error_text_hojin").innerHTML = "※入力されていません";
					flag = 1;
				}else{
					document.getElementById("error_text_hojin").innerHTML = "";
				}				
			}
		}
	
		
		if(document.frm_toiawase.text_sei.value == ""){
			document.getElementById("error_text_sei").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_sei").innerHTML = "";
		}
		
		if(document.frm_toiawase.text_mei.value == ""){
			document.getElementById("error_text_mei").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_mei").innerHTML = "";
		}

		if(document.frm_toiawase.text_naiyo.value == ""){
			document.getElementById("error_text_naiyo").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_naiyo").innerHTML = "";
		}
		
		
		var Mail=document.frm_toiawase.text_mailaddress.value ;
		if(Mail == "")
		{
			document.getElementById("error_text_mail").innerHTML = "※入力されていません";
			flag = 1;
		}
		else
		{	
			var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
			if(!Mail.match(Seiki))
			{
				document.getElementById("error_text_mail").innerHTML = "※メールアドレスとして正しい形ではありません";
				flag = 1;
			}
			else
			{
				document.getElementById("error_text_mail").innerHTML = "";
			}
		}
			
		if(flag){		
			document.getElementById("error_all").innerHTML = "※入力されていない項目があります";
			return false; // 送信を中止
		}
		else{	
			document.getElementById("error_all").innerHTML = "";
			return true; // 送信を実行
		}
	}else{
		return true; // 送信を実行
	}

}


function mail_check()
{
	var Mail=document.frm_regist_user.text_mailaddress.value ;
	if(Mail != "")
	{
		var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
		if(!Mail.match(Seiki))
		{
			document.getElementById("error_text_mail").innerHTML = "※不正な文字列、またはメールアドレスとして正しい形ではありません";			
		}else
		{
			
			var a = new Ajax.Request( 
					"./ajax/mailcheck_user.php", 
			{ 
				"method": "post", 
				"parameters": "text_mailaddress="+Mail, 
				onComplete: function(request) 
				{ 
					var json; 
					json = JSON.parse(request.responseText);
					
					if(json!="none")	
					{
						document.getElementById("error_text_mail").innerHTML = "※すでに登録しているメールアドレスです";		
					}
					else
					{
						document.getElementById("error_text_mail").innerHTML = "";
					}	
				}
			}); 	
		}
	}
}


</script>

{/literal}
