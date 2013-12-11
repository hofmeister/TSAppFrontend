<?php
require_once 'bootstrap.php';

if (TS::isLoggedIn()) {
    header('Location: /app/Tradeshift.Todolist/');
}

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $backendService = TS::instance()->getBackendService();
    $auth = $backendService->auth($username, $password);
    if ($auth) {
        $user = $backendService->getUserByCredential($username);
        TS::setUser($user);
        header('Location: /app/Tradeshift.Todolist/');
    }

    print_r($_SESSION);

}
?>

<form method="post">
    <label>
        <span>Username:</span>
        <input type="text" name="username" />
    </label>
    <label>
        <span>Password:</span>
        <input type="password" name="password" />
    </label>
    <div class="buttongroup">
        <input type="submit" value="Log in" />
    </div>
</form>

<?
session_commit();
?>