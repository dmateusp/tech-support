<?php
/* @var $this TicketsupportController */
/* @var $model Ticketsupport */

$this->breadcrumbs=array(
	'Demandes support'=>array('index'),
	$model->idticketSupport,
	'Modification',
);
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
$this->menu=array(
	array('label'=>'Liste des demandes support', 'url'=>array('index')),
	array('label'=>'Créer une demande support', 'url'=>array('create')),
	array('label'=>'Détail de la demande', 'url'=>array('view', 'id'=>$model->idticketSupport)),
	array('label'=>'Gérer les demandes support', 'url'=>array('admin') ,'visible'=> ($user['type'] =='A' || $user['type'] == 'T')),
);
?>

<h1>Modifier la demande support numéro <?php echo $model->idticketSupport; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>