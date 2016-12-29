<?php
/* @var $this TravailinterneController */
/* @var $model Travailinterne */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idutilisateurDemande'); ?>
		<?php echo $form->textField($model,'idutilisateurDemande'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dateDemande'); ?>
		<?php echo $form->textField($model,'dateDemande'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->