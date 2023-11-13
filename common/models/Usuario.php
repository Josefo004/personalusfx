<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use frontend\models\AcademicaDao;

class Usuario extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'Usuarios';
    }

    public function rules()
    {
        return [
            [['CodigoUsuario', 'IdPersona'], 'required'],
        ];
    }

    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['CodigoRol' => 'CodigoRol']);
    }

    public function getPersona()
    {
        return $this->hasOne(Persona::className(), ['IdPersona' => 'IdPersona']);
    }

    public function getCarreras()
    {
        return AcademicaDao::listaCarrerasUsuario($this->CodigoUsuario);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['CodigoUsuario' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::find()->where(['Llave' => $token])->one();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->Llave;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
