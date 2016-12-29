<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<!--DROPDOWNCHECKLIST-->
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-1.8.13.custom.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<?php
//DROPDOWNCHECKLIST
/*
$cs = Yii::app()->clientScript;

$cs->scriptMap = array(
'jquery.js' => Yii::app()->request->baseUrl . '/js/jquery-ui.min.js',
'jquery-ui.min.js' => Yii::app()->request->baseUrl . '/js/jquery-ui.min.js',
);

$cs->registerScriptFile('jquery-ui.min.js');
*/
?>

	<div id="header">
		<div id="logo"><a href="./index.php?r=site/index"><?php echo "<img id='logo' src=\"./css/web_hi_res_512.png\">"; ?></a></div>
	</div><!-- header -->
<?php
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
?>
	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'activeCssClass'=>'active',
			'activateParents'=>true,
			'encodeLabel' => false,
			'items'=>array(
				array('label'=>'Accueil', 'url'=>array('/site/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label' => 'Demandes au service technique &darr;',
					  'url' => array('ticketsupport/index'),
					  'visible'=> !Yii::app()->user->isGuest,
				      'linkOptions'=>array('id'=>'menuObjets'),
				      'itemOptions'=>array('id'=>'itemObjets'),
				      'items'=>array(
				        array('label'=>'Demande de support', 'url'=>array('/ticketsupport/index')),
				        array('label'=>'Demande de travail interne', 'url'=>array('/travailinterne/index'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A' || $user['type'] == 'C'),
					  ),
					 ),
				array('label' => 'Calendrier d\'utilisation des salles', 'url' => array('travailinterne/calendar'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='S' || $user['type'] == 'U'),
				array('label' => 'Calendrier des lignes téléphoniques', 'url' => array('ligne/calendar'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='S' || $user['type'] == 'U'),
				 array(
				      'label'=>'Gestion objets &darr;',
				      'url'=>array('/hotelitem/index'),
				      'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A',
				    ),
				 array(
				      'label'=>'Gestion utilisateurs &darr;',
				      'url'=>array('/utilisateur/index'),
				      'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A',
				    ),
				array('label' => 'Stats', 'url' => array('site/stats'), 'visible'=> !Yii::app()->user->isGuest && $user['type'] =='A'),
				array('label'=>'Mon profil', 'url'=>array('/site/profil'), 'visible'=>!Yii::app()->user->isGuest,  'itemOptions'=>array('id'=>'login')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'itemOptions'=>array('id'=>'login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest, 'itemOptions'=>array('id'=>'login'))
			),
		)); ?>
	</div><!-- mainmenu -->
	<div class="centerContent">
		<div class="container" id="page">
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>

			<?php echo $content; ?>

			<div class="clear"></div>

			<div class="noprint" id="footer">
				https://github.com/dmateusp/

			</div><!-- footer -->

		</div><!-- page -->
	</div>
</body>
</html>
