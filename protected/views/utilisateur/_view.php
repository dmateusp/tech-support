<?php
/* @var $this UtilisateurController */
/* @var $data Utilisateur */
?>

<div class="view">
<?php
	if(!$data->utilisateurs0==null){
		$data->namedepartement=$data->utilisateurs0->name;		
	}
	else{
		$data->namedepartement='Pas de département';
	}
?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('login')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->login), array('view', 'id'=>$data->idutilisateur)); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('initiale')); ?>:</b>
	<?php echo CHtml::encode($data->initiale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('namedepartement')); ?>:</b>
	<?php echo CHtml::encode($data->namedepartement); ?>
	<br />

</div>