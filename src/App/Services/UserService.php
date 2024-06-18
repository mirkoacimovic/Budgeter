<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db)
    {
    }

    public function isEmailTaken(string $email)
    {
        $count = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE email=:email",
            ['email' => $email]
        )->count();

        if ($count > 0) {
            throw new ValidationException(['email' => "Email taken."]);
        }
    }

    public function create(array $data)
    {
        $email = $data['email'];
        $age = $data['age'];
        $country = $data['country'];
        $socialMediaUrl = $data['socialMediaUrl'];
        $password = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        $query = "INSERT INTO users(email,age,country,social_media_url,password) VALUES(:email, :age, :country, :socialMediaUrl, :password)";

        $this->db->query($query, [
            'email' => $email,
            'age' => $age,
            'country' => $country,
            'socialMediaUrl' => $socialMediaUrl,
            'password' => $password
        ]);

        session_regenerate_id();

        $_SESSION['user'] = $this->db->id();
    }

    public function login(array $formData)
    {
        $user = $this->db->query("SELECT * FROM users WHERE email = :email", [
            "email" => $formData['email']
        ])->find();

        $passwordsMatch = password_verify($formData['password'], $user['password'] ?? '');

        if (!$user || !$passwordsMatch) {
            throw new ValidationException([
                'password' => ['Invalid credentials.']
            ]);
        }

        session_regenerate_id();

        $_SESSION['user'] = $user['id'];
    }

    public function logout()
    {
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(
            "PHPSESSIONID",
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
}
