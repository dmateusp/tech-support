<?php
/* @var $this SalleController */
/* @var $model Salle */

$this->breadcrumbs=array(
    'Travail interne'=>array('travailinterne/index'),
	'Salles'=>array('index'),
	'Créer',
);

$this->menu=array(
	array('label'=>'Liste des salles', 'url'=>array('index')),
	array('label'=>'Gérer les salles', 'url'=>array('admin')),
);
?>

<h1>Créer une salle</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>