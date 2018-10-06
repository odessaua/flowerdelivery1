<?php

Yii::import('store.models.StoreDeliveryMethod');

/**
 * Used in cart to create new order.
 */
class OrderCreateForm extends CFormModel
{
	public $name;
	public $email;
	public $phone;
	public $address;
	public $country;
	public $city;
	public $delivery_price;
	public $comment;
	public $datetime_delivery;
	public $do_card;
	public $receiver_name;
	public $receiver_city;
	public $phone2;
	public $doPhoto;
	public $card_text;
	public $phone1;
	public $card_transl;

	public function init()
	{
		if(!Yii::app()->user->isGuest)
		{
			$profile=Yii::app()->user->getModel()->profile;
			$this->name=$profile->full_name;
			$this->phone=$profile->phone;
			$this->address=$profile->delivery_address;
			$this->email=Yii::app()->user->email;
		}
		
		$this->receiver_city = "Киев";
		
		if(isset(Yii::app()->session['_cityName']))
		{
			$this->receiver_city = Yii::app()->session['_cityName'];
		}
			
	}

	/**
	 * Validation
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('name, email, country, city, receiver_name, address, phone1, datetime_delivery, phone', 'required', 'message'=>'Please fill this field: {attribute}'),
			array('email', 'filter', 'filter' => 'trim'),
			array('email', 'email'),
			array('comment', 'length', 'max'=>'500'),
			array('card_text', 'length', 'max'=>'1500'),
			array('address, city, receiver_city, datetime_delivery, country', 'length', 'max'=>'255'),
			array('email', 'length', 'max'=>'100'),
			array('phone, phone1, phone2', 'length', 'max'=>'30'),
			array('doPhoto,do_card, card_transl', 'numerical', 'integerOnly'=>true),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'        => Yii::t('OrdersModule.core', 'Как обращаться к отправителю'),
			'email'       => Yii::t('OrdersModule.core', 'E-mail'),
			'comment'     => Yii::t('OrdersModule.core', 'Комментарий'),
			'address'     => Yii::t('OrdersModule.core', 'Адрес доставки'),
			'phone'       => Yii::t('OrdersModule.core', 'Номер телефона'),	
			'phone1' => 'Телефон 1',
			'phone2' => 'Телефон 2',
			'country' => 'Страна',
			'city' => 'Город',	
			'receiver_city' => 'Город',
			'datetime_delivery' => 'Дата и время доставки',
			'receiver_name' => 'Как обращаться к получателю'
		);
	}

	/**
	 * Check if delivery method exists
	 */
	public function validateDelivery()
	{
		if(StoreDeliveryMethod::model()->countByAttributes(array('id'=>$this->delivery_id)) == 0)
			$this->addError('delivery_id', Yii::t('OrdersModule.core', 'Необходимо выбрать способ доставки.'));
	}
}
