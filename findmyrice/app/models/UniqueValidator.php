<?php
namespace Findmyrice\Models;

//use Phalcon\Mvc\Model\Validator,
//    Phalcon\Mvc\Model\ValidatorInterface;
//
//class UniqueValidator extends Validator implements ValidatorInterface
//{
//
//
//    public function validate($record)
//    {
//        $field = $this->getOption('field');
//        if ($record->count(['conditions'=>[$field => $record->readAttribute($field)]])) {
//            $this->appendMessage("The " . $field . " must be unique", $field, "Unique");
//            return false;
//        }
//        return true;
//    }
//}

use MongoId,
    MongoRegex,
    Phalcon\Mvc\Model\Validator,
    Phalcon\Mvc\Model\ValidatorInterface;

class UniqueValidator extends Validator implements ValidatorInterface
{
    public function validate($record)
    {
        $idValue = $record->readAttribute('_id');
        $field = $this->getOption('field');

        $fieldValue = $record->readAttribute($field);


        $conditions = array($field => $fieldValue);
        if(isset($idValue))
        {
            $conditions['_id'] = array('$ne' => $idValue);
        }
        if( $record->count(array('conditions' => $conditions)) )
        {
            $this->appendMessage("The " . $field . " must be unique", $field, "Unique");
            return FALSE;
        }
        else
            return TRUE;
    }
}