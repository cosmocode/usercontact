<?php
/**
 * DokuWiki Plugin usercontact (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Adrian Lang <lang@cosmocode.de>
 */

class action_plugin_usercontact extends DokuWiki_Action_Plugin
{

    function register(Doku_Event_Handler $controller)
    {
        global $JSINFO;
        $JSINFO['plugin']['usercontact']['users_namespace'] = $this->getConf('users_namespace');

        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'handle_ajax_call_unknown');
    }

    public function handle_ajax_call_unknown(Doku_Event $event, $param)
    {
        if ($event->data !== 'plugin_usercontact') {
            return;
        }

        $event->preventDefault();
        $event->stopPropagation();

        /** @var DokuWiki_Auth_Plugin $auth */
        global $auth;
        global $INPUT;

        $userdata = $auth->getUserData($INPUT->str('name'));
        if (empty($userdata)) {
            http_status(404, 'User not found');
            return;
        }
        $fields = explode(',', $this->getConf('fields'));
        $fields = array_map('trim', $fields);
        $fields = array_filter($fields);

        if (count($userdata) > 0) {
            echo '<ul>';
            foreach ($fields as $name) {
                if (!isset($userdata[$name])) {
                    continue;
                }

                $val = $userdata[$name];
                echo '<li class="userov_' . hsc($name) . '">';
                echo '<div class="li">';
                if ($name === 'mail') {
                    echo '<a href="mailto:' . obfuscate($val) . '" class="mail">' . obfuscate($val) . '</a>';
                } else {
                    echo hsc($val);
                }
                echo '</div></li>';
            }
            echo '</ul>';
        }
    }
}
