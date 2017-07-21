<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<h1><font size="+3"><b>作品リスト</b></font></h1>
</div>

<form action="" method="post" name="">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
	<div id="error_newregist_btn" class="input_error" style="float:left; margin-left:20px;"></div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
	<div style="margin:0 auto; width: 200px;">
	<input type="submit" class="bigbutton" name="newregist_btn" id="newregist_btn" value="新規登録" style="float:left; width: 200px;"/>
	</div>
</div>
</form>

<div class="setworks_list col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<font size="-1">
	{$params.html nofilter}
	</font>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="paging" style="margin:0 auto; width: 200px; text-align: center;">
	<font size="+3" color="#444444">
	{$params.paging nofilter}
	</font>
	</div>
</div>

