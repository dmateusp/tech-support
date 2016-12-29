<?php
/* @var $this UtilisateurController */
/* @var $model Utilisateur */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'utilisateur-profil-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>
	<?php
	    $this->pageTitle=Yii::app()->name . ' - Mon profil';
	    $this->breadcrumbs=array(
	    	'Mon profil',
	    );

		$oldPassword = $model->password;
		$model->password = '';
	?>

	<h1><img src="./css/logouser.png" class="imgTitles"/> Mon profil</h1>
	<p class="note">Les champs avec une <span class="required">*</span> sont requis.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo CHtml::encode($model->login); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'initiale'); ?>
		<?php echo CHtml::encode($model->initiale); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oldpassword'); ?>
		<?php echo $form->passwordField($model,'oldpassword'); ?>
		<?php echo $form->error($model,'oldpassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'newpassword'); ?>
		<?php echo $form->passwordField($model,'newpassword'); ?>
		<?php echo $form->error($model,'newpassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repeatpassword'); ?>
		<?php echo $form->passwordField($model,'repeatpassword'); ?>
		<?php echo $form->error($model,'repeatpassword'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Valider'); ?>
	</div>
	<?php
	    foreach(Yii::app()->user->getFlashes() as $key => $message) {
	        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	    }
	?>
<?php $this->endWidget(); ?>

</div><!-- form -->