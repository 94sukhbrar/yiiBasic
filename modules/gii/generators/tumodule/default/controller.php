<?php

/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "<?php\n";

?>

namespace <?= $generator->getControllerNamespace() ?>;

use app\base\TBaseController;

/**
 * Default controller for the `<?= $generator->moduleID ?>` module
 */
class DefaultController extends TController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
