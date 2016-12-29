<?php

/**
 * This is the model class for table "utilisateur".
 *
 * The followings are the available columns in table 'utilisateur':
 * @property integer $idutilisateur
 * @property string $login
 * @property string $password
 * @property string $initiale
 *
 * The followings are the available model relations:
 * @property Technicien $technicien
 * @property Ticketsupport[] $ticketsupports
 * @property Ticketsupport[] $ticketsupports1
 * @property Utilisateurdemande $utilisateurdemande
 */
class Utilisateur extends CActiveRecord
{
	public $type;
	public $oldpassword;
	public $repeatpassword;
	public $newpassword;
	public $namedepartement;
	

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'utilisateur';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password', 'required', 'on' => 'create'),
			array('login, password, oldpassword, repeatpassword,initiale, iddepartement, namedepartement', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idutilisateur, login, password, initiale, type, iddepartement, namedepartement', 'safe', 'on'=>'search'),
			array('oldpassword, repeatpassword, newpassword', 'safe', 'on'=>'profil'),
			array('oldpassword, repeatpassword, newpassword', 'required', 'on'=>'profil'),
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
			'technicien' => array(self::HAS_ONE, 'Technicien', 'idtechnicien'),
			'ticketsupports' => array(self::HAS_MANY, 'Ticketsupport', 'idutilisateurDemande'),
			'ticketsupports1' => array(self::HAS_MANY, 'Ticketsupport', 'idtechnicien'),
			'utilisateurdemande' => array(self::HAS_ONE, 'Utilisateurdemande', 'idutilisateurDemande'),
			'utilisateurmodif' => array(self::HAS_ONE, 'Utilisateur', 'idutilisateurModif'),
			'objets' => array(self::HAS_MANY, 'Hotelitem', 'idcreator'),
			'utilisateurs0' => array(self::BELONGS_TO, 'Departement', 'iddepartement'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idutilisateur' => 'Idutilisateur',
			'login' => 'Login',
			'password' => 'Password',
			'initiale' => 'Initiale',
			'type' => 'Type',
			'oldpassword' => 'Ancien mot de passe',
			'repeatpassword' => 'Veuillez retaper votre mot de passe',
			'newpassword' => 'Nouveau mot de passe',
			'iddepartement' => 'Département',
			'namedepartement' => 'Nom du département'
		);
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
		$criteria->with = array('utilisateurs0');
		$criteria->compare('login',$this->login,true);
		$criteria->compare('initiale',$this->initiale,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('iddepartement',$this->iddepartement,true);
		$criteria->compare('utilisateurs0.name',$this->namedepartement, true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave() {
		if($this->password=='')
			unset($this->password);
		else{
	        $pass = sha1($this->password);
	        $this->password = $pass;
		}
        return true;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Utilisateur the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
