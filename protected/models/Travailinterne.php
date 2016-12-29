<?php

/**
 * This is the model class for table "travailinterne".
 *
 * The followings are the available columns in table 'travailinterne':
 * @property integer $id
 * @property integer $idutilisateurDemande
 * @property string $dateDemande
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Utilisateur $idutilisateurDemande0
 */
class Travailinterne extends CActiveRecord
{
	public $initialeutilisateurDemande;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'travailinterne';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description,dateDebut,dateFin', 'required'),
			array('idutilisateurDemande, idsalle, idutilisateurModif', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>500),
			array('docsource', 'length', 'max'=>45),
			array('nomClient', 'length', 'max'=>55),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idutilisateurDemande, idutilisateurModif, dateDemande, description, idsalle,dateDebut,dateFin, docsource, initialeutilisateurDemande, idligne, nomClient', 'safe', 'on'=>'search'),
			array('docsource', 'file','types'=>'pdf, png, jpg, xls, xlsx, doc, docx', 'allowEmpty'=>true), // this will allow empty field when page is update (remember here i create scenario update)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idutilisateurDemande0' => array(self::BELONGS_TO, 'Utilisateur', 'idutilisateurDemande'),
			'idsalle0' => array(self::BELONGS_TO, 'Salle', 'idsalle'),
			'idligne0' => array(self::BELONGS_TO, 'Ligne', 'idligne'),
			'idutilisateurModif0' => array(self::BELONGS_TO, 'Utilisateur', 'idutilisateurModif'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Numéro de la demande',
			'idutilisateurDemande' => 'Demandeur',
			'dateDemande' => 'Date de la demande',
			'description' => 'Description',
			'idsalle' => 'Salle',
			'idligne' => 'Ligne demandée',
			'dateDebut' => 'Date du début de la réservation',
			'dateFin'=> 'Date de fin de la réservation',
			'dateModif' => 'Date de la dernière modification',
			'docsource' => 'Fichier joint',
			'idutilisateurModif' => 'Numéro de la dernière personne a avoir modifié la demande',
			'initialeutilisateurDemande'=> 'Initiales de l\'utilisateur demandeur',
			'nomClient' => 'Nom du client',
		);
	}/*
    protected function afterFind ()
    {
            // convert to display format
        if(isset($this->dateDebut)){
	        $this->dateDebut = strtotime ($this->dateDebut);
	        $this->dateDebut = date ('d/m/Y h \h m \m\i\n', $this->dateDebut);
		}

        if(isset($this->dateFin)){
	        $this->dateFin = strtotime ($this->dateFin);
	        $this->dateFin = date ('d/m/Y h \h m \m\i\n', $this->dateFin);
		}

        if(isset($this->dateDemande)){
	        $this->dateDemande = strtotime ($this->dateDemande);
	        $this->dateDemande = date ('d/m/Y h \h m \m\i\n', $this->dateDemande);
    	}
        parent::afterFind ();
    }*/

	public function getSalleSearch($data,$row){
		if(isset($data->idsalle0->name)){
			return $data->idsalle0->name;
		}
		else{
			return 'Pas de salle';
		}

	}

	public function getUtilisateurDemandeSearch($data,$row){
		return $data->idutilisateurDemande0->initiale;
	}

	public function getLigneSearch($data,$row){
		if(isset($data->idligne0->name)){
			return $data->idligne0->name;
		}
		else{
			return 'Aucune ligne demandée';
		}
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('idutilisateurDemande0');
		$criteria->compare('id',$this->id);
		$criteria->compare('idutilisateurDemande',$this->idutilisateurDemande);
		$criteria->compare('dateDemande',$this->dateDemande,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('idsalle',$this->idsalle,true);
		$criteria->compare('idligne',$this->idligne,true);
		$criteria->compare('dateDebut',$this->dateDebut,true);
		$criteria->compare('dateFin',$this->dateFin,true);
		$criteria->compare('docsource',$this->docsource,true);
		$criteria->compare('idutilisateurModif',$this->idutilisateurModif,true);
		$criteria->compare('idutilisateurDemande0.initiale',$this->initialeutilisateurDemande,true);
		$criteria->compare('nomClient',$this->nomClient,true);
		return new CActiveDataProvider($this, array(
		      'pagination'=>array(
		          'pageSize'=>10,
		      ),
			'criteria'=>$criteria,
			  'sort'=>array(
    			'defaultOrder'=>'id DESC',),

		));
	}
	public function beforeSave() {
		if($this->isNewRecord){
			$this->idutilisateurDemande=Yii::app()->user->id;
			// Change the line below to your timezone!
			date_default_timezone_set('Europe/Paris');
			$date = date('Y-m-d H:i:s', time());
			$this->dateDemande = $date; 
		}

		$this->idsalle = $_POST['idsalle'];
		if(isset($_POST['idligne']))
			$this->idligne = $_POST['idligne'];

		if($this->dateDebut<date("Y-m-d H:i:s")){
			Yii::app()->user->setFlash('error', "La date de début ne peut pas être antérieure à la date d'aujourd'hui");
			unset($this->dateFin);
			unset($this->description);
			return false;
		}
		if($this->dateDebut>$this->dateFin){
			Yii::app()->user->setFlash('error', "La date de début ne peut pas être supérieure à la date de fin");
			unset($this->dateDebut);
			unset($this->description);
			return false;
		}
		if(isset($_POST['checkBoxObj'])){
			if(!strpos($this->description,"Matériel spécifique coché : "))
				$this->description.="\r\n"."Matériel spécifique coché : ";
			foreach($_POST['checkBoxObj'] as $key=>$value){
				if(!strpos($this->description, $value))
					$this->description.=' - '.$value;
				if($key == 'Ligne téléphonique'){
					if($value==''){
						if($this->idligne==''){
							Yii::app()->user->setFlash('error', "Vous avez coché la demande de ligne téléphonique mais n'avez pas choisi de ligne (le choix n'est pas important il permet de vous attribuer une ligne précise). \r\nSi vous avez besoin d'une ligne téléphonique il faut néanmoins en selectionner une dans la liste.");
							unset($this->dateDebut);
							unset($this->dateFin);
							unset($this->description);
							return false;
						}
					}

				}
			}		
		}

        return true;
    }
	public function sendMail(){
		$ligneName = "Pas de ligne demandée";
		$nomClient = "Le client n'a pas été renseigné";
		if(isset($this->idligne0->name))
			$ligneName=$this->idligne0->name;
		if($this->nomClient!='')
			$nomClient=$this->nomClient;
		include_once('Mail.php');
		include_once('Mail/mime.php');
		$crlf = "\n";
		$from = "Support technique <support_technique@shgeneva.ch>";
		$to = "Service technique <tech_supp@shgeneva.ch>"; //PUT THE MAIL HERE tech_supp@shgeneva.ch
		$subject = "Annulation de la conférence numéro ".$this->id;

		$text = "Initiales de la personne qui a annulé la conférence : ".$this->idutilisateurDemande0->initiale."
		\n\nDescription : ".$this->description."
		\n\nLieu : ".$this->idsalle0->name."
		\n\nClient : ".$nomClient."
		\n\nDu : ".$this->dateDebut." Au : ".$this->dateFin."
		\n\nLigne : ".$ligneName;


		$html = '<html>
		<body>
		<p>
		Initiales de la personne qui a annulé la conférence : <b>'.$this->idutilisateurDemande0->initiale.'</b>
		</p>
		<p>
		Lieu : <b>'.$this->idsalle0->name.'</b>
		</p>
		<p>
		Description : <b>'.$this->description.'</b>
		</p>
		<p>
		Client : <b>'.$nomClient.'</b>
		</p>
		<p>
		Ligne : <b>'.$ligneName.'</b>
		</p>
		<p>
		Du : <b>'.$this->dateDebut.'</b>' .' Au : <b>'.$this->dateFin.'</b>
		</p>
		<a href="http://technique.shgeneva.ch/support_technique/">Aller à l\'application</a>
		</body>
		</html>';
		
		$host = "smtp.fastnet.ch";
		$username = "support_technique@shgeneva.ch";
		$password = "sh_linux2728";

		$mime = new Mail_mime(array('eol' => $crlf,
							"text_charset" => "utf-8",
                            "html_charset" => "utf-8"));
		$mime->setTXTBody($text);
		$mime->setHTMLBody($html);

		$body = $mime->get();
		$headers = array ('From' => $from,   'To' => $to,   'Subject' => $subject);
		foreach ($headers as $name => $value){
		    $headers[$name] = $mime->encodeHeader($name, $value, "utf-8",
		                                                           "quoted-printable");
		}
		$hdrs = $mime->headers($headers);

		$smtp=Mail::factory('smtp',   array ('host' => $host,     'auth' => true,     'username' => $username, 'password' => $password, 'Content-Type: text/html; charset=UTF-8'));
		$mail = $smtp->send($to, $hdrs, $body);

		if (PEAR::isError($mail)) {
		  echo("<p>" . $mail->getMessage() . "</p>");
		}

	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Travailinterne the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
