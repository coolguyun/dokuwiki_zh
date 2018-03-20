<?php
/**
 * DokuWiki template scanlines functions
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author  Michael Klier <chi@chimeric.de>
 * @author  Johannes Winkler <johannes@rocking-minds.org>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_LF')) define('DOKU_LF',"\n");

// load language files
require_once(DOKU_TPLINC.'lang/en/lang.php');
if(@file_exists(DOKU_TPLINC.'lang/'.$conf['lang'].'/lang.php')) {
    require_once(DOKU_TPLINC.'lang/'.$conf['lang'].'/lang.php');
}

// load sidebar contents
$sbl   = explode(',',tpl_getConf('left_sidebar_content'));
$sbr   = explode(',',tpl_getConf('right_sidebar_content'));
$sbpos = tpl_getConf('sidebar');

// set notoc option and toolbar regarding the sitebar setup
switch($sbpos) {
  case 'left':
    $notoc = (in_array('toc',$sbl)) ? true : false;
    $toolb = (in_array('toolbox',$sbl)) ? true : false;
    break;
  case 'right':
    $notoc = (in_array('toc',$sbr)) ? true : false;
    $toolb = (in_array('toolbox',$sbr)) ? true : false;
    break;
  case 'none':
    $notoc = false;
    $toolb = false;
    break;
}

/**
 * Prints the sidebars
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar($pos) {

    $sb_order   = ($pos == 'left') ? explode(',', tpl_getConf('left_sidebar_order'))   : explode(',', tpl_getConf('right_sidebar_order'));
    $sb_content = ($pos == 'left') ? explode(',', tpl_getConf('left_sidebar_content')) : explode(',', tpl_getConf('right_sidebar_content'));

    // process contents by given order
    foreach($sb_order as $sb) {
        if(in_array($sb,$sb_content)) {
            $key = array_search($sb,$sb_content);
            unset($sb_content[$key]);
            tpl_sidebar_dispatch($sb,$pos);
        }
    }

    // check for left content not specified by order
    if(is_array($sb_content) && !empty($sb_content) > 0) {
        foreach($sb_content as $sb) {
            tpl_sidebar_dispatch($sb,$pos);
        }
    }
}

/**
 * Dispatches the given sidebar type to return the right content
 *
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar_dispatch($sb,$pos) {
    global $lang;
    global $conf;
    global $ID;
    global $REV;
    global $INFO;
    global $TOC;

    $svID  = $ID;   // save current ID
    $svREV = $REV;  // save current REV 
    $svTOC = $TOC;  // save current TOC

    $pname = tpl_getConf('pagename');

    switch($sb) {

        case 'main':
       		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;
            $main_sb = $pname;
            if(@page_exists($main_sb) && auth_quickaclcheck($main_sb) >= AUTH_READ) {
                $always = tpl_getConf('main_sidebar_always');
                if($always or (!$always && !getNS($ID))) {
                    print '<div class="sidebar_single">' . DOKU_LF;
                    print '	<div class="sidebar_title">' . $main_sb . '</div>' . DOKU_LF;
                    print '	<div class="sidebar_content">' . DOKU_LF; 
                    print 			p_sidebar_xhtml($main_sb,$pos) . DOKU_LF;
                    print '</div>' . DOKU_LF;
                    print '</div>' . DOKU_LF;
                }
            } elseif(!@page_exists($main_sb) && auth_quickaclcheck($main_sb) >= AUTH_CREATE) {
                if(@file_exists(DOKU_TPLINC.'lang/'. $conf['lang'].'/nonidebar.txt')) {
                    $out = p_render('xhtml', p_get_instructions(io_readFile(DOKU_TPLINC.'lang/'.$conf['lang'].'/nosidebar.txt')), $info);
                } else {
                    $out = p_render('xhtml', p_get_instructions(io_readFile(DOKU_TPLINC.'lang/en/nosidebar.txt')), $info);
                }
                $link = '<a href="' . wl($pname) . '" class="wikilink2">' . $pname . '</a>' . DOKU_LF;
                print '<div class="sidebar_single">' . DOKU_LF;
                print '	<div class="sidebar_title">' . $main_sb . '</div>' . DOKU_LF;
                print '		<div class="sidebar_content">' . DOKU_LF;               
                print 			str_replace('LINK', $link, $out);
                print '</div>' . DOKU_LF;
                print '</div>' . DOKU_LF;
            }
            break;




        case 'namespace':
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;
            $user_ns  = tpl_getConf('user_sidebar_namespace');
            $group_ns = tpl_getConf('group_sidebar_namespace');
            if(!preg_match("/^".$user_ns.":.*?$|^".$group_ns.":.*?$/", $svID)) { // skip group/user sidebars and current ID
                $ns_sb = _getNsSb($svID);
                if($ns_sb && auth_quickaclcheck($ns_sb) >= AUTH_READ) {
                	print '<div class="sidebar_single">' . DOKU_LF;
               	print '	<div class="sidebar_title">' . $lang['namespace'] . '</div>' . DOKU_LF;
                	print '	<div class="sidebar_content">' . DOKU_LF;               
                  print 		p_sidebar_xhtml($ns_sb,$pos) . DOKU_LF;
                  print '	</div>' . DOKU_LF;
                  print '</div>' . DOKU_LF;  
                }
            }
            break;

        case 'user':
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;
            $user_ns = tpl_getConf('user_sidebar_namespace');
            if(isset($INFO['userinfo']['name'])) {
                $user = $_SERVER['REMOTE_USER'];
                $user_sb = $user_ns . ':' . $user . ':' . $pname;
                if(@page_exists($user_sb)) {
                    $subst = array('pattern' => array('/@USER@/'), 'replace' => array($user));                    
                	  print '<div class="sidebar_single">' . DOKU_LF;
               	  print '	<div class="sidebar_title">' . DOKU_LF;
               	  					if($user_ns) {print $user_ns;
               	  					} else {print $lang['user'] . DOKU_LF;}
               	  print '	</div>' . DOKU_LF;
               	  print '	<div class="sidebar_content">' . DOKU_LF;               
                    print 			p_sidebar_xhtml($user_sb,$pos,$subst) . DOKU_LF;
                    print '	</div>' . DOKU_LF;
            		  print '</div>' . DOKU_LF;  
                }
                // check for namespace sidebars in user namespace too
                if(preg_match('/'.$user_ns.':'.$user.':.*/', $svID)) {
                    $ns_sb = _getNsSb($svID); 
                    if($ns_sb && $ns_sb != $user_sb && auth_quickaclcheck($ns_sb) >= AUTH_READ) {                    	
                    	   print '<div class="sidebar_single">' . DOKU_LF;
               	  		print '	<div class="sidebar_title">' . DOKU_LF;
               	  						if($user_ns) {print $user_ns;
               	  						} else {print $lang['user'] . DOKU_LF;}
               	  		print '	</div>' . DOKU_LF;
               	      print '	<div class="sidebar_content">' . DOKU_LF;              
                        print 		p_sidebar_xhtml($ns_sb,$pos) . DOKU_LF;
                        print '	</div>' . DOKU_LF;
            				print '</div>' . DOKU_LF;  
                    }
                }

            }
            break;

        case 'group':
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;
            $group_ns = tpl_getConf('group_sidebar_namespace');
            if(isset($INFO['userinfo']['name'], $INFO['userinfo']['grps'])) {
                foreach($INFO['userinfo']['grps'] as $grp) {
                    $group_sb = $group_ns.':'.$grp.':'.$pname;
                    if(@page_exists($group_sb) && auth_quickaclcheck(cleanID($group_sb)) >= AUTH_READ) {
                        $subst = array('pattern' => array('/@GROUP@/'), 'replace' => array($grp));                        
                        print '<div class="sidebar_single">' . DOKU_LF;
               	  		print '	<div class="sidebar_title">' . DOKU_LF;
               	  						if($group_ns) {print $group_ns;
               	  						} else {print $lang['group'] . DOKU_LF;}
               	  		print '	</div>' . DOKU_LF; 
               	      print '	<div class="sidebar_content">' . DOKU_LF;               
                        print 		p_sidebar_xhtml($group_sb,$pos,$subst) . DOKU_LF;
                        print '	</div>' . DOKU_LF;
                        print '</div>' . DOKU_LF;  
                    }
                }
            }
            break;

        case 'index':
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;
            print '<div class="sidebar_single">' . DOKU_LF;
            print '	<div class="sidebar_title">' . $lang['index'] . '</div>' . DOKU_LF;
            print '	<div class="sidebar_content">' . DOKU_LF;               
            print 		'  ' . p_index_xhtml($svID,$pos) . DOKU_LF;
            print '		</div>' . DOKU_LF;
            print '</div>' . DOKU_LF;            
            break;

        case 'toc':
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
				if (auth_quickaclcheck($svID) >= AUTH_READ) {
           		$toc = tpl_toc(true);
           	   if(!empty($toc)) {
						print tpl_toc(true);
					}
            }
            break;
        
        case 'toolbox':
				if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('hideactions') && !isset($_SERVER['REMOTE_USER'])) return;

            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) {
            	
            	 print '<div class="sidebar_single">' . DOKU_LF;
                print '	<div class="sidebar_title">' . $lang['toolbox'] . '</div>' . DOKU_LF;
                print '	<div class="sidebar_content">' . DOKU_LF;
                print '		<div class="li_toolbox">' . DOKU_LF;             
                print ' 		<ul>' . DOKU_LF;
                print '				<li>';                
                							tpl_actionlink('login');
                print '      		</li>' . DOKU_LF;
                print '    	</ul>' . DOKU_LF;
                print '		</div>' . DOKU_LF;
                print '	</div>' . DOKU_LF;
                print '</div>' . DOKU_LF;

            } else {
                $actions = array('admin', 
                                 'revert', 
                                 'edit', 
                                 'history', 
                                 'recent', 
                                 'backlink', 
                                 'subscription', 
                                 'index', 
                                 'login', 
                                 'profile',
                                 'top');
                                 
            	 print '<div class="sidebar_single">' . DOKU_LF;
                print '	<div class="sidebar_title">' . $lang['toolbox'] . '</div>' . DOKU_LF;
                print '	<div class="sidebar_content">' . DOKU_LF;  
                print '		<div class="li_toolbox">' . DOKU_LF;    
                print '    	<ul>' . DOKU_LF;

                foreach($actions as $action) {
                    if(!actionOK($action)) continue;
                    // start output buffering
                    if($action == 'edit') {
                        // check if new page button plugin is available
                        if(!plugin_isdisabled('npd') && ($npd =& plugin_load('helper', 'npd'))) {
                            $npb = $npd->html_new_page_button(true);
                            if($npb) {
                              	print '<li>';
                                 print $npb;
                                 print '</li>' . DOKU_LF;
                            }
                        }
                    }
                    ob_start();
                    print '<li>';
                    if(tpl_actionlink($action)) {
                        print '</li>' . DOKU_LF;
                        ob_end_flush();
                    } else {
                        ob_end_clean();
                    }
                }

                print '    	</ul>' . DOKU_LF;
                print '  	</div>' . DOKU_LF;
                print '  </div>' . DOKU_LF;
                print '</div>' . DOKU_LF;
            }

            break;

        case 'trace':
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;          
            print '<div class="sidebar_single">' . DOKU_LF;
            print '	<div class="sidebar_title">'. $lang['breadcrumb'].'</div>' . DOKU_LF;
            print '	<div class="sidebar_content">' . DOKU_LF;               
              				($conf['youarehere'] != 1) ? tpl_breadcrumbs() : tpl_youarehere();
            print '  </div>' . DOKU_LF;
            print '</div>' . DOKU_LF;
            break;

        case 'extra':
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;
            print '<div class="sidebar_single">' . DOKU_LF;
            print '	<div class="sidebar_content">';    
            				@include(dirname(__FILE__).'/' . $pos .'_sidebar.html');
            				 tpl_userinfo(); 
            print '	</div>' . DOKU_LF;
            print '</div>' . DOKU_LF;
            break;
            
     

        default:
        		if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) return;
            if(tpl_getConf('closedwiki2') && !isset($_SERVER['REMOTE_USER'])) return;
            // check for user defined sidebars
            if(@file_exists(DOKU_TPLINC.'sidebars/'.$sb.'/sidebar.php')) {
            	print '<div class="sidebar_single">' . DOKU_LF;
               print '	<div class="sidebar_title">' . $sb . '</div>' . DOKU_LF;
					print '	<div class="sidebar_content">' . DOKU_LF;
                   			@require_once(DOKU_TPLINC.'sidebars/'.$sb.'/sidebar.php');
            	print '	</div>' . DOKU_LF;
            	print '</div>' . DOKU_LF;
            }
            break;
    }

    // restore ID, REV and TOC
    $ID  = $svID;
    $REV = $svREV;
    $TOC = $svTOC;
}

/**
 * Removes the TOC of the sidebar pages and 
 * shows a edit button if the user has enough rights
 *
 * TODO sidebar caching
 * 
 * @author Michael Klier <chi@chimeric.de>
 */
function p_sidebar_xhtml($sb,$pos,$subst=array()) {
    $data = p_wiki_xhtml($sb,'',false);
    if(!empty($subst)) {
        $data = preg_replace($subst['pattern'], $subst['replace'], $data);
    }
    if(auth_quickaclcheck($sb) >= AUTH_EDIT) {
        $data .= '<div class="secedit">'.html_btn('secedit',$sb,'',array('do'=>'edit','rev'=>'','post')).'</div>';
    }
    // strip TOC
    $data = preg_replace('/<div class="toc">.*?(<\/div>\n<\/div>)/s', '', $data);
    // replace headline ids for XHTML compliance
    $data = preg_replace('/(<h.*?><a.*?name=")(.*?)(".*?id=")(.*?)(">.*?<\/a><\/h.*?>)/','\1sb_'.$pos.'_\2\3sb_'.$pos.'_\4\5', $data);
    return ($data);
}

/**
 * Renders the Index
 *
 * copy of html_index located in /inc/html.php
 *
 * TODO update to new AJAX index possible?
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 * @author Michael Klier <chi@chimeric.de>
 */
function p_index_xhtml($ns,$pos) {
  require_once(DOKU_INC.'inc/search.php');
  global $conf;
  global $ID;
  $dir = $conf['datadir'];
  $ns  = cleanID($ns);
  #fixme use appropriate function
  if(empty($ns)){
    $ns = dirname(str_replace(':','/',$ID));
    if($ns == '.') $ns ='';
  }
  $ns  = utf8_encodeFN(str_replace(':','/',$ns));

  // extract only the headline
  preg_match('/<h1>.*?<\/h1>/', p_locale_xhtml('index'), $match);
  print preg_replace('#<h1(.*?id=")(.*?)(".*?)h1>#', '<h1\1sidebar_'.$pos.'_\2\3h1>', $match[0]);

  $data = array();
  search($data,$conf['datadir'],'search_index',array('ns' => $ns));

  print '<div id="' . $pos . '__index__tree">' . DOKU_LF;
  print html_buildlist($data,'idx','html_list_index','html_li_index');
  print '</div>' . DOKU_LF;
}

/**
 * searches for namespace sidebars
 *
 * @author Michael Klier <chi@chimeric.de>
 */
function _getNsSb($id) {
    $pname = tpl_getConf('pagename');
    $ns_sb = '';
    $path  = explode(':', $id);
    $found = false;

    while(count($path) > 0) {
        $ns_sb = implode(':', $path).':'.$pname;
        if(@page_exists($ns_sb)) return $ns_sb;
        array_pop($path);
    }
    
    // nothing found
    return false;
}

/**
 * Checks wether the sidebar should be hidden or not
 *
 * @author Michael Klier <chi@chimeric.de>
 */
function tpl_sidebar_hide() {
    global $ACT;
    $act_hide = array( 'edit', 'preview', 'admin', 'conflict', 'draft', 'recover');
    if(in_array($ACT, $act_hide)) {
        return true;
    } else {
        return false;
    }
}

function tpl_userbar() {
	if(tpl_getConf('userbar')) {

		if(!tpl_getConf('closedwiki2') || (tpl_getConf('closedwiki2') && isset($_SERVER['REMOTE_USER']))) {

      	// check if new page button plugin is available
        	if(!plugin_isdisabled('npd') && ($npd =& plugin_load('helper', 'npd'))) {
        		$npd->html_new_page_button();
        }
      	         	     
      }
   	if(!tpl_getConf('closedwiki2') || (tpl_getConf('closedwiki2') && isset($_SERVER['REMOTE_USER']))) {
   	  	tpl_actionlink('admin');
   	 	tpl_actionlink('profile');
   	 	tpl_actionlink('login');
   	 	
   	} else {
   	 	tpl_actionlink('login');
   	}
	}
}

function tpl_sitemap() {	
	if(tpl_getConf('sitemap')) {
		tpl_button('index')  . DOKU_LF;
	}
}

function tpl_closedwiki1() {	
	if(tpl_getConf('closedwiki1') && !isset($_SERVER['REMOTE_USER'])) {							
		print '<div class="page">' . DOKU_LF;
		print '	<div class="page_title">' . DOKU_LF;
						tpl_link(wl($ID,'do=backlink'),tpl_pagetitle($ID,true),'title="'.$lang['btn_backlink'].'"');
		print '	</div>' . DOKU_LF;	
		print '	<div class="page_content">' . DOKU_LF;	
	   				// wikipage start    
	   print '		<div class="toc_none_sidebar">' . DOKU_LF;
	   					tpl_toc();
	   print '		</div>' . DOKU_LF;										
	   				tpl_content(false);
	   				// wikipage stop 
	   print '	</div>' . DOKU_LF;
	   print '</div>' . DOKU_LF;
	
				// Pageinfo. 
		print '<div class="bar_bottom" id="bar__bottom">' . DOKU_LF;
		print '	<div class="bar-left" id="bar__bottomleft">' . DOKU_LF;
						tpl_pageinfo();
		print '	</div>' . DOKU_LF;
		print '	<div class="bar-right" id="bar__bottomright">' . DOKU_LF;
			 			tpl_button('edit');
			 			tpl_button('history');
						tpl_button('revert');
		print '	</div>' . DOKU_LF;
		print '</div>' . DOKU_LF;  
							
 
	}		
} 

/* thanks to dokubook-template */
function tpl_logo() {
	global $conf;
	$out = '';

	switch(tpl_getConf('logo')) {
		case 'text':
			 $out .= '<h1>' . DOKU_LF;
   		 $out .= '<a href="' . DOKU_BASE . '">' . $conf['title'] . '</a>' . DOKU_LF;	
   		 $out .= '</h1>' . DOKU_LF;
			 $out .= '<h2>' . DOKU_LF;		
			 $out .= '	<span style="border-bottom: 2px dotted #ada899;">' . DOKU_LF;
	
								if(tpl_getConf('logo_yourdefinition')) {
									$out .= tpl_getConf('logo_yourdefinition')  . DOKU_LF;
								}
								
								$out .= '<br />' . DOKU_LF;
								
								if(tpl_getConf('logo_yourname')) {
									$out .= tpl_getConf('logo_yourname')  . DOKU_LF;
								}
		
			 $out .= '	</span>' . DOKU_LF;
			 $out .= '</h2>' . DOKU_LF;
			 break;	
					
		case 'image': 
    		switch(true) {
        		case(tpl_getConf('logo_image')):
         		$logo = tpl_getConf('logo_image');
         	   break;
         	   
      	   case(@file_exists(DOKU_TPLINC.'user/logo.jpg')):
     	    	   $logo = DOKU_TPL.'user/logo.jpg';
     	    	   break;
			   case(@file_exists(DOKU_TPLINC.'user/logo.jpeg')):
     	    	   $logo = DOKU_TPL.'user/logo.jpeg';
     	    	   break;
 			   case(@file_exists(DOKU_TPLINC.'user/logo.png')):
     	    	   $logo = DOKU_TPL.'user/logo.png';
     	    	   break;   			
    			
   	   	case(@file_exists(DOKU_TPLINC.'images/logo.jpg')):
     	    	   $logo = DOKU_TPL.'images/logo.jpg';
     	    	   break;
			   case(@file_exists(DOKU_TPLINC.'images/logo.jpeg')):
     	    	   $logo = DOKU_TPL.'images/logo.jpeg';
     	    	   break;
     	      case(@file_exists(DOKU_TPLINC.'images/logo.png')):
     	    	   $logo = DOKU_TPL.'images/logo.png';
     	    	   break; 
     	    	        	    	       	    	   
     	      default:
     	    	   $logo = DOKU_TPL.'user/logo.png';
     	    	   break;
    	}

    	$out .= '<a href="' . DOKU_BASE . '">';
    	$out .= '  <img class="logo" src="' . $logo . '" alt="' . $conf['title'] . '" /></a>' . DOKU_LF;
    	break;           
	}	
	print $out;				
}

function tpl_navi() {	
	// nb = navibutton
	print '<ul>' . DOKU_LF;
	
				for ($i = 1; $i <= 6; $i++){ 
					$nb = tpl_getConf('navibutton' . $i);
					$nb_without_bracket = substr($nb, 2, -2);
					$nb_explode = explode('|', $nb_without_bracket);
					$nb_cleaned = array();
					if (count($nb_explode) > 0) {
	   				foreach ($nb_explode as $nb_foreach) {
	     					if ($nb_foreach) {
	      					$nb_cleaned[] = $nb_foreach;
	     					}
	   				}
					}	
																			
					if(!empty($nb_cleaned)) {
						print '<li>' . DOKU_LF;
						if((substr($nb_cleaned[0],0,7) == 'http://') || (substr($nb_cleaned[0],0,8) == 'https://')) {									
							print '<a href="' . $nb_cleaned[0] . '" >' . $nb_cleaned[1] . '</a>';
						} else {tpl_link(wl($nb_cleaned[0]),$nb_cleaned[1]); }
						print '<div class="border"></div></li>' . DOKU_LF;						
						
					}
				}
	print '</ul>' . DOKU_LF;
}	

function tpl_top_link() {	
	if(tpl_getConf('top_link')) {
   	print '<a href="#header" title="Back to top" rel="nofollow" accesskey="x" id="top_link"></a>' . DOKU_LF;
	}
}s

?>
