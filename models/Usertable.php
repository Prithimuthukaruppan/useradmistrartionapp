<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "usertable".
 *
 * @property int $usertbl_pk
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $mobileno
 * @property string $imageupload
 * @property string $dob
 * @property int $status
 * @property string $address
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $createdon
 */
class Usertable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usertable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'password', 'mobileno', 'imageupload', 'dob', 'status', 'address', 'country', 'state', 'city', 'createdon'], 'required'],
            [['mobileno', 'status'], 'integer'],
            [['dob', 'createdon'], 'safe'],
            [['name', 'email', 'password'], 'string', 'max' => 60],
            [['username', 'country', 'state', 'city'], 'string', 'max' => 40],
            [['imageupload'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 70],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usertbl_pk' => 'Usertbl Pk',
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'mobileno' => 'Mobileno',
            'imageupload' => 'Imageupload',
            'dob' => 'Dob',
            'status' => 'Status',
            'address' => 'Address',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'createdon' => 'Createdon',
        ];
    }
    public function getlistdata(){
    $query = Usertable::find();
       if (!empty($_REQUEST['Username'])) {
               $query->where("username like '{$_REQUEST['Username']}' ");
       }
       $query->orderBy("createdon desc");
       return new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
               'pageSize' => 10,
           ]
       ]);

    }
}
