<?php
/* @var $this DepartementController */
/* @var $model Departement */

$this->breadcrumbs=array(
	'Departements'=>array('index'),
	'Créer',
);

$this->menu=array(
	array('label'=>'Liste des départements', 'url'=>array('index')),
	array('label'=>'Gérer les départements', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Création de département</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>