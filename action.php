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
        global $JSINFO;
        $JSINFO['plugin']['usercontact']['users_namespace'] = $this->getConf('users_namespace');

        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'handle_ajax');
    }

    /**
     * Handle AJAX request
     */
    function handle_ajax($event) {
        $ajax = $this->loadHelper('ajaxloader', true);
        if (!$ajax || !$ajax->isLoader('usercontact', $event->data)) {
            return;
        }

        $call = $ajax->handleLoad();
        global $auth;
        $userdata = $auth->getUserData($call['name']);

        $fields = explode(',',$this->getConf('fields'));
        $fields = array_map('trim',$fields);
        $fields = array_filter($fields);

        if (count($userdata) > 0) {
            echo '<ul>';
            foreach($fields as $name){
                if(!isset($userdata[$name])) continue;

                $val = $userdata[$name];
                echo '<li class="userov_'.hsc($name).'">';
                echo '<div class="li">';
                if($name == 'mail'){
                    echo '<a href="mailto:'.obfuscate($val).'" class="mail">'.obfuscate($val).'</a>';
                }else{
                    echo hsc($val);
                }
                echo '</div></li>';
            }
            echo '</ul>';
        }

        $event->stopPropagation();
        $event->preventDefault();
    }
}

// vim:ts=4:sw=4:et:enc=utf-8:
