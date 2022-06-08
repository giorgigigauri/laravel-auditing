<?php

use App\Models\User;

$user = User::first();
it('update category')->actingAs($user)->get('/api/category/1')->assertSee();

