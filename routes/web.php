<?php
Route::get('/', function () {
    //создаем нового пользователя:
    $user = factory(App\User::class)->create();
    //создаем новый адрес:
    $address = new App\Address([
       //'user_id'   => $user->id,
        'country'   => 'Russia',
        'zip'       => 363120
    ]);

    //связи:
    $user->address()->save($address);

    //вывод:
    $user->load('address');
    dd($user);
});


//связь 1 ко многим:
Route::get('/has-many', function () {
    //создадим юзера:
    $user = factory(App\User::class)->create();
    //создадим несколько постов:
    $posts = factory(App\Post::class, 5)->create();
    //свяжем их:
    $user->posts()->saveMany($posts);
    //выведем:
    $user->load('posts');
    dd($user);
});


Route::get('/has-many-tips', function() {
    $user = factory(App\User::class)->create();
    $post =factory(App\Post::class)->create();
    //$post->user()->associate($user);
    $post->author()->associate($user);
    $post->save();
    dd( $post->author->id, $post->author->name, $post->author->email );
});

Route::get('user/{id}', function($id) {
    $user = App\User::with('posts')->find($id);
    //dd($user, $user->posts);
    $posts = $user->posts;
    $test[3] = 'tesstttttttttttttt';
    return view('profile', compact('user', 'posts', 'test'));
});

Route::get('roles', function() {
    $user = App\User::first();
    $role = App\Role::create(['name'=>'editor']);
    $user->roles()->attach($role->id);
    $user->load('roles');
    dd($user->roles);
});

Route::get('role-create/{role}', function ($role) { //Создать роль
    $created_role = App\Role::create(['name'=>$role]);
    $created_role->save();
    dd($created_role);
});

Route::get('roles-select/{role}', function($role) { //Посмотреть роль
    //$role = App\Role::whereName($role)->with('users')->first(); dd($role->users);
    $role_sel = App\Role::whereName($role)->first();
    dd($role, $role_sel);
});

Route::get('roles-change', function () { //Назначить юзеру уже созданную роль
    $user = App\User::offset(1)->first();
    $role = App\Role::whereName('admin')->first();
    $user->roles()->attach($role->id);
    $user->load('roles');
    dd($user->roles);
  });

  Route::get('sync/{type}/{role}', function( $type='attach', $role='admin') {
    $roleAdmin = App\Role::whereName($role)->first();
    $roleEditor = App\Role::whereName('editor')->first();

    $user = App\User::first();

    //присоединение
    if($type=='attach')                     
       $user->roles()->attach($roleAdmin->id);
    //открепление
    if($type=='detach')
       $user->roles()->detach($roleAdmin->id);

    // получить все роли
    //проверить какая роль уже существует
    //проверить какая роль не существует

    //синхронизация
    if($type=='sync')
        $user->roles()->sync( [ $roleAdmin->id, $roleEditor->id ] );

    foreach ($user->roles as $role) {
        print_r ( $role->name . '<br>');
    }
    dd('усе!');
  });