<?php
function Card($users, $onclick)
{
    $userCards = array_map(function ($user) use ($onclick) {
        return "
            <div>
                <p>Username: {$user['username']}</p>
                <p>Email: {$user['email']}</p>
                <button onclick='{$onclick}({$user['id']})'>delete</button>
            </div>
        ";
    }, $users);

    echo implode('', $userCards);
}
