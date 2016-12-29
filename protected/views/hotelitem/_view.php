<?php
/* @var $this HotelitemController */
/* @var $data Hotelitem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idhotelitem')); ?>:</b>
	<?php echo CHtml::encode($data->idhotelitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->idhotelitem)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcategorie')); ?>:</b>
	<?php echo CHtml::encode($data->categorie0->name); ?>
	<br />

	<?php $data->initialeCreator=$data->getInitialeCreateur(); ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('initialeCreator')); ?>:</b>
	<?php echo CHtml::encode($data->initialeCreator); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('idcreator')); ?>:</b>
	<?php echo CHtml::encode($data->idcreator); ?>
	<br />
	<?php 

    if($data->imagesource!='' || $data->imagesource == null)
 		echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.urlencode($data->imagesource),"imagesource",array("height"=>200));
 	else
 		echo CHtml::link(CHtml::encode('Ajouter une image'), array('update', 'id'=>$data->idhotelitem));

 	?>  

	<br />


</div>