<?php
//Get Title
function getTitle()
{
    global $title;
    if (isset($title) && !empty($title)) {
        return $title;
    } else {
        return 'E-commerce';
    }
}
//Set Active 
function setActive($name)
{
    global $pagename;
    if (isset($pagename) && $pagename == $name) {
        return "active";
    }
    return false;
}
