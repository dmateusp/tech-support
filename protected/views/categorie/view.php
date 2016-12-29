<?php
/* @var $this CategorieController */
/* @var $model Categorie */

$this->breadcrumbs=array(
	'Catégories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Liste des catégories', 'url'=>array('index')),
	array('label'=>'Créer une catégorie', 'url'=>array('create')),
	array('label'=>'Modifier cette catégorie', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Supprimer cette catégorie', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gérer catégories', 'url'=>array('admin')),
);
?>

<h1><img src="./css/logofolder.png" class="imgTitles"/>Détails catégorie numéro <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
