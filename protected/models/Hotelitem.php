<?php

/**
 * This is the model class for table "hotelitem".
 *
 * The followings are the available columns in table 'hotelitem':
 * @property integer $idhotelitem
 * @property string $name
 * @property string $imagesource
 * @property integer $idcreator
 *
 * The followings are the available model relations:
 * @property Utilisateur $idcreator0
 */
class Hotelitem extends CActiveRecord
{
	public $initialeCreator;
	public $checkBoxObj;
	public function getNameCategorieSearch($data,$row){
		return $data->categorie0->name;
	}
	public function getInitialeCreateur(){
		/*
		$criteria = new CDbCriteria();
		$criteria->condition = 'idcreator=:idutilisateur';
		$criteria->params = array(':idutilisateur'=>$this->idcreator);
		if(!is_null($this->with('idcreator0:hotelitem')->find($criteria)))
			return $this->with('idcreator0:hotelitem')->find($criteria)->getRelated('idcreator0')->initiale;
		else*/
			return 'Non défini';
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hotelitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idcreator', 'required'),
			array('name', 'required'),
			array('idcreator,idcategorie', 'numerical', 'integerOnly'=>true),
			array('name, imagesource', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idhotelitem, name, imagesource, idcreator, idcategorie', 'safe', 'on'=>'search'),
			array('imagesource', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true), // this will allow empty field when page is update (remember here i create scenario update)
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
			'idcreator0' => array(self::BELONGS_TO, 'Utilisateur', 'idcreator'),
			'idhotelitem' => array(self::HAS_MANY, 'Ticketsupport', 'idhotelitem'),
			'categorie0' => array(self::BELONGS_TO, 'Categorie', 'idcategorie'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idhotelitem' => 'Numéro de l\'objet',
			'name' => 'Nom',
			'imagesource' => 'Image',
			'idcreator' => 'Numéro de créateur de l\'objet',
			'initialeCreator' => 'Initiales du créateur de l\'objet',
			'idcategorie' => 'Catégorie',
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

		$criteria->compare('idhotelitem',$this->idhotelitem);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('imagesource',$this->imagesource,true);
		$criteria->compare('idcreator',$this->idcreator);
		$criteria->compare('idcategorie',$this->idcategorie,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Hotelitem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
