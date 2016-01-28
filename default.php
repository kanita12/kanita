<?php
$array = array("1","2","3");
?>
{foreach from=$array item="name"}
        <li>{$name}</li>
{/foreach}