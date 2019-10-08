<?php
require('../_app/Config.inc.php');
$string = filter_input(INPUT_POST, 'term', FILTER_DEFAULT);
echo Check::Name($string);