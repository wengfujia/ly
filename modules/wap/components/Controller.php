<?php

namespace app\modules\wap\components;

use Yii;

class Controller extends \yii\web\Controller
{
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
