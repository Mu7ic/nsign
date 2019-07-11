<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $picture
 * @property string $name
 * @property string $fname
 * @property integer $datecreate
 * @property integer $lastupdate
 * @property integer $role
 * @property integer $status
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'authKey', 'accessToken', 'picture', 'name', 'fname', 'datecreate', 'lastupdate', 'role', 'status'], 'required'],
            [['datecreate', 'lastupdate', 'role', 'status'], 'integer'],
            [['email', 'password', 'authKey', 'accessToken'], 'string', 'max' => 250],
            [['picture'], 'string', 'max' => 150],
            [['name', 'fname'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'picture' => 'Picture',
            'name' => 'Name',
            'fname' => 'Fname',
            'datecreate' => 'Datecreate',
            'lastupdate' => 'Lastupdate',
            'role' => 'Role',
            'status' => 'Status',
        ];
    }
}
