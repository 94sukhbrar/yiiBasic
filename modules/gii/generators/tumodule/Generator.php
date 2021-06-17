<?php

namespace app\modules\gii\generators\tumodule;

use yii\gii\CodeFile;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;

/**
 * This generator will generate the skeleton code needed by a module.
 *
 * @property string $controllerNamespace The controller namespace of the module. This property is read-only.
 * @property boolean $modulePath The directory that contains the module class. This property is read-only.
 *          
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\module\Generator
{

    /**
     *
     * @inheritdoc
     */
    public function getName()
    {
        return 'TuGii Module Generator';
    }

    /**
     *
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator helps you to generate the skeleton code needed by a Yii module.';
    }

    public function beforeValidate()
    {
        if (empty($this->moduleClass)) {
            $this->moduleClass = str_replace('moduleName', $this->moduleID, 'app\\modules\\moduleName\\Module');
        }
        return parent::beforeValidate();
    }

    /**
     *
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->getModulePath();
        $files[] = new CodeFile($modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php', $this->render("module.php"));
        $files[] = new CodeFile($modulePath . '/controllers/DefaultController.php', $this->render("controller.php"));
        $files[] = new CodeFile($modulePath . '/views/default/index.php', $this->render("view.php"));

        $files[] = new CodeFile($modulePath . '/codeception.yml', $this->render("codeception.yml"));

        $templatePath = $this->getTemplatePath() . '/tests';
        $fileList = FileHelper::findFiles($templatePath);

        foreach ($fileList as $file) {

            if (is_file($file)) {

                $data = file_get_contents($file);

                $data = preg_replace('/emailreader/', $this->moduleID, $data);

                $fileOut = str_replace($this->getTemplatePath() . '/', $modulePath . '/', $file);

                $files[] = new CodeFile($fileOut, $data);
            }
        }

        return $files;
    }
}
