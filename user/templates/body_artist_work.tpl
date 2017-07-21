<form action="" method="post" name="frm_artist_work">
<input type="hidden" name="works_id" id="works_id" value="{$params.works_id}"/>
<input type="hidden" name="artist_id" id="artist_id" value="{$artist_id}"/>
<input type="hidden" name="page" id="page" value="{$params.page}"/>

<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0;">
	<font size="+1">
	{$params.html nofilter}
	</font>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
     <div  class="input_error">{$params.message}</div>
</div>
{if $params.price > 0}
	{if $login_flg=='yes'}
		{if $ZAIKO > 0}
			{if $MYCART == 0}

				{if $MYORDER > 0}
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">
					<div  class="input_error">既に購入済みの作品です</div>
				</div>
				{/if}

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">
					<input type="submit" id="cart_btn" name="cart_btn" class="bigbutton" value="カートに入れる" />
				</div>
			{else}
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">
					<div  class="input_error">既にカートに入っています</div>
				</div>
			{/if}
		{/if}
	{else}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">
			<input type="submit" id="cart_btn" name="cart_btn" class="bigbutton" value="購入するためにログインする" />
		</div>
	{/if}
{/if}

<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">

<div style="width:300px; margin: 0 auto;">

<div style="float: left;">
<div class="fb-share-button" data-href="http://e-art.tokyo/user/artist_work.php?works_id={$params.works_id}" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fe-art.tokyo%2Fuser%2Fartist_work.php%3Fworks_id%3D{$params.works_id}&amp;src=sdkpreparse">シェア</a>
</div>
</div>

<div style="float: left; margin-left:20px;">
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://e-art.tokyo/user/artist_work.php?works_id={$params.works_id}" data-size="large">ツイート</a>
</div>


<div style="float: left; margin-left:20px;">
<a href="http://b.hatena.ne.jp/entry/e-art.tokyo/user/artist_work.php?works_id={$params.works_id}" class="hatena-bookmark-button" data-hatena-bookmark-layout="touch" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" style="border: none;" /></a>
</div>


<div style="float: left; margin-left:20px;">
<div class="line-it-button" data-lang="ja" data-type="share-e" data-url="http://e-art.tokyo/user/artist_work.php?works_id={$params.works_id}" style="display: none;">
</div>
</div>

</div>
                        
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:30px 0 0 0;">
    <input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="戻る" />
</div>

</form>

