<?php

 

/**
* This is the model class for table "tbl_student_data".
*
    * @property integer $id
    * @property string $subject
    * @property integer $user_id
    * @property integer $state_id
    * @property string $created_on
    * @property string $updated_on

* === Related data ===
    * @property User $user
    */

namespace app\models;

use Yii;
use app\models\Feed;
use app\models\User;

use yii\helpers\ArrayHelper;

class StudentData extends \yii\db\ActiveRecord
{
	public  function __toString()
	{
		return (string)$this->subject;
	}
public static function getUserOptions()
	{
		return ArrayHelper::Map ( User::find ()->all (), 'id', 'full_name' );
	}

				const STATE_INACTIVE 	= 0;
	const STATE_ACTIVE	 	= 1;
	const STATE_DELETED 	= 2;

	public static function getStateOptions()
	{
		return [
				self::STATE_INACTIVE		=> "New",
				self::STATE_ACTIVE 			=> "Active" ,
				self::STATE_DELETED 		=> "Deleted",
		];
	}
	public function getState()
	{
		$list = self::getStateOptions();
		return isset($list [$this->state_id])?$list [$this->state_id]:'Not Defined';

	}
	public function getStateBadge()
	{
		$list = [
				self::STATE_INACTIVE 		=> "default",
				self::STATE_ACTIVE 			=> "success" ,
				self::STATE_DELETED 		=> "danger",
		];
		return isset($list[$this->state_id])?\yii\helpers\Html::tag('span', $this->getState(), ['class' => 'label label-' . $list[$this->state_id]]):'Not Defined';
	}
    public static function getActionOptions()
    {
        return [
            self::STATE_INACTIVE => "Deactivate",
            self::STATE_ACTIVE => "Activate",
            self::STATE_DELETED => "Delete"
        ];
    }

		


	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return '{{%student_data}}';
	}

	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
            [['subject', 'user_id', 'state_id', 'created_on', 'updated_on'], 'required'],
            [['user_id', 'state_id'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['subject'], 'string', 'max' => 256],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['subject'], 'trim'],
            [['state_id'], 'in', 'range' => array_keys(self::getStateOptions())]
        ];
	}

	/**
	* @inheritdoc
	*/


	public function attributeLabels()
	{
		return [
				    'id' => Yii::t('app', 'ID'),
				    'subject' => Yii::t('app', 'Subject'),
				    'user_id' => Yii::t('app', 'User'),
				    'state_id' => Yii::t('app', 'State'),
				    'created_on' => Yii::t('app', 'Created On'),
				    'updated_on' => Yii::t('app', 'Updated On'),
				];
	}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    	return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public static function getHasManyRelations()
    {
    	$relations = [];

    	$relations['feeds'] = [
            'feeds',
            'Feed',
            'model_id'
        ];
		return $relations;
	}
    public static function getHasOneRelations()
    {
    	$relations = [];
		$relations['user_id'] = ['user','User','id'];
		return $relations;
	}

	public function beforeDelete() {
	    if (! parent::beforeDelete()) {
            return false;
        }
        //TODO : start here
		return true;
	}
	
  	public function beforeSave($insert)
    {
        if (! parent::beforeSave($insert)) {
            return false;
        }
        //TODO : start here
        
        return true;
    }
    public function asJson($with_relations=false)
	{
		$json = [];
			$json['id'] 	= $this->id;
			$json['subject'] 	= $this->subject;
			$json['user_id'] 	= $this->user_id;
			$json['state_id'] 	= $this->state_id;
			$json['created_on'] 	= $this->created_on;
			if ($with_relations)
		    {
				// user
				$list = $this->user;

				if ( is_array($list))
				{
					$relationData = [];
					foreach( $list as $item)
					{
						$relationData [] 	= $item->asJson();
					}
					$json['user'] 	= $relationData;
				}
				else
				{
					$json['user'] 	= $list;
				}
			}
		return $json;
	}
	
		
    public static function addTestData($count = 1)
    {
        $faker = \Faker\Factory::create();
        $states = array_keys(self::getStateOptions());
        for ($i = 0; $i < $count; $i ++) {
            $model = new self();
            
						$model->subject = $faker->text(10);
			$model->user_id = 1;
			$model->state_id = $states[rand(0,count($states))];
        	$model->save();
        }
	}
    public static function addData($data)
    {
    	$faker = \Faker\Factory::create();
    	if (self::find()->count() != 0)
            return;
        foreach( $data as $item) {
            $model = new self();
            
                    
                    	$model->subject = isset($item['subject'])?$item['subject']:$faker->text(10);
                                       
                    	$model->user_id = isset($item['user_id'])?$item['user_id']:1;
                   			$model->state_id = self::STATE_ACTIVE;
        	if ( !$model->save())
            {
                self::log($model->getErrorsString());
            }
        }
	}	
	
	public function isAllowed()
	{
		
		if (User::isAdmin())
			return true;

		if ($this instanceof User)
		{
			return ($this->id == Yii::$app->user->id);
		}
		if ($this->hasAttribute('created_by_id'))
		{
			return ($this->created_by_id == Yii::$app->user->id);
		}

		if ($this->hasAttribute('user_id'))
		{
			return ($this->user_id == Yii::$app->user->id);
		}

		return false;
	}
	
}
