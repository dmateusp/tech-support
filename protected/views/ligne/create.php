<?php
/* @var $this LigneController */
/* @var $model Ligne */

$this->breadcrumbs=array(
	'Travail interne'=>array('travailinterne/index'),
	'Lignes'=>array('index'),
	'Créer',
);

$this->menu=array(
	array('label'=>'Liste des lignes', 'url'=>array('index')),
	array('label'=>'Gérer lignes', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logoligne.png" class="imgTitles"/>Créer une ligne</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>