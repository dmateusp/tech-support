<?php
/* @var $this SiteController */
if(Yii::app()->user->isGuest){
	header('Location: ./index.php?r=site/login');
}
$this->pageTitle=Yii::app()->name;
?>
<?php
	$user = Yii::app()->db->createCommand()
    ->select('type')
    ->from('utilisateur')
    ->where('idutilisateur=:id', array(':id'=>Yii::app()->user->id))
    ->queryRow();
    //$user['type']
?>

<h1> <img src="./css/logoexclamation.png" class="imgTitles"/>Infos :<i></i></h1>
	<table>
		
		<tr>
			<h3>Pannes et problèmes techniques :
					<a href="./index.php?r=ticketsupport/create">
						ICI
					</a>
			<p>
			<span style="color:grey">
			<i>Exemple : une lampe ne marche plus et doit être changée </i>
			</span>
			</p>
			</h3>
		</tr>
		<tr>
			<h3>
				Demande de travail interne :
				
					<a href="./index.php?r=travailinterne/create">
						ICI
					</a>
			<p>
			<span style="color:grey">
			<i>Exemple : il faut installer du matériel pour une conférence </i>
			</span>	
			</p>
			</h3>
		</tr>
	</table>