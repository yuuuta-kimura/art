<footer class="footer mt30">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

      <div class="container">
        <div class="row">

          <h2>
			<!--<span class="glyphicon glyphicon-th-large"></span>-->
            SITE MAP
          </h2>
          
        </div>
        <div class="row site-map">
          <ul>
            <li class="col-xs-12 col-sm-6 col-md-3">
              <div class="dotted-under-line">
                <a href="<?php bloginfo( 'url' );?>/">Top</a><span class="glyphicon glyphicon-menu-right"></span>
              </div>
            </li>
            <li class="col-xs-12 col-sm-6 col-md-3">
              <div class="dotted-under-line">
                <a href="<?php bloginfo( 'template_directory' );?>/eventnewslist">Event & News</a><span class="glyphicon glyphicon-menu-right"></span>
              </div>
            </li>
            <li class="col-xs-12 col-sm-6 col-md-3">
              <div class="dotted-under-line">
                <a href="http://e-art.tokyo/user/garally.php?artist_id=1">Garally e-ART</a><span class="glyphicon glyphicon-menu-right"></span>
              </div>
            </li>
            <li class="col-xs-12 col-sm-6 col-md-3">
              <div class="dotted-under-line">
                <a href="<?php bloginfo( 'template_directory' );?>/bloglist">Blog</a><span class="glyphicon glyphicon-menu-right"></span>
              </div>
            </li>
            <li class="col-xs-12 col-sm-6 col-md-3">
              <div class="dotted-under-line">
                <a href="<?php bloginfo( 'template_directory' );?>/profile-jp">Profile</a><span class="glyphicon glyphicon-menu-right"></span>
              </div>
            </li>
            <li class="col-xs-12 col-sm-6 col-md-3">
              <div class="dotted-under-line">
			<a href="http://e-art.tokyo/user/toiawase.php?artist_id=1" target="_blank">お問い合わせ</a>
				</div>
			</li>
            
          </ul>
        </div>

        
	  	<div class="row" style="text-align: center;">
	  		produced by<BR>e-art.tokyo
		</div>        
        
        
      </div>
	</div>
  </footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="<?php bloginfo( 'template_directory' );?>/js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="<?php bloginfo( 'template_directory' );?>/js/bootstrap.js"></script>

<?php wp_footer();//プラグインの実行に必要なタグ ?>
</body>
</html>




.dotted-under-line{
 border:1px #9FA0A0;  border-style:none none dotted none; color:#3E3A39;;
}

.site-map .glyphicon-menu-right{
	color:#7B7B7B;
	font-size:12px;
	float:right;
}
