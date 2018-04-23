<?php

class ActorsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Actores');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->styles = ['noty', 'datatables', 'bootstrap-datetimepicker'];
    	$this->view->scripts = [ 'noty', 'datatables', 'moment', 'bootstrap-datetimepicker.min', 'actors/main'];
    }

    public function getAction()
    {
        $this->view->disable();
        $actors = new Actors();
        $array = $actors::find(['columns' => 'id, name, birth_date, picture'])->toArray();
        foreach ($array as $key => $value) {
            // print_r($value);
            $array[$key]['picture'] = $this->tag->image($array[$key]['picture']);
            $array[$key]['base'] = $this->config->application->baseUri;
        }
        echo json_encode($array);
    }

    public function searchAction()
    {
        $this->view->disable();
        $q = $this->request->getQuery('query');
        if (!$q) {
            die(json_encode([]));
        }
        $actors = Actors::find([
            'name LIKE :q:',
            'bind' => [
                'q' => '%'. $q .'%'
            ]
        ])->toArray();
        foreach ($actors as $key => $value) {
            $actors[$key]['picture'] = $this->tag->image($actors[$key]['picture']);
        }
        echo json_encode($actors);
    }

    public function loadAction($id)
    {
        $this->view->disable();
        $actors = new Actors();
        $array = $actors::findFirst($id)->toArray();
        if (empty($array)) {
            die(json_encode(['type' => 'warning', 'message' => 'Actor no encontrado.']));
        }
        $array['picture'] = $this->tag->image($array['picture']);
        foreach ($array as $key => $value) {
            $array[$key .'_edit'] = $value;
            unset($array[$key]);
        }
        echo json_encode(['type' => 'success', 'data' => $array]);
    }

    public function createAction()
    {
        $this->view->disable();
        $actor = new Actors();

        $data = $this->request->getPost();
        $validation = $actor->validationData($data);
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
        $actor->setData($data);
        if ($actor->save() == true) {
            die(json_encode(['type' => 'success', 'message' => 'Actor creado correctamente.']));
        } else {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
    }

    public function updateAction()
    {
        $this->view->disable();
        $actor = new Actors();

        $data = $this->request->getPost();
        $validation = $actor->validationData($data);
        if (count($validation)) {
            $messages = [];
            foreach ($validation as $message) {
                $messages[$message->getField(). '_edit'] = $message->getMessage();
            }
            die(json_encode(['type' => 'validation', 'message' => $messages]));
        }
        $actor = Actors::findFirst($data['id']);
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
            $data['picture'] = $actor->picture;
        }
        $actor->setData($data);
        $actor->updated_at = date("Y-m-d H:i:s", time());
        if ($actor->save() == true) {
            die(json_encode(['type' => 'success', 'message' => 'Actor modificado correctamente.']));
        } else {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
    }

    public function deleteAction($id)
    {
        $this->view->disable();

        $actor = Actors::findFirstById($id);
        if (!$actor) {
            die(json_encode(['type' => 'warning', 'message' => 'Actor no encontrado.']));
        }

        if ($actor->delete() == true) {
            die(json_encode(['type' => 'success', 'message' => 'Actor eliminado correctamente.']));
        } else {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
    }

}
