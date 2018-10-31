<?php

class DiscountRegular extends BaseModel
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Discount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DiscountRegular';
	}

	/**
	 * @return array
	 */
	public function scopes()
	{
		$alias = $this->getTableAlias();
		return array(
			'orderByName'=>array('order'=>$alias.'.name ASC'),
			'activeOnly'=>array('condition'=>$alias.'.active=1'),
			'applyDate'=>array(
				'condition'=>'start_date <= :now AND end_date >= :now',
				'params'=>array(':now'=>date('Y-m-d H:i:s')),
			),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, sum, start_date, end_date, price', 'required'),
			array('active', 'boolean'),
			array('name', 'length', 'max'=>255),
			array('sum', 'length', 'max'=>10),
			array('start_date, end_date', 'date','format'=>'yyyy-M-d H:m:s'),

			array('id, name, active, sum, start_date, end_date, price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'            => 'ID',
			'name'          => Yii::t('DiscountsModule.core', 'Название'),
			'active'        => Yii::t('DiscountsModule.core', 'Активен'),
			'sum'           => Yii::t('DiscountsModule.core', 'Скидка'),
			'start_date'    => Yii::t('DiscountsModule.core', 'Дата начала'),
			'end_date'      => Yii::t('DiscountsModule.core', 'Дата окончания'),
			'price'     => Yii::t('DiscountsModule.core', 'Сумма'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.active',$this->active);
		$criteria->compare('t.sum',$this->sum,true);
		$criteria->compare('t.start_date',$this->start_date, true);
		$criteria->compare('t.end_date',$this->end_date, true);
		$criteria->compare('t.price',$this->end_date, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function checkDiscount($price)
	{
		$model = Yii::app()->db->createCommand()->
				select( '*' )->
				from('DiscountRegular')->
				where('active = "1"')->
				queryAll();
				
		$regular_discount = DiscountRegular::calculateDiscount();
		$result = preg_replace("/\..+/", "", $regular_discount);
		
		if($result == $model[0]['price'] or $result > $model[0]['price']){
			$timestamp_start = strtotime($model[0]['start_date']);
			$timestamp_stop = strtotime($model[0]['end_date']);
			
		
			if($timestamp_start <= time() && $timestamp_stop >= time() && $model[0]['active'] == '1')
			{
				$percent = $model[0]['sum'];
				$number_percent = $price / 100 * $percent;
				$result = $price - $number_percent;

				return $result;
				
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function calculateDiscount()
	{
		$regular_discount = Order::model()->findAll('`user_id` = '.Yii::app(  )->user->id.' AND `payment_status` = :ps',
            array(
                ':ps' => 'paid',
            )
        );
		if(!empty($regular_discount)){
			$eq = (string)0;
			foreach($regular_discount as $data){
				$eq += $data->total_price;
			}
			return (string)$eq;
		}else{
			return false;
		}
	}
	
	public function calculateDiscountById($id){
		$regular_discount = Order::model()->findAll('`user_id` = '.$id.' AND `payment_status` = :ps',
            array(
                ':ps' => 'paid',
            )
        );
		if(!empty($regular_discount)){
			$eq = (string)0;
			foreach($regular_discount as $data){
				$eq += $data->total_price;
			}
			return (string)$eq;
		}
	}
}