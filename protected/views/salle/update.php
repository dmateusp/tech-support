<?php
/* @var $this SalleController */
/* @var $model Salle */

$this->breadcrumbs=array(
	'Salles'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Modifier',
);

$this->menu=array(
	array('label'=>'Liste des salles', 'url'=>array('index')),
	array('label'=>'Créer des salles', 'url'=>array('create')),
	array('label'=>'Détails de cette salle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gérer les salles', 'url'=>array('admin')),
);
?>

<h1>Update Salle <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>