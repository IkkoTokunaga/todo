<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function h ($h)
{
    return htmlspecialchars($h,ENT_QUOTES,"utf-8");
}