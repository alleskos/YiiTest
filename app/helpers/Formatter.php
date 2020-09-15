<?php

namespace app\helpers;

use yii\i18n\Formatter as BaseFormatter;

class Formatter extends BaseFormatter
{

    public function asVideoDuration($value)
    {
        $h = (int) ($value / 3600);
        $m = (int) ($value / 60 % 60);
        $s = (int) ($value % 60);
        if ($h > 0) {
            return sprintf("%d:%02d:%02d", $h, $m, $s);
        }
        return sprintf("%02d:%02d", $m, $s);
    }

}
