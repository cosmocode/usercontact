<?php
global $auth;
$userdata = $auth->getUserData($_POST['name']);

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
