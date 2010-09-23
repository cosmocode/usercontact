<?php
/**
 * DokuWiki Plugin usercontact (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'action.php');

class action_plugin_usercontact extends DokuWiki_Action_Plugin {

    function register(&$controller) {
        global $JSINFO;
        $JSINFO['plugin']['usercontact']['users_namespace'] = $this->getConf('users_namespace');
    }
}

// vim:ts=4:sw=4:et:enc=utf-8:
