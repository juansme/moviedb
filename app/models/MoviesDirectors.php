<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class MoviesDirectors extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $id_movie;

    /**
     * @var integer
     */
    public $id_director;

    /**
     * @var datetime
     */
    public $created_at;

    public function initialize()
    {
        $this->belongsTo(
            "id_movie",
            "Movies",
            "id"
        );

        $this->belongsTo(
            "id_director",
            "Directors",
            "id"
        );
    }

    public function validationData($data)
    {
        $validator = new Validation();

        $validator->add(
            'id_director',
            new PresenceOf([
            'message' => 'El director es requerido.'
        ]));
        
        return $validator->validate($data);
    }

    public function setData($data)
    {
        $this->id_movie = isset($data['id_movie']) ? $data['id_movie'] : '';
        $this->id_director = isset($data['id_director']) ? $data['id_director'] : '';
    }
}
