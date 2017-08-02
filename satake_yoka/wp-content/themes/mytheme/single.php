<?php get_header(); ?>

<div id="pankuzu"><?php if ( function_exists( 'bcn_display' ) ) { bcn_display(); }//パンくずリストを表示 ?></div>



<div class="container blog-contents">

	<div class="row">
    
        <?php if ( have_posts() ) : // ループ開始　投稿があるなら ?>
        
            <?php while ( have_posts() ) : the_post();//繰り返し処理開始 ?>
            
	            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        

			    <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h1><?php the_title(); ?></h1>
				</div>                            

	
	    		    <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 org-contents" style="margin-top:20px;">
					<?php the_content(); ?>
				</div>                                                
    
    	    		    <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 org-contents">
					(<?php the_time('Y.m.j') ?>)
                 </div>
                
            <?php endwhile; // 繰り返し終了 ?>
            
            <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 org-contents" style="margin-top:70px;">
            
                <p><?php next_post_link('%link' , '次の記事 <span class="glyphicon glyphicon-forward"></span> %title' ); //次のページへのリンクを表示 ?></p>
                
                <p><?php previous_post_link('%link' , '前の記事 <span class="glyphicon glyphicon-backward"></span> %title'); //前のページへのリンクを表示 ?></p>
                
            </div>
            
        <?php else : //投稿が無い場合は ?>
        
            <h1>投稿が見つかりません</h1>
            
            <p><a href="<?php bloginfo( 'url' ); ?>">トップページに戻る</a></p>
            
        <?php endif; //ループ終了 ?>
        
    </div>		
        
</div>
	

<?php get_footer();