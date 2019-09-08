<?php

namespace App\Controllers;

use Core\Controller;

class StatusController extends Controller
{
    public function indexAction(): string
    {
        $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

        return $this->render([
            'statuses' => $statuses,
            'body' => '',
            '_token' => $this->generateCsrfToken('status/post'),
        ]);
    }

    public function postAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('status/post', $token)) {
            return $this->redirect('/');
        }

        $body = $this->request->getPost('body');

        $errors = [];

        if (!strlen($body)) {
            $errors[] = 'ひとことを入力してください。';
        } else if (mb_strlen($body) > 200) {
            $errors[] = 'ひとことは200文字以内で入力してください。';
        }

        if (count($errors) === 0) {
            $user = $this->session->get('user');
            $this->db_manager->get('Status')->insert($user['id'], $body);

            return $this->redirect('/');
        }

        $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

        return $this->render([
            'errors' => $errors,
            'body' => $body,
            'status' => $statuses,
            '_token' => $this->generateCsrfToken('status/post'),
        ], 'index');
    }

    public function userAction(array $params): string
    {
        $user = $this->db_manager->get('User')->fetchByUserName($params['user_name']);
        if (!$user) {
            $this->forward404();
        }

        $statuses = $this->db_manager->get('Status')->fetchAllByUserId($user['id']);

        return $this->render([
            'user' => $user,
            'statuses' => $statuses,
        ]);
    }

    public function showAction(array $params): string
    {
        $status = $this->db_manager->get('Status')->fetchByIdAndUserName($params['id'], $params['user_name']);
        if (!$status) {
            $this->forward404();
        }

        return $this->render([
            'status' => $status,
        ]);

    }
}
