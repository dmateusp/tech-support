<?php
/* @var $this CategorieController */
/* @var $model Categorie */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Modifier',
);

$this->menu=array(
	array('label'=>'Liste des catégories', 'url'=>array('index')),
	array('label'=>'Créer une catégorie', 'url'=>array('create')),
	array('label'=>'Voir catégorie', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gérer catégories', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Modifier catégorie numéro <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>