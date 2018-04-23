<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;

class MoviesActors extends Model
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
    public $id_actor;

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
            "id_actor",
            "Actors",
            "id"
        );
    }

    public function setData($data)
    {
        $this->id_movie = isset($data['id_movie']) ? $data['id_movie'] : '';
        $this->id_actor = isset($data['id_actor']) ? $data['id_actor'] : '';
    }
}
