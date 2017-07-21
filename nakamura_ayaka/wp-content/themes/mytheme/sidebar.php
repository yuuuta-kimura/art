<?php //リフォーム事例とその子ページでは、リフォーム事例用ウィジェットを表示
if ( is_page( array( 'works' , 'kitchen' , 'living' , 'bathroom' , 'free' ) ) ) : ?>

	<div id="sidebar-nav">
		<img src="<?php bloginfo('template_url'); ?>/img/side-works.jpg" id="sidebar-nav-photo" width="240" height="290" alt="サンプル工務店のリフォーム事例" />
		<ul id="sidebar-nav-list">
			<li><a href="<?php bloginfo('url'); ?>/works/">サンプル工務店のリフォームについて</a></li>
			<li><a href="<?php bloginfo('url'); ?>/works/kitchen/">キッチンリフォーム</a></li>
			<li><a href="<?php bloginfo('url'); ?>/works/living/">リビングリフォーム</a></li>
			<li><a href="<?php bloginfo('url'); ?>/works/bathroom/">洗面所リフォーム</a></li>
			<li><a href="<?php bloginfo('url'); ?>/works/free/">バリアフリーリフォーム</a></li>
		</ul>
	</div>
	  
<?php endif; ?>


<?php if ( is_page( 'service' ) ) : //事業紹介ページ ?>

	<div id="sidebar-nav">
		<img src="<?php bloginfo('template_url'); ?>/img/side-service.jpg" id="sidebar-nav-photo" width="240" height="290" alt="サンプル工務店の事業紹介" />
		<ul id="sidebar-nav-list">
			<li><a href="#s1">新築事業</a></li>
			<li><a href="#s2">リフォーム事業</a></li>
			<li><a href="#s3">ガーデンリフォーム</a></li>
			<li><a href="#s4">バリアフリー化</a></li>
		</ul>
	</div>
		  
<?php endif; ?>


<?php if ( is_page( 'access' ) ) : //所在地・MAP ?>

	<div id="sidebar-nav">
		<img src="<?php bloginfo('template_url'); ?>/img/side-access.jpg" id="sidebar-nav-photo-only" width="240" height="290" alt="サンプル工務店のアクセスマップ" />
	</div>
		  
<?php endif; ?>


<?php if ( is_page( 'company' ) ) : //会社概要 ?>

	<div id="sidebar-nav">
		<img src="<?php bloginfo('template_url'); ?>/img/side-company.jpg" id="sidebar-nav-photo-only" width="240" height="290" alt="サンプル工務店の会社概要" />
	</div>
		  
<?php endif; ?>


<?php if ( is_page( 'contact' ) ) : //お問い合わせ ?>

	<div id="sidebar-nav">
		<img src="<?php bloginfo('template_url'); ?>/img/side-contact.jpg" id="sidebar-nav-photo-only" width="240" height="290" alt="サンプル工務店のリフォーム事例" />
	</div>
		  
<?php endif; ?>

          
<?php if ( ! is_page() ) : //固定ページ以外ではスタッフ紹介バナーを表示 ?>

	<img src="<?php bloginfo('template_url'); ?>/img/blog-01.png" width="250" height="400" alt="サンプル工務店のスタッフブログ" />
	            
<?php endif; ?>


<div id="sidebar-container"><!--　ここからグレーの枠付きウィジェットエリア　-->		

	<?php if ( ! is_page() ) : //固定ページ以外ではスタッフ紹介ウィジェットを表示 ?>
				
		<div id="widget-author" class="widget">
		
			<h3 class="widget-title">スタッフ紹介</h3>
			<ul id="widget-author-list">
				<li class="clearfix"><img src="<?php bloginfo('template_url'); ?>/img/author1.jpg" width="80" height="80" alt="著者1" /><p class="widget-author-text"><span class="widget-author-title">社長：山田一郎</span><span class="widget-author-read"><a href="<?php bloginfo( 'url' ); ?>/author/author1/">記事を読む</a></span></p></li>
				<li class="clearfix"><img src="<?php bloginfo('template_url'); ?>/img/author2.jpg" width="80" height="80" alt="著者2" /><p class="widget-author-text"><span class="widget-author-title">営業：山田花子</span><span class="widget-author-read"><a href="<?php bloginfo( 'url' ); ?>/author/author2/">記事を読む</a></span></p></li>
				<li class="clearfix"><img src="<?php bloginfo('template_url'); ?>/img/author3.jpg" width="80" height="80" alt="著者3" /><p class="widget-author-text"><span class="widget-author-title">現場監督：山田太郎</span><span class="widget-author-read"><a href="<?php bloginfo( 'url' ); ?>/author/author3/">記事を読む</a></span></p></li>
				<li class="clearfix noborder"><img src="<?php bloginfo('template_url'); ?>/img/author4.jpg" width="80" height="80" alt="著者4" /><p class="widget-author-text"><span class="widget-author-title">事務：山田涼子</span><span class="widget-author-read"><a href="<?php bloginfo( 'url' ); ?>/author/author4/">記事を読む</a></span></p></li>            
			</ul>
			
		</div>
		
	<?php endif; ?>
	

	<?php dynamic_sidebar( 'サイドバー上部' ); //「サイドバー上部」を表示 ?>
		
</div><!--　グレーの枠付きウィジェットエリア　ここまで　-->


<?php dynamic_sidebar( 'サイドバー下部' ); //「サイドバー下部」を表示 ?>