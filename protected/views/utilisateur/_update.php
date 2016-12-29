<?php
/* @var $this UtilisateurController */
/* @var $model Utilisateur */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'utilisateur-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Les champs <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary($model);
	$model->password='';
	 ?>


	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model, 'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
	<p><i> Laissez le password vide si vous ne souhaitez pas le modifier</i></p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'initiale'); ?>
		<?php echo $form->textField($model,'initiale',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'initiale'); ?>
	</div>
	
	<div class="row">
	<?php 
	$selections =  array('U' => 'Utilisateur','T' => 'Service technique', 'C'=> 'Coordinateur', 'S'=>'Standard','A' => 'Administrateur');
		echo $form->labelEx($model,'type'); 
		echo $form->dropDownList($model,'type', $selections ); 
		echo $form->error($model,'type'); 
	?>
	</div>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'iddepartement'); 
		echo $form->dropDownList($model,'iddepartement', CHtml::listData( Departement::model()->findAll( array( 'order' => 'id' ) ), 'id', 'name' )); 
		echo $form->error($model,'iddepartement'); 
	?>
	</div>
	<div class="row buttons">

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Créer' : 'Sauvegarder'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->