<?php

class MoviesController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Películas');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->styles = ['noty', 'datatables', 'bootstrap-datetimepicker'];
    	$this->view->scripts = ['jquery.autocomplete', 'noty', 'datatables', 'moment', 'bootstrap-datetimepicker.min', 'movies/main'];
    }

    public function getAction()
    {
        $this->view->disable();
        $movies = new Movies();
        $array = $movies::find(['columns' => 'id, title, released_at, picture'])->toArray();
        foreach ($array as $key => $value) {
            // print_r($value);
            $array[$key]['picture'] = $this->tag->image($array[$key]['picture']);
            $array[$key]['base'] = $this->config->application->baseUri;
        }
        echo json_encode($array);
    }

    public function loadAction($id)
    {
        $this->view->disable();
        $movie = Movies::findFirst($id);
        if (!$movie) {
            die(json_encode(['type' => 'warning', 'message' => 'Película no encontrada.']));
        }
        $actors = [];
        $directors = [];
        foreach ($movie->moviesDirectors as $movieDirector) {
            $directors[] = ['picture' => $this->tag->image($movieDirector->directors->picture),'id' => $movieDirector->id, 'base' => $this->config->application->baseUri] + $movieDirector->directors->toArray();
        }
        foreach ($movie->moviesActors as $movieActor) {
            $actors[] = ['picture' => $this->tag->image($movieActor->actors->picture),'id' => $movieActor->id, 'base' => $this->config->application->baseUri] + $movieActor->actors->toArray();
        }
        $data = $movie->toArray();
        foreach ($data as $key => $value) {
            $data[$key .'_edit'] = $value;
            unset($data[$key]);
        }
        $data['rel']['director'] = $directors;
        $data['rel']['actors'] = $actors;
        echo json_encode(['type' => 'success', 'data' => $data]);
    }

    public function createAction()
    {
        $this->view->disable();
        $movie = new Movies();

        $data = $this->request->getPost();
        $validation = $movie->validationData($data);
        if (count($validation)) {
            $messages = [];
            foreach ($validation as $message) {
                $messages[$message->getField()] = $message->getMessage();
            }
            die(json_encode(['type' => 'validation', 'message' => $messages]));
        }
        if ($this->request->hasFiles() == true) {
            $baseLocation = 'images/';

            $picture = $this->request->getUploadedFiles()[0];
            // If uploaded
            if (!$picture->getError()) {
                $storage = 'images/' . time() .'_'. $picture->getName();
                $picture->moveTo($storage);
                $data['picture'] = $storage;
            }
        }
        $movie->setData($data);

        $this->db->begin();

        if ($movie->save() == false) {
            $this->db->rollback();
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));            
        }
        $data['id_movie'] = $movie->id;
        $movies_directors = new MoviesDirectors();
        $validation = $movies_directors->validationData($data);
        if (count($validation)) {
            $this->db->rollback();
            $messages = [];
            foreach ($validation as $message) {
                $messages['directors_search'] = $message->getMessage();
            }
            die(json_encode(['type' => 'validation', 'message' => $messages]));
        }
        $movies_directors->setData($data);
        if ($movies_directors->save() == false) {
            $this->db->rollback();
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));         
        }
        if (isset($data['actors'])) {
            foreach ($data['actors'] as $key => $value) {
                $movies_actors = new MoviesActors();
                $new = ['id_movie' => $data['id_movie'], 'id_actor' => $value];
                $movies_actors->setData($new);
                if ($movies_actors->save() == false) {
                    $this->db->rollback();
                    die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));         
                }
            }
        } else {
            $this->db->rollback();
            die(json_encode(['type' => 'validation', 'message' => ['actors_search' => 'Al menos un actor es requerido.']]));
        }

        $this->db->commit();
        die(json_encode(['type' => 'success', 'message' => 'Película creada correctamente.']));
    }

    public function updateAction()
    {
        $this->view->disable();
        $movie = new Movies();

        $data = $this->request->getPost();
        $validation = $movie->validationData($data);
        if (count($validation)) {
            $messages = [];
            foreach ($validation as $message) {
                $messages[$message->getField(). '_edit'] = $message->getMessage();
            }
            die(json_encode(['type' => 'validation', 'message' => $messages]));
        }
        $movie = Movies::findFirst($data['id']);
        if ($this->request->hasFiles() == true) {
            $baseLocation = 'images/';

            $picture = $this->request->getUploadedFiles()[0];
            // If uploaded
            if (!$picture->getError()) {
                $storage = 'images/' . time() .'_'. $picture->getName();
                $picture->moveTo($storage);
                $data['picture'] = $storage;
            }
        } else {
            $data['picture'] = $movie->picture;
        }
        $movie->setData($data);
        $movie->updated_at = date("Y-m-d H:i:s", time());
        $this->db->begin();

        if ($movie->save() == false) {
            $this->db->rollback();
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));            
        }
        $data['id_movie'] = $data['id'];
        unset($data['id']);
        if (isset($data['id_director'])) {
            $movies_directors = new MoviesDirectors();
            $movies_directors->setData($data);
            if ($movies_directors->save() == false) {
                $this->db->rollback();
                die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));         
            }
        } elseif (empty(MoviesDirectors::find(['id_movie = :id:', 'bind' => ['id' => $data['id_movie']]])->toArray())) {
            $this->db->rollback();
            die(json_encode(['type' => 'validation', 'message' => ['directors_search_edit' => 'El director es requerido.']]));
        }
        if (isset($data['actors'])) {
            foreach ($data['actors'] as $key => $value) {
                $movies_actors = new MoviesActors();
                $new = ['id_movie' => $data['id_movie'], 'id_actor' => $value];
                $movies_actors->setData($new);
                if ($movies_actors->save() == false) {
                    $this->db->rollback();
                    die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));         
                }
            }
        } elseif (empty(MoviesActors::find(['id_movie = :id:', 'bind' => ['id' => $data['id_movie']]])->toArray())) {
            $this->db->rollback();
            die(json_encode(['type' => 'validation', 'message' => ['actors_search_edit' => 'Al menos un actor es requerido.']]));
        }

        $this->db->commit();
        die(json_encode(['type' => 'success', 'message' => 'Película modificada correctamente.']));
    }

    public function deleteAction($id)
    {
        $this->view->disable();
        $movie = Movies::findFirstById($id);
        if (!$movie) {
            die(json_encode(['type' => 'warning', 'message' => 'Película no encontrada.']));
        }
        $this->db->begin();

        if ($movie->delete() == false) {
            $this->db->rollback();
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
        $movies_actors = MoviesActors::find([
            'id_movie = :id:',
            'bind' => [
                'id' => $id
            ]
        ]);
        if ($movies_actors->delete() == false) {
            $this->db->rollback();
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
        $movies_directors = MoviesDirectors::find([
            'id_movie = :id:',
            'bind' => [
                'id' => $id
            ]
        ]);
        if ($movies_directors->delete() == false) {
            $this->db->rollback();
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }

        $this->db->commit();
        die(json_encode(['type' => 'success', 'message' => 'Película eliminada correctamente.']));
    }

    public function removeDirectorAction($id)
    {
        $this->view->disable();
        $movieDirector = MoviesDirectors::findFirstById($id);
        if (!$movieDirector) {
            die(json_encode(['type' => 'warning', 'message' => 'Director no encontrado.']));
        }
        if ($movieDirector->delete() == false) {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
        die(json_encode(['type' => 'success', 'message' => 'Director removido correctamente.']));
    }

    public function removeActorAction($id)
    {
        $this->view->disable();
        $movieActor = MoviesActors::findFirstById($id);
        if (!$movieActor) {
            die(json_encode(['type' => 'warning', 'message' => 'Actor no encontrado.']));
        }
        if ($movieActor->delete() == false) {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
        die(json_encode(['type' => 'success', 'message' => 'Actor removido correctamente.']));
    }

}
