<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Date as DateValidator;

class Directors extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var date
     */
    public $birth_date;

    /**
     * @var string
     */
    public $picture = 'images/default.png';

    /**
     * @var datetime
     */
    public $created_at;

    /**
     * @var datetime
     */
    public $updated_at;

    public function initialize()
    {
        $this->hasMany(
            "id",
            "MoviesDirectors",
            "id_director"
        );
    }

    public function validationData($data)
    {
        $validator = new Validation();
        
        $validator->add(
            'name',
            new PresenceOf([
            'message' => 'Este campo es obligatorio.'
        ]));
        $validator->add(
            'summary',
            new PresenceOf([
            'message' => 'Este campo es obligatorio.'
        ]));
        $validator->add(
            'birth_date',
            new DateValidator([
            'format'  => 'Y-m-d',
            'message' => 'La fecha no es válida.'
        ]));
        $validator->add(
            'birth_date',
            new PresenceOf([
            'message' => 'Este campo es obligatorio.'
        ]));
        
        return $validator->validate($data);
    }

    public function setData($data)
    {
        $this->name = isset($data['name']) ? $data['name'] : '';
        $this->summary = isset($data['summary']) ? $data['summary'] : '';
        $this->birth_date = isset($data['birth_date']) ? $data['birth_date'] : '';
        $this->picture = isset($data['picture']) ? $data['picture'] : $this->picture;
    }
}
