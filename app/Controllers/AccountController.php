<?php

namespace App\Controllers;

use Core\Controller;

class AccountController extends Controller
{
    public function signupAction(): string
    {
        return $this->render([
            '_token' => $this->generateCsrfToken('account/signup'),
        ]);
    }
}
