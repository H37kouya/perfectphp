<?php

namespace App\Controllers;

use Core\Controller;

class AccountController extends Controller
{
    public function signupAction(): string
    {
        return $this->render([
            'user_name' => '',
            'password' => '',
            '_token' => $this->generateCsrfToken('account/signup'),
        ]);
    }

    public function registerAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('account/signup', $token)) {
            return $this->redirect('/account/signup');
        }

        $user_name = $this->request->getPost('user_name');
        $password = $this->request->getPost('password');

        $errors = [];

        if (!strlen($user_name)) {
            $errors[] = 'ユーザーIDを入力してください。';
        } else if (!preg_match('/^\w{3, 20}$/', $user_name)) {
            $errors[] = 'ユーザーIDは半角英数字およびアンダースコアを 3 ～ 20 文字以内で入力してください。';
        } else if (!$this->db_manager->get('User')->isUniqueUserName($user_name)) {
            $errors[] = 'ユーザーIDは既に使われています。';
        }

        if (!strlen($password)) {
            $errors[] = 'パスワードを入力してください。';
        } else if (strlen($password) < 4 || strlen($password) > 30) {
            $errors[] = 'パスワードは4~30文字以内で入力してください。';
        }

        if (count($errors) === 0) {
            $this->db_manager->get('User')->insert($user_name, $password);
            $this->session->setAuthenticated(true);

            $user = $this->db_manager->get('User')->fetchByUserName($user_name);
            $this->session->set('user', $user);

            return $this->redirect('/');
        }

        return $this->render([
            'user_name' => $user_name,
            'password' => $password,
            'errors' => $errors,
            '_token' => $this->generateCsrfToken('account/signup'),
        ], 'signup');
    }
}