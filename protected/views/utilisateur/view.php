<?php
/* @var $this UtilisateurController */
/* @var $model Utilisateur */

$this->breadcrumbs=array(
	'Utilisateurs'=>array('index'),
	$model->idutilisateur,
);
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
$this->menu=array(
	array('label'=>'Liste utilisateurs', 'url'=>array('index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A'),
	array('label'=>'Créer utilisateurs', 'url'=>array('create'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A'),
	array('label'=>'Modifier cet utilisateur', 'url'=>array('update', 'id'=>$model->idutilisateur), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A'),
	array('label'=>'Gérer utilisateurs', 'url'=>array('admin'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A'),
	array('label'=>'Supprimer cet utilisateur', 'url'=>'#','visible'=> !Yii::app()->user->isGuest && $user['type'] =='A', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idutilisateur),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Utilisateur <?php echo $model->initiale; ?></h1>
<?php
	if(!$model->utilisateurs0==null)
		$model->namedepartement=$model->utilisateurs0->name;
	else
		$model->namedepartement='Pas de département';
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idutilisateur',
		'login',
		'initiale',
		'type',
		'namedepartement'
	),
)); 
?>
