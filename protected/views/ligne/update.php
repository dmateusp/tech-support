<?php
/* @var $this LigneController */
/* @var $model Ligne */

$this->breadcrumbs=array(
	'Travail interne'=>array('travailinterne/index'),
	'Lignes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Modifier',
);

$this->menu=array(
	array('label'=>'Liste des lignes', 'url'=>array('index')),
	array('label'=>'Créer une ligne', 'url'=>array('create')),
	array('label'=>'Détails ligne', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gérer lignes', 'url'=>array('admin')),
);
?>

<h1>Modifier ligne numéro <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>