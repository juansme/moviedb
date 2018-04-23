<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Date as DateValidator;

class Movies extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var date
     */
    public $released_at;

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
            "MoviesActors",
            "id_movie"
        );
        $this->hasMany(
            "id",
            "MoviesDirectors",
            "id_movie"
        );
    }

    public function validationData($data)
    {
        $validator = new Validation();
        
        $validator->add(
            'title',
            new PresenceOf([
            'message' => 'Este campo es obligatorio.'
        ]));
        $validator->add(
            'summary',
            new PresenceOf([
            'message' => 'Este campo es obligatorio.'
        ]));
        $validator->add(
            'released_at',
            new DateValidator([
            'format'  => 'Y-m-d',
            'message' => 'La fecha no es válida.'
        ]));
        $validator->add(
            'released_at',
            new PresenceOf([
            'message' => 'Este campo es obligatorio.'
        ]));
        
        return $validator->validate($data);
    }

    public function setData($data)
    {
        $this->title = isset($data['title']) ? $data['title'] : '';
        $this->summary = isset($data['summary']) ? $data['summary'] : '';
        $this->released_at = isset($data['released_at']) ? $data['released_at'] : '';
        $this->picture = isset($data['picture']) ? $data['picture'] : $this->picture;
    }
}
