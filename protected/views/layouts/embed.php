<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/embedHeader'); ?>
<?php
$baseUrl = '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/'; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'jquery.min.js');
?>
<div>
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>

<?php $this->endContent(); ?>