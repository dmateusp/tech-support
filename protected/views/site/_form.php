<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticketsupport-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Les champs avec une <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lieu'); ?>
		<?php echo $form->textField($model,'lieu',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'lieu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'commentaire'); ?>
		<?php echo $form->textField($model,'commentaire',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'commentaire'); ?>
	</div>



	<div class="row">
 <?php 
	$opts = CHtml::listData(Hotelitem::model()->findAll(),'idhotelitem','name');

	$options = array(
		'ajax' => array(
		'type'=>'POST', //request type
		'url'=>CController::createUrl('ticketsupport/dynamicimages'), //url to call.
		//Style: CController::createUrl('currentController/methodToCall')
		'update'=>'#img', //selector to update
		//'data'=>'js:javascript statement' 
		//leave out the data key to pass all form values through
		)); 
	echo $form->labelEx($model,'Type objet');
	echo $form->dropDownList($model,'idhotelitem',$opts,$options,array('empty'=>'(Choisissez un objet)')
	);    
 ?>
	</div>

	<div class="row" id="img">
     <?php
     	echo CHtml::tag('img'),'Selectionnez un objet';
 	 ?>  
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Créer' : 'Sauvegarder'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->