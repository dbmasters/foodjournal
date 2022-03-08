<?php
$dir = new DirectoryIterator(dirname(__FILE__));
foreach ($dir as $fileinfo) 
{
	if (!$fileinfo->isDot() && $fileinfo->getFilename() != "Load.php") 
	{
        include($fileinfo->getFilename());
    }
}