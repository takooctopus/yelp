<?php
/**
 * Created by PhpStorm.
 * User: Takoyaki
 * Date: 2016/9/29
 * Time: 17:42
 */

namespace App;

function human_filesize($bytes , $decimals = 2)
{
    $size = ['B','KB','MB','GB','TB','PB'];
    $factor = floor((strlen($bytes)-1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}

function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}