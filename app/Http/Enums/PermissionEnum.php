<?php

namespace App\Http\Enums;

enum PermissionEnum: string
{
    case VIEW_USERS = 'view users';
    case EDIT_USER_ROLE = 'edit user role';
    case CREATE_USER = 'create user';
    case VIEW_SETTINGS = 'view settings';
}
