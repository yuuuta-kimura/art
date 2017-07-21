<div id="box" style="margin-top:100px">
<h4>{$params.message nofilter}</h4>

<form action="" method="post" name="frm_regist_user"  onSubmit="return check()">



     {if $returnbtn =='yes' }
     <div id="box">
    <input type="submit" id="return_btn" name="return_btn" value="戻る" />
	</div>
	{/if}
    
</form>

</div>