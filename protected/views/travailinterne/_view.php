<?php
/* @var $this TravailinterneController */
/* @var $data Travailinterne */
?>

<div class="view">
<?php
	if(isset($data->dateDebut)){
	    $data->dateDebut = strtotime ($data->dateDebut);
	    $data->dateDebut = date ('d/m/Y H\h i\m', $data->dateDebut);
	}

	if(isset($data->dateFin)){
	    $data->dateFin = strtotime ($data->dateFin);
	    $data->dateFin = date ('d/m/Y H\h i\m', $data->dateFin);
	}

	if(isset($data->dateDemande)){
	    $data->dateDemande = strtotime ($data->dateDemande);
	    $data->dateDemande = date ('d/m/Y H\h i\m', $data->dateDemande);
	}
?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode('Initiales du demandeur'); ?>:</b>
	<?php echo CHtml::encode($data->idutilisateurDemande0->initiale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomClient')); ?>:</b>
	<?php echo CHtml::encode($data->nomClient); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dateDemande')); ?>:</b>
	<?php echo CHtml::encode($data->dateDemande); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('dateDebut')); ?>:</b>
	<?php echo CHtml::encode($data->dateDebut); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('dateFin')); ?>:</b>
	<?php echo CHtml::encode($data->dateFin); ?>
	<br />
</div>