<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Navigation</title>
    <style>
        ul {
            list-style-type: none;
            padding-left: 20px;
        }
        ul ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<?php
$paths = array(
    'documents' => array(
        'report1' => array(),
        'report2' => array()
    ),
    'images' => array(
        'photos' => array()
    ),
    'videos' => array()
);

function renderMenu($menu) {
    echo '<ul>';
    foreach ($menu as $key => $value) {
        echo '<li>' . $key;
        if (count($value) > 0) {
            renderMenu($value);
        }
        echo '</li>';
    }
    echo '</ul>';
}

// Render the menu
echo '<h2>File Navigation</h2>';
renderMenu($paths);
?>

</body>
</html>
