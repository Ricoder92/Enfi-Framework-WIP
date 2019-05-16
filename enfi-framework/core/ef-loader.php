<?php

################################################################################################################################################## 
### load shortcodes
##################################################################################################################################################

foreach(glob(get_template_directory() . "/editor/shortcodes/*/init.php") as $file){
    require_once $file;
}

################################################################################################################################################## 
### load widgets
##################################################################################################################################################

foreach(glob(get_template_directory() . "/editor/widgets/*/init.php") as $file){
    require_once $file;
}

?>
