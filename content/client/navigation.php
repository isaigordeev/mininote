<?php

$paths = array(
//          'Create Folder' => null,
    'documents' => array(
        'report1' => array(),
        'report2' => array(
            'report3' => array()
        )
    ),
    'images' => array(
        'photos' => array()
    ),
    'videos' => array(),
    'file1',
    'note2'
);

function renderMenu($menu) {
    echo '<ul>';
    foreach ($menu as $key => $value) {
        if (is_array($value)) {
            echo '<li><a href="#">' . $key. '</a>';
            if(count($value) > 0) {
                renderMenu($value);
            } else {
                echo "";
            }
        } else {
            echo '<li><a href="#">' . $value . '</a>';
        }
        echo '</li>';
    }
    echo '</ul>';
}

renderMenu($paths);
?>

