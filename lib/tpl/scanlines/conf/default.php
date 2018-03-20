<?php

/**
 * Default options for the "scanlines" DokuWiki template
 *
 * Notes:
 * - In general, use the admin webinterface of DokuWiki to change the config.
 * - To change the type of a config value, have a look at "metadata.php" in
 *   the same directory as this file.
 * - To change/translate the descriptions showed in the admin/configuration
 *   menu of DokuWiki, have a look at the file
 *   "/lib/tpl/scanlines/lang/<your lang>/settings.php". If it does not exists,
 *   copy and translate the English one. And don't forget to mail the
 *   translation to me, Johannes Winkler <johannes@rocking-minds.org> :-D.
 *
 *
 * LICENSE: This file is open source software (OSS) and may be copied under
 *          certain conditions. See COPYING file for details or try to contact
 *          the author(s) of this file in doubt.
 *
 * @license GPLv2 (http://www.gnu.org/licenses/gpl2.html)
 * @author Johannes Winkler <johannes@rocking-minds.org> 
 * @author Michael Klier <chi@chimeric.de>
 * @link   http://www.dokuwiki.org/devel:configuration
 * @link   http://www.dokuwiki.org/template:scanlines
 * @link   http://www.dokuwiki.org/template:arctic 
 */

$conf['sidebar']                     	= 'right';                       		 							  // sidebar on the right
$conf['pagename']                    	= 'Sidebar';                     									  // the pagename for sidebars inside namespaces
$conf['main_sidebar_always']		    	= 1;									   		 							  // show main sidebar on all namespaces
$conf['user_sidebar_namespace']      	= '';                        		 							  		  // namespace to look for namespace of logged in users
$conf['group_sidebar_namespace']     	= '';                       									  		  // namespace to look for groups-namespaces
$conf['left_sidebar_content']        	= 'main,index,extra,toc';	 		 							        // defines the content of the left sidebar
$conf['left_sidebar_order']          	= 'main,toc,toolbox,user,group,namespace,index,trace,extra';  // defines the order of the left sidebar content
$conf['right_sidebar_content']       	= 'main,index,extra,toc,';	 		 							        // defines the content of the right sidebar
$conf['right_sidebar_order']         	= 'main,toc,toolbox,user,group,namespace,index,trace,extra';  // defines the order of the right sidebar content
$conf['closedwiki1']                 	= 0;                             		 							  // show no sidebar to non logged in users
$conf['closedwiki2']                 	= 0;                             		 							  // Sidebar shows only the login link to non logged in users
$conf['hideactions']                	= 0;                             			 						  // hide all wiki related actions to non logged in users
$conf['userbar']              	 	 	= 1;									   			 						  // show userbar on top
$conf['sitemap']              	  	   = 1;								      			  						  // show sitemap-button in navigation
$conf['logo']                          = 'text';											 	 					  // the logo consists of text
$conf['logo_image']                    = '';													 	 					  // path to the logo-image
$conf['logo_yourdefinition']      	   = 'your little definition';					 						  // your definitin in the logo
$conf['logo_yourname']           	  	= 'by your name';					   			 						  // your name in the logo
$conf['navibutton1']          			= '[[start|Home]]';				   			 						  // navibutton1 in the navigation
$conf['navibutton2']          		   = '[[blog|Blog]]';								 						  // navibutton2 in the navigation
$conf['navibutton3']             	   = '[[wiki|Wiki]]';							 	 						  // navibutton3 in the navigation
$conf['navibutton4']             		= '[[about|About]]';								 						  // navibutton4 in the navigation
$conf['navibutton5']                	= '[[another link|another link]]';			 						  // navibutton5 in the navigation
$conf['navibutton6']                	= '[[another link|another link]]';		 	 						  // navibutton6 in the navigation
$conf['top_link']                		= 1;		 											 						  // show rocket with top-link
$conf["mnmlblog_loaduserjs"]           = false;                                                      //TRUE: scanlines/user/user.js will be loaded
 
?>
