
{if $ptn=="a"}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:50px;">
<font size="+2">
<p><i class="fa fa-archive" aria-hidden="true"></i> 受注から発送までの流れ</p>
</font>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
<font size="+1">
<p>１.作品の注文が発生すると、登録したメールアドレスにお知らせが届きます</p>
<BR>
<BR>
<p>２.注文から{$limit_min}分の間は、発注者のキャンセル権利時間となり、受注は確定できません</p>
<BR>
<BR>
<p>３.注文から{$limit_min}分経過後、「メニュー」->「注文」->「注文の確定・発送」の画面にて、注文された作品を「受注」状態にしてください
	<font size="-1"><BR>　※「受注」状態にしない場合は、発注者からの注文のキャンセルができる状態となります</font>
</p>
<BR>
<BR>
<p>４.作品の配送が完了したら、「メニュー」->「注文」->「注文の確定・発送」の画面（同上）にて、注文された作品を「発送」状態にしてください
	<font size="-1"><BR>　※「発送」状態にしない場合は、発注者に発送したことをお知らせできません</font>
</p>
</font>
</div>

<font size="+2">
</font>
<font size="+1">
</font>


<font size="+2">
</font>
<font size="+1">
</font>


{/if}

{if $ptn=="b" || $ptn=="c" || $ptn=="d"}


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt30">
	<textarea name="text_kiyaku" id="text_kiyaku" style="clear:both;float:left; width:90%; height:600px;">{$naiyo}
	</textarea>
</div>	
	
{/if}

