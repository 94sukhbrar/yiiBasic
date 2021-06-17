<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $date_of_birth
 * @property int|null $gender
 * @property string|null $about_me
 * @property string|null $contact_no
 * @property string|null $address
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $city
 * @property string|null $country
 * @property string|null $zipcode
 * @property string|null $language
 * @property int|null $email_verified
 * @property string|null $profile_file
 * @property int|null $tos
 * @property int $role_id
 * @property int $state_id
 * @property int|null $type_id
 * @property string|null $last_visit_time
 * @property string|null $last_action_time
 * @property string|null $last_password_change
 * @property int|null $login_error_count
 * @property string|null $activation_key
 * @property string|null $access_token
 * @property string|null $timezone
 * @property string $created_on
 * @property string|null $updated_on
 * @property int|null $created_by_id
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    const STATE_INACTIVE = 0;

    const STATE_ACTIVE = 1;

    const STATE_BANNED = 2;

    const STATE_DELETED = 4;
    const ROLE_USER =1;
    const ROLE_Admin =2;

    public static function getStateOptions()
    {
        return [
            self::STATE_INACTIVE => "Inactive",
            self::STATE_ACTIVE => "Active",
            self::STATE_BANNED => "Banned",
            self::STATE_DELETED => "Deleted"
        ];
    }

    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public function getSubjectName()
    {
        $list = self::getSubject();
        return isset($list[$this->subject]) ? $list[$this->subject] : 'Not Defined';
    }

    public static function getSubject()
    {
       	return ArrayHelper::Map ( Subject::find()->all (), 'id', 'subject_name' );
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'password', 'role_id', 'state_id', 'created_on'], 'required'],
            [['date_of_birth', 'last_visit_time','subject','last_action_time', 'last_password_change', 'created_on', 'updated_on'], 'safe'],
            [['gender', 'email_verified', 'tos', 'role_id', 'state_id', 'type_id', 'login_error_count', 'created_by_id'], 'integer'],
            [['full_name', 'email', 'about_me', 'contact_no', 'city', 'country', 'zipcode', 'language', 'profile_file', 'timezone'], 'string', 'max' => 255],
            [['password', 'activation_key', 'access_token'], 'string', 'max' => 128],
            [['address', 'latitude', 'longitude'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'password' => 'Password',
            'date_of_birth' => 'Date Of Birth',
            'gender' => 'Gender',
            'about_me' => 'About Me',
            'contact_no' => 'Contact No',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'city' => 'City',
            'country' => 'Country',
            'zipcode' => 'Zipcode',
            'language' => 'Language',
            'email_verified' => 'Email Verified',
            'profile_file' => 'Profile File',
            'tos' => 'Tos',
            'role_id' => 'Role ID',
            'state_id' => 'State ID',
            'type_id' => 'Type ID',
            'last_visit_time' => 'Last Visit Time',
            'last_action_time' => 'Last Action Time',
            'last_password_change' => 'Last Password Change',
            'login_error_count' => 'Login Error Count',
            'activation_key' => 'Activation Key',
            'access_token' => 'Access Token',
            'timezone' => 'Timezone',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'created_by_id' => 'Created By ID',
        ];
    }
    public function isActive()
    {
        return ($this->state_id == User::STATE_ACTIVE);
    }

    public static function isAdmin()
    {
        $user = Yii::$app->user->identity;
        if ($user == null)
            return false;

        return ($user->isActive() && $user->role_id == User::ROLE_Admin);
    }



    
}
