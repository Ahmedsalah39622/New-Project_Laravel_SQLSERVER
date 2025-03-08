<?php
use Spatie\Permission\Models\Role;

$user = $User::find(1); // Change ID accordingly
$user->assignRole('admin');
