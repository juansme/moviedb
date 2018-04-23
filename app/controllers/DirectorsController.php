<?php

class DirectorsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Directores');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->styles = ['noty', 'datatables', 'bootstrap-datetimepicker'];
    	$this->view->scripts = [ 'noty', 'datatables', 'moment', 'bootstrap-datetimepicker.min', 'directors/main'];
    }

    public function getAction()
    {
        $this->view->disable();
        $directors = new Directors();
        $array = $directors::find(['columns' => 'id, name, birth_date, picture'])->toArray();
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
        $directors = Directors::find([
            'name LIKE :q:',
            'bind' => [
                'q' => '%'. $q .'%'
            ]
        ])->toArray();
        foreach ($directors as $key => $value) {
            $directors[$key]['picture'] = $this->tag->image($directors[$key]['picture']);
        }
        echo json_encode($directors);
    }

    public function loadAction($id)
    {
        $this->view->disable();
        $directors = new Directors();
        $array = $directors::findFirst($id)->toArray();
        if (empty($array)) {
            die(json_encode(['type' => 'warning', 'message' => 'Director no encontrado.']));
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
        $director = new Directors();

        $data = $this->request->getPost();
        $validation = $director->validationData($data);
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
        $director->setData($data);
        if ($director->save() == true) {
            die(json_encode(['type' => 'success', 'message' => 'Director creado correctamente.']));
        } else {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
    }

    public function updateAction()
    {
        $this->view->disable();
        $director = new Directors();

        $data = $this->request->getPost();
        $validation = $director->validationData($data);
        if (count($validation)) {
            $messages = [];
            foreach ($validation as $message) {
                $messages[$message->getField(). '_edit'] = $message->getMessage();
            }
            die(json_encode(['type' => 'validation', 'message' => $messages]));
        }
        $director = Directors::findFirst($data['id']);
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
            $data['picture'] = $director->picture;
        }
        $director->setData($data);
        $director->updated_at = date("Y-m-d H:i:s", time());
        if ($director->save() == true) {
            die(json_encode(['type' => 'success', 'message' => 'Director modificado correctamente.']));
        } else {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
    }

    public function deleteAction($id)
    {
        $this->view->disable();

        $director = Directors::findFirstById($id);
        if (!$director) {
            die(json_encode(['type' => 'warning', 'message' => 'Director no encontrado.']));
        }

        if ($director->delete() == true) {
            die(json_encode(['type' => 'success', 'message' => 'Director eliminado correctamente.']));
        } else {
            die(json_encode(['type' => 'error', 'message' => 'Error inesperado. Intente nuevamente.']));
        }
    }

}
