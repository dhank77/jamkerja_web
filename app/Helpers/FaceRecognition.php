<?php

use App\Services\Recognize\Recognize;
use App\Services\Train\Train;
use App\Services\Compare\Compare;


function train_image($nip)
{
    $train = new Train();
    return $train->execute($nip);
}

function recog_image($nip, $image)
{
    $recognize = new Recognize();
    return $recognize->execute($nip, $image);
}

function compare_images($image1, $image2)
{
    $compare = new Compare();
    return $compare->execute($image1, $image2);
}