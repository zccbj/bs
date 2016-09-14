<?php
ini_set("display_errors", "On"); 
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL);
require "./framework/Framework.class.php";
Framework::run();

