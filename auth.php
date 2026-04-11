<?php
class Auth {
    private const SESSION_KEY = 'castopod_auth';

    public function login(string $password): bool {
        if (password_verify($password, password_hash(APP_PASSWORD, PASSWORD_BCRYPT))
            || $password === APP_PASSWORD) {
            $_SESSION[self::SESSION_KEY] = true;
            $_SESSION['login_time'] = time();
            return true;
        }
        return false;
    }

    public function logout(): void {
        unset($_SESSION[self::SESSION_KEY]);
        session_destroy();
    }

    public function isLoggedIn(): bool {
        if (empty($_SESSION[self::SESSION_KEY])) return false;
        // Session expires after 8 hours
        if (time() - ($_SESSION['login_time'] ?? 0) > 28800) {
            $this->logout();
            return false;
        }
        return true;
    }
}
