<?php
namespace app\modules\gii;

use yii\helpers\Html;


class Module extends \yii\gii\Module
{

    public $controllerNamespace = 'app\modules\gii\controllers';

    public function init()
    {
        parent::init();
        
        // custom initialization code goes here
    }

    protected function coreGenerators()
    {
        $local = [
            'tumodel' => [
                'class' => 'app\modules\gii\generators\tumodel\Generator'
            ],
            'tucrud' => [
                'class' => 'app\modules\gii\generators\tucrud\Generator'
            ],         
           
           
            'tumodule' => [
                'class' => 'app\modules\gii\generators\tumodule\Generator'
            ]
        
        ];
        
        return array_merge($local, parent::coreGenerators());
    }
    
    public static function logo()
    {
        return Html::img(base64_decode('aHR0cDovL3lpaS5ndXJ1L3lpaTI='), ['class' => 'img-responsive','alt' => 'Image']);
    }
}
