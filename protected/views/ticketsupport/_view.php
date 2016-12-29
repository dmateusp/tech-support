<?php
/* @var $this TicketsupportController */
/* @var $data Ticketsupport */
?>

<?php 
	if($data->statut==0){
		echo CHtml::tag('div',array("style"=>"background-color: #ff8686;",
							"class"=>"view"));
	}
	if($data->statut==1){
		echo CHtml::tag('div',array("style"=>"background-color: #feff5f;",
							"class"=>"view"));
	}
	if($data->statut==2){
		echo CHtml::tag('div',array("style"=>"background-color: #B0E0E6;",
							"class"=>"view"));
	}
	if($data->statut==3){
		echo CHtml::tag('div',array("style"=>"background-color: #8aff5b;",
							"class"=>"view"));
	}
	if($data->commentaire=='')
		$data->commentaire='Aucun commentaire';
?>
    <?php
	if(isset($data->dateDemande)){
	$data->dateDemande = strtotime ($data->dateDemande);
	$data->dateDemande = date ('d/m/Y H\h i\m', $data->dateDemande);
	}
     $data->nameitem=Hotelitem::model()->findByPk($data->idhotelitem)->name; ?>
		    
	<b><?php echo CHtml::encode("Numéro"); ?>:</b>
	<?php echo CHtml::encode($data->idticketSupport); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statut')); ?>:</b>
	<?php echo CHtml::encode($data->getValueStatut()); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nameitem')); ?>:</b>
	<?php echo CHtml::encode($data->nameitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lieu')); ?>:</b>
	<?php echo CHtml::encode($data->lieu); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('commentaire')); ?>:</b>
	<?php echo CHtml::encode($data->commentaire); ?>
	<br />
	<b><?php echo CHtml::encode("Date de la demande"); ?>:</b>
	<?php echo CHtml::encode($data->dateDemande); ?>

	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('commentaire')); ?>:</b>
	<?php echo CHtml::encode($data->commentaire); ?>
	<br />



	<b><?php echo CHtml::encode("Date de la prise en charge");?>:</b>
	<?php 
	if($data->datePriseEnCharge=="")
		echo "En attente";
	else
		echo CHtml::encode($data->datePriseEnCharge); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('dateClotureTicket')); ?>:</b>
	<?php echo CHtml::encode($data->dateClotureTicket); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idutilisateurDemande')); ?>:</b>
	<?php echo CHtml::encode($data->idutilisateurDemande); ?>
	<br />
*/	?>

<?php
	$data->initialeDemandeur=$data->getInitialeDemandeur();
	$data->initialeTechnicien=$data->getInitialeTechnicien();
?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('initialeDemandeur')); ?>:</b>
	<?php echo CHtml::encode($data->initialeDemandeur); 
	?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('initialeTechnicien')); ?>:</b>
	<?php echo CHtml::encode($data->initialeTechnicien); 
	?>
	<br />
-->
</div>

	