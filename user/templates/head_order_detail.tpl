<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js" charset="UTF-8"></script>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>

{literal}

<script>

function set_clickbtn(s_val)
{
	document.frm_order_detail.onbtn.value = s_val;
}
	
	
function check(){

	if(document.frm_order_detail.onbtn.value=="cancel"){
	
		if(window.confirm('実行しても宜しいでしょうか？'))
		{
				return true; // 送信を実行				
		}else{
			window.alert('キャンセルされました');		
			return false;
		}
	}
}

</script>

{/literal}
