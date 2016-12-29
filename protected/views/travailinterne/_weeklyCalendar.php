<?php
	//Get first and last day of this week
	$day = date('w');
	$day--;
	$week_start = date('Y-m-d 00:00:00', strtotime('-'.$day.' days'));
	$day_week_start = date('d', strtotime('-'.$day.' days'));

	$week_end = date('Y-m-d 23:59:59', strtotime('+'.(6-$day).' days'));
	$day_week_end = date('d', strtotime('+'.(6-$day).' days'));

	//CDB request
	$attribs = array();
	$criteria = new CDbCriteria(array('order'=>'dateDebut ASC'));
	$criteria->addBetweenCondition('dateDebut', $week_start, $week_end,'OR');
	$criteria->addBetweenCondition('dateFin', $week_start, $week_end,'OR');
	$weeklyData = Travailinterne::model()->findAllByAttributes($attribs, $criteria);

	$tableLine ='';
	foreach($weeklyData as $key=>$value){

		$timestamp=strtotime($value->dateDebut);
		$dayDeb = date('w', $timestamp);
		$weekDeb = date('W', $timestamp);
		$heureDeb = date('h\h m\m\i\n',$timestamp);

		$timestamp=strtotime($value->dateFin);
		$dayFin = date('w', $timestamp);
		$weekFin = date('W', $timestamp);
		$heureFin = date('h\h m\m\i\n',$timestamp);

		if(is_object($value->idligne0)){
			$ligneTel = $value->idligne0->name;
		}
		else
			$ligneTel = 'Aucune ligne demandée';
		

		$tableLine.='<tr><td>
			Evenement #'.$value->id.'<br/>
			Salle : '.$value->idsalle0->name.'<br/>
			Ligne : '.$ligneTel.'<br/>
			Description : '.$value->description.'

		</td>';
		for($i=1;$i<7;$i++){

			if($dayDeb==$i && $weekDeb==date('W')){
				$tableLine.='<td>Début à<br/>'.$heureDeb.'</td>';				
			}
			if($dayFin==$i && $weekFin==date('W')){
				$tableLine.='<td>Fin à<br/>'.$heureFin.'</td>';	
			}
			if( (!($dayDeb==$i && $weekDeb==date('W')) && !($dayFin==$i && $weekFin==date('W'))) ) {
				$tableLine.='<td/>';
			}
			
		}
		$tableLine.='</tr>';
	} 

?>
<h2>
	<?php echo 'Tableau imprimable des événements de la semaine du '.$day_week_start.'/'.date('m') ?>
</h2>
<table class="items" id="weeklyTable">
  <thead>
  <tr>
  	<th>Infos</th>
    <th>Lundi</th>
    <th>Mardi</th>
    <th>Mercredi</th>
    <th>Jeudi</th>
    <th>Vendredi</th>
    <th>Samedi</th>
    <th>Dimanche</th> 
  </tr>
  </thead>
  <tbody>
<?php
	echo $tableLine;
?>
</tbody>
</table>