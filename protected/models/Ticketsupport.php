<?php

/**
 * This is the model class for table "ticketsupport".
 *
 * The followings are the available columns in table 'ticketsupport':
 * @property integer $idticketSupport
 * @property string $statut
 * @property string $description
 * @property string $lieu
 * @property string $commentaire
 * @property string $dateDemande
 * @property string $datePriseEnCharge
 * @property string $dateClotureTicket
 * @property integer $idutilisateurDemande
 * @property integer $idtechnicien
 *
 * The followings are the available model relations:
 * @property Utilisateur $idutilisateurDemande0
 * @property Utilisateur $idtechnicien0
 */
class Ticketsupport extends CActiveRecord
{
	public $initialeDemandeur;
	public $initialeTechnicien;
	public $img;
	public $nameitem;
	public $namedepartement;

	public function getPathImg(){
		$criteria=new CDbCriteria;
		$criteria->select='imagesource';  // only select the 'title' column
		$criteria->condition='idhotelitem=:idhotelitem';
		$criteria->params=array(':idhotelitem'=>$_POST['idhotelitem']);
		$hotelitem=Hotelitem::model()->find($criteria); // $params is not needed
		return $hotelitem->imagesource;
	}

	public function getInitialeDemandeur(){
		$criteria = new CDbCriteria();
		$criteria->condition = 'idutilisateurDemande=:idutilisateur';
		$criteria->params = array(':idutilisateur'=>$this->idutilisateurDemande);
		if(!is_null($this->with('idutilisateurDemande0:ticketsupports')->find($criteria)))
			return $this->with('idutilisateurDemande0:ticketsupports')->find($criteria)->getRelated('idutilisateurDemande0')->initiale;
		else
			return 'En attente';
	}
	public function getNameDepartementSearch($data,$row){
		$data->namedepartement=$data->idutilisateurDemande0->utilisateurs0->name;
		return $data->namedepartement;
	}

	public function getInitialeTechnicien(){
		$criteria = new CDbCriteria();
		$criteria->condition = 'idtechnicien=:idutilisateur';
		$criteria->params = array(':idutilisateur'=>$this->idtechnicien);
		if(!is_null($this->with('idtechnicien0:ticketsupports')->find($criteria)))
			return $this->with('idtechnicien0:ticketsupports')->find($criteria)->getRelated('idtechnicien0')->initiale;
		else
			return null;
	}
	public function getValueStatut(){
		switch($this->statut){
			case 0: return "créé";
				break;
			case 1: return "pris en charge";
				break;
			case 2: return "en attente";
				break;
			case 3: return "clôturé";
				break;
			default: return "";
		}
	}
	public function getValueStatutSearch($data,$row){
		switch($data->statut){
			case 0: return "créé";
				break;
			case 1: return "pris en charge";
				break;
			case 2: return "en attente";
				break;
			case 3: return "clôturé";
				break;
			default: return "";
		}
	}
	public function getInitialeTechnicienSearch($data,$row){
		return $data->getInitialeTechnicien();
	}
	public function getNameItemSearch($data,$row){
		return Hotelitem::model()->findByPk($data->idhotelitem)->name;
	}
	public function sendMail(){
		include_once('Mail.php');
		include_once('Mail/mime.php');
		$crlf = "\n";
		$from = "Support technique <support_technique@shgeneva.ch>";
		$to = "Service technique <it@shgeneva.ch>"; //PUT THE MAIL HERE
		$subject = "Demande numéro ".$this->idticketSupport;

		$text = "Initiales demandeur".$this->getInitialeDemandeur()."
		\n\nDescription : ".$this->description."
		\n\nLieu : ".$this->lieu."
		\n\nObjet : ".Hotelitem::model()->findByPk($this->idhotelitem)->name;

		//JOKE----------------------------------------------
		$text .= "\n\nJOYEUX ANNIV";
		//JOKE----------------------------------------------

		$html = '<html>
		<body>
		<p>
		Initiales demandeur : <b>'.$this->getInitialeDemandeur().'</b>
		</p>
		<p>
		Lieu : <b>'.$this->lieu.'</b>
		</p>
		<p>
		Objet : <b>'.Hotelitem::model()->findByPk($this->idhotelitem)->name.'</b>
		</p>
		<p>
		Description : <b>'.$this->description.'</b>
		</p>
		<a href="http://212.243.48.10/support_technique/">Aller à l\'application</a>
		</body>
		</html>';

		//JOKE----------------------------------------------
		$html .= "<p>JOYEUX ANNIV</p>
				<img src='http://www.footmercato.net/images/a/pogba-poursuit-son-ascension_118140.jpg'/>";
		//JOKE----------------------------------------------
		
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticketsupport';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statut, description, lieu', 'required'),
			array('idutilisateurDemande, idtechnicien, idhotelitem', 'numerical', 'integerOnly'=>true),
			array('description, lieu', 'length', 'max'=>45),
			array('statut', 'length', 'max'=>2),
			array('commentaire', 'length', 'max'=>250),
			array('dateDemande, datePriseEnCharge, dateClotureTicket, initialeTechnicien', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idticketSupport, statut, description, lieu, commentaire, dateDemande, datePriseEnCharge, dateClotureTicket, idutilisateurDemande, idtechnicien, initialeTechnicien, namedepartement, nameitem', 'safe', 'on'=>'search'),
		
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
			'idtechnicien0' => array(self::BELONGS_TO, 'Utilisateur', 'idtechnicien'),
			'idhotelitem0' => array(self::BELONGS_TO, 'Hotelitem', 'idhotelitem'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idticketSupport' => 'Numéro de la demande',
			'statut' => 'Statut',
			'description' => 'Description',
			'lieu' => 'Lieu',
			'commentaire' => 'Commentaire',
			'dateDemande' => 'Date de la demande',
			'datePriseEnCharge' => 'Date de la prise en charge',
			'dateClotureTicket' => 'Date de la cloture de la demande',
			'debDateAttente' => 'Date de mise en attente de la demande',
			'finDateAttente' => 'Date de sortie d\'attente de la demande',
			'idutilisateurDemande' => 'Numéro de l\'utilisateur qui a effectué la demande',
			'idtechnicien' => 'Numéro du technicien qui a pris en charge la demande',
			'initialeDemandeur' => 'Initiales du créateur de la demande',
			'initialeTechnicien' => 'Initiales technicien',
			'nameitem' => 'Nom de l\'objet concerné',
			'namedepartement' => 'Nom du département'
		);
	}
	public function beforeSave() {
		if($this->isNewRecord){
			if(isset($_POST['idhotelitem'])){
				if($_POST['idhotelitem']!='' && !is_null($_POST['idhotelitem'])){
					$this->idhotelitem=$_POST['idhotelitem'];
					return true;
				}
				else{
					Yii::app()->user->setFlash("-error", "Choisissez un objet, s'il n'existe pas choisissez la catégore Autres et l'objet Autres");
					return false;
				}
			}
			else{
				Yii::app()->user->setFlash("-error", "Choisissez un objet, s'il n'existe pas choisissez la catégore Autres et l'objet Autres");
				return false;
			}			
		}
		else{
			return true;
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
	 * @return CActiveDataProvider the hot provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
		$criteria->with = array('idtechnicien0', 'idutilisateurDemande0','idhotelitem0');
		$criteria->compare('idticketSupport',$this->idticketSupport);
		$criteria->compare('statut',$this->statut,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('lieu',$this->lieu,true);
		$criteria->compare('commentaire',$this->commentaire,true);
		$criteria->compare('dateDemande',$this->dateDemande,true);
		$criteria->compare('datePriseEnCharge',$this->datePriseEnCharge,true);
		$criteria->compare('dateClotureTicket',$this->dateClotureTicket,true);
		$criteria->compare('idutilisateurDemande',$this->idutilisateurDemande);
		$criteria->compare('idtechnicien',$this->idtechnicien);
		$criteria->compare('idhotelitem',$this->idhotelitem);
		$criteria->compare('idutilisateurDemande0.iddepartement',$this->namedepartement, true);
		$criteria->compare('idtechnicien0.initiale',$this->initialeTechnicien, true);
		$criteria->compare('idhotelitem0.name',$this->nameitem, true);
		return new CActiveDataProvider($this, array(
		      'pagination'=>array(
		          'pageSize'=>20,
		      ),
			'criteria'=>$criteria,
			  'sort'=>array(
    			'defaultOrder'=>'idticketSupport DESC',),

		));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ticketsupport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
