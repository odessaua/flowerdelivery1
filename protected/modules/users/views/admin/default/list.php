<?php
	// Display list of users
Yii::import('discounts.models.*');
	$this->pageHeader = Yii::t('UsersModule.core', 'Список пользователей');
	//$orders = sizeof($model->orders);
	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('UsersModule.core', 'Пользователи'),
	);

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'template'=>array('new'),
		'elements'=>array(
			'new'=>array(
				'link'=>$this->createUrl('create'),
				'title'=>Yii::t('UsersModule.core', 'Создать пользователя'),
				'options'=>array(
					'icons'=>array('primary'=>'ui-icon-person')
				)
			),
		),
	));

	$this->widget('ext.sgridview.SGridView', array(
		'dataProvider'=>$dataProvider,
		'id'=>'usersListGrid',
		'filter'=>$model,
		'columns'=>array(
			array(
				'class'=>'SGridIdColumn',
				'name'=>'id',
			),
			array(
				'name'=>'username',
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->username),array("update","id"=>$data->id))',
			),
			
			array(
				'name'=>'Total_Buy',
				'value'=>'DiscountRegular::calculateDiscountById("$data->id")',
			), 
			'email',
			'discount',
			array(
				'name'=>'created_at',
			),
			array(
				'name'=>'banned',
				'filter'=>array(1=>Yii::t('UsersModule.admin', 'Да'), 0=>Yii::t('UsersModule.admin', 'Нет')),
				'value'=>'$data->banned ? Yii::t("UsersModule.admin", "Да") : Yii::t("UsersModule.admin", "Нет")'
			),
			array(
				'name'=>'last_login',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update}{delete}',
			),
		),
	));

