<?php  if(strlen(get_option('mediamiles_siteid')) != 0 ){ ?>
<input type="hidden" id="admin_url" value=""  />
<input type="hidden" id="plugin_url" value="<?php echo plugins_url('../', __file__); ?>" />
<div class="wrapper laudd-html">    
    <div class="header">
        <div class="container">
            <div class="header-inner">
                <div class="logo">
                    <img src="<?php echo plugins_url( '../images/logo.png', __FILE__ ) ?>" alt="img">
                </div>
            </div>
        </div>      
    </div>  
    <div class="content" style="margin-top:0px;">
        <div class="container">
			<div class="l_success message" style="margin-bottom:100px;">
				<h3>Activation Successful!</h3>
				<p>The MediaMiles Social Sharing Traffic Plugin is now active. The MediaMiles toolbar will now appear on all pages.</p>			
				<div class="btn-cont">
						<a href="<?php echo admin_url( 'edit.php' ); ?>" class="thanks-btn">OK</a>
				</div>
			</div>
		</div>
	</div>           
</div>
<!--------------------------------------------------------------------------------------------------------------->
<?php  } ?>