<?php
/* @var $this HotelitemController */
/* @var $model Hotelitem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hotelitem-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<p class="note">Les champs avec une <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
	<?php 
		echo $form->labelEx($model,'idcategorie'); 
		echo $form->dropDownList($model,'idcategorie', CHtml::listData( Categorie::model()->findAll( array( 'order' => 'id' ) ), 'id', 'name' )); 
		echo $form->error($model,'idcategorie'); 
	?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
	        <?php echo $form->labelEx($model,'imagesource'); ?>
	        <?php echo CHtml::activeFileField($model, 'imagesource'); ?>  
	        <?php echo $form->error($model,'imagesource'); ?>
	</div>

	<div class="row">
	     <?php if($model->isNewRecord!='1'){
	     	echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.urlencode($model->imagesource),"imagesource",array("width"=>200));
	     	} ?>  
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->