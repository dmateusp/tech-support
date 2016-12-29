<?php
/* @var $this CategorieController */
/* @var $model Categorie */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Créer',
);

$this->menu=array(
	array('label'=>'Liste des catégories', 'url'=>array('index')),
	array('label'=>'Gérer les catégories', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Créer une catégorie</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>