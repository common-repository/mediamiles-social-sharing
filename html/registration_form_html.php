<div id="ustat-loding" style="display:none;" class="loading-gif-img"><img src="<?php echo plugins_url( '../images/ajax-loader.gif', __FILE__ ) ?>"></div>
<div class="wrapper laudd-html">	
    <div class="header">
    	<div class="container">
            <div class="header-inner">
                <div class="logo">
                    <img src="<?php echo plugins_url( '../images/logo.png', __FILE__ ) ?>" alt="MediaMiles Logo">
                </div>
            </div>
        </div>	    
    </div>    
	<div class="l_error message" style="display:none;">
     <h3>Oops, an error ocurred</h3>
     <p>An internal error occured. Please wait and try again after some time.</p>
	</div>
	
    <div class="content">
    	<div class="container">
        	<div class="content-inner">            	
                               <div class="lt-cont">
                	<div class="heading">Viralize Your Website!&#8482;</div>
                    <div class="reg-points">
                    	<ul>
                        	<li>
                            	<div class="icon">
                                	<img src="<?php echo plugins_url( '../images/share-icon.png', __FILE__ ) ?>" alt="img">
                                </div>
                                <div class="icon-text">
                                	<div class="icon-heading">
                                    	Motivate users to share your content
                                    </div>
                                    <div class="icon-txt">
                                    	Activating the plugin displays the cool MediaMiles toolbar on all pages and posts, enabling users to share them on popular social networks. 
                                    	Users get one MediaMile for each unique visit back from such shared links. Users can redeem MediaMiles for real, valuable rewards by simply clicking the Redeem button on the toolbar!
                                    </div>
                                </div>
                            </li>                           
                            <li>
                            	<div class="icon">
                                	<img src="<?php echo plugins_url( '../images/traffic-icon.png', __FILE__ ) ?>" alt="img">
                                </div>
                                <div class="icon-text">
                                	<div class="icon-heading">
                                    	Increase social traffic and reach
                                    </div>
                                    <div class="icon-txt">
                                    	Watch your blog or website take off, as more users share your posts or pages to earn MediaMiles.
                                    </div>
                                </div>
                            </li>                           
                            <li>
                            	<div class="icon">
                                	<img src="<?php echo plugins_url( '../images/content-icon.png', __FILE__ ) ?>" alt="img">
                                </div>
                                <div class="icon-text">
                                	<div class="icon-heading">
                                    	Reward your users
                                    </div>
                                    <div class="icon-txt">
                                    	Users can click from the MediaMiles toolbar to view and redeem their points for valuable rewards.
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
				<?php if(strlen(get_option('mediamiles_siteid')) == 0 ) {?>
					 <div id="laudd_user_registration">
					   <div class="rt-cont">
						   <div class="get-txt">Activate the MediaMiles Social Sharing Traffic Plugin</div>
						   <div class="reg-instr">
							<p>In order to activate the MediaMiles Plugin, you need to have registered your WordPress website by going to <a href="https://mediamiles.net" target="_blank" >https://mediamiles.net</a></p>
							<p>Once you register your website there, you will see a "Site Id" in the configuration page. Enter that Site Id below:</p>
						   </div>
						   <div class="form">
						     <form name="laudd-register" method="post" action="" onsubmit="return validate();">
									<input type="text" placeholder="Copy and paste the Site Id here" name="site_id" id="mediamiles_site_id">
									<input type="hidden" name="redirect-page" id="thanks-redirect-page" value="<?php echo admin_url("tools.php?page=MediaMiles-Thankyou") ?>" />
									<input type="hidden" name="redirect-cancel-url" id="redirect-cancel-url" value="<?php echo admin_url("plugins.php") ?>" />
									<input type="submit" value="Submit"  name="submit_site_id" id="submit_site_id" />
							 </form>
						   </div> 
					   </div>
					</div>
			
				<?php } else {?>
					<script>mediamiles_redirect('<?php echo admin_url("tools.php?page=MediaMiles-Thankyou") ?>');</script>
				<?php }?>
            </div>
        </div>
    </div>
</div>

