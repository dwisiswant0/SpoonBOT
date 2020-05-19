<?php
require_once "src/SpoonBOT.php";

use dwisiswant0\SpoonBOT as SpoonBOT;

$token 	  = "<spoon_bot_token_here>";
$spoonBot = new SpoonBOT($token);
$follow   = $spoonBot->follow("210434105");

var_dump($follow);