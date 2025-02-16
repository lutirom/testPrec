<?php

namespace app\models;

use yii\base\Model;

class DocType extends Model
{
    private static $type = [
        1 => 'Постанова',
        2 => 'Рішення',
        3 => 'Ухвала',
        4 => 'Окрема ухвала',
        5 => 'Окрема думка судді',
        6 => "Роз'яснення",
        7 => 'Постанова Пленуму',
        8 => 'Iнформацiйнi листи',
        9 => 'Вісник',
        10 => 'Правовой висновок',
        11 => 'Узагальнення судової практики',
        12 => 'Документ',
        13 => 'Окрема думка',
        14 => 'Висновки',
        15 => 'Ухвала2',
        16 => 'Постанова2',
        17 => 'Рішення2',
        18 => 'Вирок',
        19 => 'Дайджест',
        20 => 'Вирок2',
    ];

    private static $judgmentType = [
        1 => 'ЦПК',
        2 => 'ГПК',
        3 => 'КПК',
        4 => 'КАС',
        5 => 'Інші',
        6 => "КУпАП",
    ];

    public static function getType($id) {
        foreach (self::$type as $key => $val) {
            if ($key === $id) {
                return $val;
            }
        }
    }

    public static function getJudgmentType($id) {
        foreach (self::$judgmentType as $key => $val) {
            if ($key === $id) {
                return $val;
            }
        }
    }
}