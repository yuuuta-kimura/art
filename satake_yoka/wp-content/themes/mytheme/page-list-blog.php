<?php
/*
Template Name: Blogリスト
*/
?>


<?php get_header(); ?>

<div id="pankuzu">e-ART><?php if ( function_exists( 'bcn_display' ) ) { bcn_display(); }//パンくずリストを表示 ?></div>

<div class="container profile-contents">

	<div class="row">	

	<?php if ( have_posts() ) : // ループ開始　投稿があるなら ?>
		
	<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:60px;">            
		<h1><?php the_title(); ?></h1>
	</div>

  
		<?php
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			
			$args = array(
            'post_type' => 'myblog', //カスタム投稿名
			'posts_per_page' => 10,
			'paged' => $paged,
			);
        
        		$loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
        ?>
        
        
        <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
                <div style="float:left; width:100px;"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('mobile_thumbnail'); ?></a></div>
                
                <div class  ="visible-xs">
                <div style="float:left; width:70%;"><a href="<?php the_permalink(); ?>" style="color:#000000;"><?php the_title(); ?></a></div>
                </div>

                <div class  ="visible-sm visible-md visible-lg">
                <div style="float:left; width:80%;"><a href="<?php the_permalink(); ?>" style="color:#000000;"><?php the_title(); ?></a></div>
                </div>

        </div>        
        
        <?php endwhile; ?>            
        
        <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 center-block text-center" style="margin-top:10px;">
            <?php
            $big = 999999999; // need an unlikely integer
             
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $loop->max_num_pages
            ) );
            ?>    
        </div>

	<?php endif; //ループ終了 ?>    
            
	</div>
	
</div>

<?php get_footer();