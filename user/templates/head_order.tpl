<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT">


<script src="http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>

{literal}

<script>

function set_value(s_val)
{
	document.frm_order.onbtn.value = s_val;
}

function check(){

	var flag = 0;


	//if(document.frm_regist_user.onbtn.value=="regist"){<-戻るをつけた時にヒドゥン設定

	// 設定開始（必須にする項目を設定してください）
	
	if(document.frm_order.onbtn.value == 'next'){    
	
		//カードNO
		var CardNo = document.frm_order.text_cardno.value;
		if(CardNo == ""){
			document.getElementById("error_text_cardno").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			var Seiki=/[^0-9]/g;
			if(CardNo.match(Seiki)){
				document.getElementById("error_text_cardno").innerHTML = "※半角数字以外の文字が含まれています";
				flag = 1;
			}else{
				document.getElementById("error_text_cardno").innerHTML = "";
			}
		}
	
		//セキュリティコード
		var SCode = document.frm_order.text_code.value;
		if(SCode == ""){
			document.getElementById("error_text_code").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			var Seiki=/[^0-9]/g;
			if(SCode.match(Seiki)){
				document.getElementById("error_text_code").innerHTML = "※半角数字以外の文字が含まれています";
				flag = 1;
			}else{
				document.getElementById("error_text_code").innerHTML = "";
			}
		}
	
	
		//有効期限
		if(document.frm_order.slt_month.value == ""){
			document.getElementById("error_slt_mmyy").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			if(document.frm_order.slt_year.value == ""){
				document.getElementById("error_slt_mmyy").innerHTML = "※入力されていません";
				flag = 1;
			}else{
				document.getElementById("error_slt_mmyy").innerHTML = "";
			}
		}
	
	
		//郵便番号
		var vPost_left = document.frm_order.text_post_left.value;
		if(vPost_left == ""){
			document.getElementById("error_text_post").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			var Seiki=/[^0-9]/g;
			if(vPost_left.match(Seiki)){
				document.getElementById("error_text_post").innerHTML = "※半角数字以外の文字が含まれています";
				flag = 1;
			}else{
				var vPost_right = document.frm_order.text_post_right.value;
				if(vPost_right == ""){
					document.getElementById("error_text_post").innerHTML = "※入力されていません";
					flag = 1;
				}else{
					var Seiki=/[^0-9]/g;
					if(vPost_right.match(Seiki)){
						document.getElementById("error_text_post").innerHTML = "※半角数字以外の文字が含まれています";
						flag = 1;
					}else{
						document.getElementById("error_text_post").innerHTML = "";
					}
				}
			}
		}
		
	
		//都道府県
		if(document.frm_order.slt_prefecture.value == ""){
			document.getElementById("error_slt_prefecture").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_slt_prefecture").innerHTML = "";
		}
	
		//市区町村
		if(document.frm_order.text_city.value == ""){
			document.getElementById("error_text_city").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_city").innerHTML = "";
		}
	
		//番地、マンション名など
		if(document.frm_order.text_banchi.value == ""){
			document.getElementById("error_text_banchi").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_banchi").innerHTML = "";
		}
	
		//宛名
		if(document.frm_order.text_atena.value == ""){
			document.getElementById("error_text_atena").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_atena").innerHTML = "";
		}
	
		//電話番号
	
		var Tel_left = document.frm_order.text_tel_left.value;
		if(Tel_left == ""){
			document.getElementById("error_text_tel").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			var Seiki=/[^0-9]/g;
			if(Tel_left.match(Seiki)){
				document.getElementById("error_text_tel").innerHTML = "※半角数字以外の文字が含まれています";
				flag = 1;
			}else{
		
				var Tel_center = document.frm_order.text_tel_center.value;
				if(Tel_center == ""){
					document.getElementById("error_text_tel").innerHTML = "※入力されていません";
					flag = 1;
				}else{
					var Seiki=/[^0-9]/g;
					if(Tel_center.match(Seiki)){
						document.getElementById("error_text_tel").innerHTML = "※半角数字以外の文字が含まれています";
						flag = 1;
					}else{
						var Tel_right = document.frm_order.text_tel_right.value;	
						if(Tel_right == ""){
							document.getElementById("error_text_tel").innerHTML = "※入力されていません";
							flag = 1;
						}else{
							var Seiki=/[^0-9]/g;
							if(Tel_right.match(Seiki)){
								document.getElementById("error_text_tel").innerHTML = "※半角数字以外の文字が含まれています";
								flag = 1;
							}else{
								document.getElementById("error_text_tel").innerHTML = "";
							}
						}
					}
				}
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

	}


}


</script>

{/literal}
