<?php
/**
 * DokuWiki Plugin usercontact (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'action.php');

class action_plugin_usercontact extends DokuWiki_Action_Plugin {

    function getInfo() {
        return confToHash(dirname(__FILE__).'/plugin.info.txt');
    }

    function register(&$controller) {

       $controller->register_hook('AJAX_CALL_UNKNOWN', 'FIXME', $this, 'handle_ajax_call_unknown');
   
    }

    function handle_ajax_call_unknown(&$event, $param) { }

}

// vim:ts=4:sw=4:et:enc=utf-8:
