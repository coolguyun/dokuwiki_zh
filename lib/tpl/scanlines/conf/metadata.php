<?php

/**
 * Types of the different option values for the "scanlines" DokuWiki template
 *
 * Notes:
 * - In general, use the admin webinterface of DokuWiki to change the config.
 * - To change/add configuration values to store, have a look at this file
 *   and the "default.php" in the same directory as this file.
 * - To change/translate the descriptions showed in the admin/configuration
 *   menu of DokuWiki, have a look at the file
 *   "/lib/tpl/scanlines/lang/<your lang>/settings.php". If it does not exists,
 *   copy and translate the English one. And don't forget to mail the
 *   translation to me, Johannes Winkler <johannes@rocking-minds.org>  :-D.
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

$meta['sidebar']                       = array('multichoice', '_choices' => array('left', 'right', 'none'));
$meta['pagename']                   	= array('string', '_pattern' => '#[a-z0-9]*#');
$meta['main_sidebar_always']	    	   = array('onoff');
$meta['user_sidebar_namespace']   	   = array('string', '_pattern' => '#^[a-z:]*#');
$meta['group_sidebar_namespace']  	   = array('string', '_pattern' => '#^[a-z:]*#');
$meta['left_sidebar_order']       	   = array('string', '_pattern' => '#[a-z0-9,]*#');
$meta['left_sidebar_content']     	   = array('multicheckbox', '_choices' => array('main','toc','user','group','namespace','toolbox','index','trace','extra'));
$meta['right_sidebar_order']     	   = array('string', '_pattern' => '#[a-z0-9,]*#');
$meta['right_sidebar_content']   	   = array('multicheckbox', '_choices' => array('main','toc','user','group','namespace','toolbox','index','trace','extra',));
$meta['closedwiki1']             	   = array('onoff');
$meta['closedwiki2']             	   = array('onoff');
$meta['hideactions']             	   = array('onoff');
$meta['userbar']              	  	   = array('onoff');
$meta['sitemap']              	      = array('onoff');
$meta['logo']                          = array('multichoice', '_choices' => array('image', 'text'));
$meta['logo_image']                    = array('string', '_pattern' => '#[a-z0-9\/]*#');
$meta['logo_yourdefinition']           = array('string', '_pattern' => '#[a-z0-9]*#');
$meta['logo_yourname']               	= array('string', '_pattern' => '#[a-z0-9]*#');
$meta['navibutton1']          	    	= array('string', '_pattern' => '#[a-z0-9\[\]\|]*#');
$meta['navibutton2']          	    	= array('string', '_pattern' => '#[a-z0-9\[\]\|]*#');
$meta['navibutton3']                   = array('string', '_pattern' => '#[a-z0-9\[\]\|]*#');
$meta['navibutton4']                   = array('string', '_pattern' => '#[a-z0-9\[\]\|]*#');
$meta['navibutton5']                   = array('string', '_pattern' => '#[a-z0-9\[\]\|]*#');
$meta['navibutton6']                   = array('string', '_pattern' => '#[a-z0-9\[\]\|]*#');
$meta['top_link']              	  	   = array('onoff');
$meta["scanlines_loaduserjs"]          = array("onoff");

?>
