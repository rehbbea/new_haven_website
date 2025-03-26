<?php
$file = '/var/www/html/newsite/wp-content/themes/eldritch/includes/sidebar/edgt-custom-sidebar.php';
$content = file_get_contents($file);

// Check if we need to add the $title property
if (strpos($content, 'class EldritchEdgeSidebar {') \!== false && 
    strpos($content, 'public $title;') === false) {
    
    $old = 'class EldritchEdgeSidebar {';
    $new = "class EldritchEdgeSidebar {\n\t/**\n\t * @var string\n\t */\n\tpublic \$title;";
    
    $fixed_content = str_replace($old, $new, $content);
    file_put_contents($file, $fixed_content);
    echo "Added title property to EldritchEdgeSidebar class.\n";
}
