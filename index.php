<?php

const APP_PATH = __DIR__;

require_once 'Generate/GenerateImage.php';

$generate = new GenerateImage();

?>

<link href="styles.css" rel="stylesheet" />

<?= $generate->generate('test')->displayWorld() ?>