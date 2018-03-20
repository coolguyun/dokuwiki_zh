<?php
/**
 * DokuWiki Template Scanlines
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * Thanks to Andreas Haerter's mnml-blog template, Michael Klier's arctic template and Anika Henke's starter template.
 * I used these templates as a starting point (mainly the configuration, sidebar and customizing).
 *
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @author Johannes Winkler <johannes@rocking-minds.org>
 * @author Andreas Gohr <andi@splitbrain.org> 
 * @link http://www.rocking-minds.org
 * @link http://www.dokuwiki.org/template:scanlines
 * @link http://www.dokuwiki.org/devel:templates
 * @link http://www.dokuwiki.org/devel:coding_style
 * @link http://www.dokuwiki.org/devel:environment
 * @link http://www.dokuwiki.org/devel:action_modes
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

global $ACT;

// include scanlines template functions
require_once(dirname(__FILE__).'/tpl_functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php tpl_pagetitle()?>[<?php echo strip_tags($conf['title'])?>]</title>
<?php   
//show meta-tags
tpl_metaheaders();
echo "<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\" />";

//include default or userdefined favicon
//
//note: since 2011-04-22 "Rincewind RC1", there is a core function named
//      "tpl_getFavicon()". But its functionality is not really fitting the
//      behaviour of this template, therefore I don't use it here exclusively.
if (file_exists(DOKU_TPLINC."user/favicon.ico")){
    //user defined - you might find http://tools.dynamicdrive.com/favicon/
    //useful to generate one
    echo "\n<link rel=\"shortcut icon\" href=\"".DOKU_TPL."user/favicon.ico\" />\n";
}elseif (file_exists(DOKU_TPLINC."user/favicon.png")){
    //note: I do NOT recommend PNG for favicons (cause it is not supported by
    //all browsers).
    echo "\n<link rel=\"shortcut icon\" href=\"".DOKU_TPL."user/favicon.png\" />\n";
}else{
    //default
    echo "\n<link rel=\"shortcut icon\" href=\"".(function_exists("tpl_getFavicon") ? tpl_getFavicon() : DOKU_TPL."images/favicon.ico")."\" />\n";
}

//include default or userdefined Apple Touch Icon (see <http://j.mp/sx3NMT> for
//details)
if (file_exists(DOKU_TPLINC."user/apple-touch-icon.png")){
    echo "<link rel=\"apple-touch-icon\" href=\"".DOKU_TPL."user/apple-touch-icon.png\" />\n";
}else{
    //default
    echo "<link rel=\"apple-touch-icon\" href=\"".(function_exists("tpl_getFavicon") ? tpl_getFavicon(false, "apple-touch-icon.png") : DOKU_TPL."images/apple-touch-icon.png")."\" />\n";
}
  	  

//load userdefined js?
if (tpl_getConf("scanlines_loaduserjs")){
	echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".DOKU_TPL."user/user.js\"></script>\n";
}

 /* old includehook */ @include(dirname(__FILE__).'/meta.html')?>  
  	
<!--[if lt IE 9]><link rel="stylesheet" media="all" type="text/css" href="<?php echo DOKU_TPL?>css/ltie9.css"/><![endif]-->  
<!--[if IE 9]><link rel="stylesheet" media="all" type="text/css" href="<?php echo DOKU_TPL?>css/ie9.css"/><![endif]-->    	
  	 	
<script src="<?php echo DOKU_TPL?>js/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo DOKU_TPL?>js/Limelight.font.js" type="text/javascript"></script>
<script src="<?php echo DOKU_TPL?>js/Aclonica.font.js" type="text/javascript"></script>
<script type="text/javascript">
	Cufon.replace('div.logo h1', { fontFamily: 'Limelight', color: '-linear-gradient(#55616c, 0.45=#8b97a2, 0.45=#7e8b98, #55616c)' });
	Cufon.replace('div.logo h2', { fontFamily: 'Aclonica',  color: '-linear-gradient(#55616c, #8b97a2)' });
</script>	
</head>
  
<body>
<?php /* old includehook */ @include(dirname(__FILE__).'/topheader.html')?>
<div class="dokuwiki">
	<?php html_msgarea()?>  

	<div class="stylehead">
  
   	<div class="header" id="header">    
   	
   		<div class="header_content">   		
      		<div class="logo">
					<?php tpl_logo()?>
				</div>
				<!-- To avoid delays, initialize Cufón before other scripts at the bottom -->
		      <script type="text/javascript"> Cufon.now(); </script>	
		      			
				<div class="userbar">
    				<?php tpl_userbar()?>	
    			</div>    			
    		</div> 	
    				
			<div class="clearer"></div>
			
     </div>
     
    	<?php /* old includehook */ @include(dirname(__FILE__).'/header.html')?>

	 	<div class="bar_top">
	 		<div class="bar_top_content">  	
	 			<div class="navi">			
    				<?php tpl_navi()?>
    				<div class="clearer"></div>
    				<div class="bar-right" id="bar__topright">
   	 				<?php tpl_searchform()?>    
   	 				<?php tpl_sitemap()?> 				
      			</div>      		
    			</div>
			</div>
		</div>		    	
  
  	</div>  
  	
 	
	<div class="main">
	
  		<?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>


		<?php flush()?>  								
 
  	  	  							   						
		<?php /* -------------- Closed Wiki (show no sidebar if not logged in) --------------- */ ?>
		<?php if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) {	?>	
		<?php tpl_closedwiki1(); } else {?> 	  							
 	  							
   	 
		<?php /* -------------- left sidebar --------------- */ ?>
 	
		<?php if(tpl_getConf('sidebar') == 'left') { ?>
	
		<?php if(!tpl_sidebar_hide() && $ACT != 'media') { ?>     							
      							  	
      							
  		<div class="left_sidebar">
		  	<?php tpl_sidebar('left')?>
  		</div>
	
		<div class="right_page">
			<div class="page_720">
				<div class="page_title">
					<?php tpl_link(wl($ID,'do=backlink'),tpl_pagetitle($ID,true),'title="'.$lang['btn_backlink'].'"')?>	
     			</div>	
	     		<div class="page_content">	
    				<?php /* wikipage start */?>    										
	  				<?php tpl_content(false)?> 
   				<?php /* wikipage stop */?>
    				<div class="clearer"></div>
   	 		</div>
  			</div>
  				
  			<!-- Pageinfo.  -->
  			<div class="bar_bottom" id="bar__bottom">
  				<div class="bar_bottom_content">
      			<div class="bar-left">
      			<?php tpl_pageinfo()?>
      		</div>
     				<div class="bar-right">
      				<?php tpl_button('edit')?>
      	  			<?php tpl_button('history')?>
      	  			<?php tpl_button('revert')?>
      	  			<?php tpl_button('media')?>
      	  		</div>
     			</div>  
     		</div>
     	</div>	
	
		<?php } else { ?>      
	
		<div class="full_page">
	  		<div class="page">
  				<div class="page_title">
  					<?php tpl_link(wl($ID,'do=backlink'),tpl_pagetitle($ID,true),'title="'.$lang['btn_backlink'].'"')?>	
     			</div>	
      		<div class="page_content">	
    				<?php /* wikipage start */?> 
    				<div class="toc_none_sidebar">
    					<?php tpl_toc()?>
    				</div>	 										
    				<?php tpl_content(false)?>
	   			<?php /* wikipage stop */?>
	   			<div class="clearer"></div>
	    		</div>
  			</div>
  			
  			<!-- Pageinfo.  -->
  			<div class="bar_bottom" id="bar__bottom">
  				<div class="bar_bottom_content">
      			<div class="bar-left">
      			<?php tpl_pageinfo()?>
      		</div>
     				<div class="bar-right">
      				<?php tpl_button('edit')?>
      	  			<?php tpl_button('history')?>
      	  			<?php tpl_button('revert')?>
      	  			<?php tpl_button('media')?>
      	  		</div>
     			</div>  
     		</div>
		</div>
   							    
     	<?php } ?>
     

     
		<?php /* -------------- right sidebar --------------- */ ?>
	 
		<?php } elseif(tpl_getConf('sidebar') == 'right') { ?>

		<?php if(!tpl_sidebar_hide() && $ACT != 'media') { ?>
		<div class="left_page">
			<div class="page_720">
				<div class="page_title">
					<?php tpl_link(wl($ID,'do=backlink'),tpl_pagetitle($ID,true),'title="'.$lang['btn_backlink'].'"')?>	
				</div>	
 				<div class="page_content">	
  	 				<?php /* wikipage start */?>    										
    				<?php tpl_content(false)?> 
  	 				<?php /* wikipage stop */?>
  	 				<div class="clearer"></div>
  	 			</div>
 			</div>
		 		
  			<!-- Pageinfo.  -->
  			<div class="bar_bottom" id="bar__bottom">
  				<div class="bar_bottom_content">
      			<div class="bar-left">
      			<?php tpl_pageinfo()?>
      		</div>
     				<div class="bar-right">
      				<?php tpl_button('edit')?>
      	  			<?php tpl_button('history')?>
      	  			<?php tpl_button('revert')?>
      	  			<?php tpl_button('media')?>
      	  		</div>
     			</div>  
     		</div>
		</div> 
	    							  	   							
		<div class="right_sidebar">
			<?php tpl_sidebar('right')?>
		</div>
	

		<?php } else { ?>      
		<div class="full_page">
			<div class="page">
 				<div class="page_title">
 					<?php tpl_link(wl($ID,'do=backlink'),tpl_pagetitle($ID,true),'title="'.$lang['btn_backlink'].'"')?>	
  				</div>	
  				<div class="page_content">	
   				<?php /* wikipage start */?>   
   				<div class="toc_none_sidebar">
   					<?php tpl_toc()?>
   				</div>	 										
   				<?php tpl_content(false); ?>
  					<?php /* wikipage stop */?>
  					<div class="clearer"></div>
   			</div>
			</div>
 		
  			<!-- Pageinfo.  -->
  			<div class="bar_bottom" id="bar__bottom">
  				<div class="bar_bottom_content">
      			<div class="bar-left">
      			<?php tpl_pageinfo()?>
      		</div>
     				<div class="bar-right">
      				<?php tpl_button('edit')?>
      	  			<?php tpl_button('history')?>
      	  			<?php tpl_button('revert')?>
      	  			<?php tpl_button('media')?>
      	  		</div>
     			</div>  
     		</div>								
		</div>  
  
		<?php } ?>
      
           
		<?php /* -------------- no sidebar --------------- */ ?>
		<?php } elseif(tpl_getConf('sidebar') == 'none') { ?>
		<div class="full_page">
			<div class="page">
				<div class="page_title">
					<?php tpl_link(wl($ID,'do=backlink'),tpl_pagetitle($ID,true),'title="'.$lang['btn_backlink'].'"')?>	
				</div>	
				<div class="page_content">	
					<?php /* wikipage start */?>    
					<div class="toc_none_sidebar">
						<?php tpl_toc()?>
					</div>	 										
	    			<?php tpl_content(false)?>
	   			<?php /* wikipage stop */?>
	   			<div class="clearer"></div>
	    		</div>
	  		</div>
	  			
  			<!-- Pageinfo.  -->
  			<div class="bar_bottom" id="bar__bottom">
  				<div class="bar_bottom_content">
      			<div class="bar-left">
      			<?php tpl_pageinfo()?>
      		</div>
     				<div class="bar-right">
      				<?php tpl_button('edit')?>
      	  			<?php tpl_button('history')?>
      	  			<?php tpl_button('revert')?>
      	  			<?php tpl_button('media')?>
      	  		</div>
     			</div>  
     		</div>
		</div>
	    						 
		<?php }} ?>   							
   					
   	<div class="clearer"></div>
     						 		
 	</div>

 	
	<div class="clearer"></div>	
	
   <div class="footer">
		<?php /* old includehook */ @include(dirname(__FILE__).'/footer.html')?>
		<?php tpl_license(false);?>		
		<!-- <div class="license"> Your own License (remove the html comment and "tpl_license(false)")</div> -->
		<?php //Note: you are NOT allowed to remove the following notice. Please respect this! ?>
		<a href="http://www.rocking-minds.org/blog/2011-08-27/dokuwiki_template_scanlines">Scanlines</a> on <a href="http://www.dokuwiki.org">DW</a> under the hood
	</div>	
	
   <?php tpl_top_link()?>	

</div>
<div class="no">
    <?php
    //provide DokuWiki housekeeping, required in all templates
    tpl_indexerWebBug();
    //include web analytics software
    if (file_exists(DOKU_TPLINC."/user/tracker.php")){
        include DOKU_TPLINC."/user/tracker.php";
    }
    ?>
</div>
</body>
</html>
