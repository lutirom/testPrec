<?php

namespace app\models;

use yii\db\ActiveRecord;

class Document extends ActiveRecord
{

    public static function tableName()
    {
        return 't_precedent';
    }
}
