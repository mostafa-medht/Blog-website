<?php

Route::get('/test',function(){
    return App\User::find(1)->profile;
});

Route::post('/subscribe',function(){
    $email = request('email');

    Newsletter::subscribe($email);

    Session::flash('subscribed','Successfuly subscribed.');
    return redirect()->back();
});

Route::get('/',[
    'uses' => 'FrontEndController@index',
    'as' => 'index'
]);

Route::get('/results',function(){
    $posts = \App\Post::where('title','like', '%' . request('query') . '%')->get();

    return view('results')->with('posts',$posts)
                            ->with('title','Search results : ' . request('query'))
                            ->with('settings', \App\Setting::first())                            
                            ->with('categories', \App\Category::take(5)->get())
                            ->with('query',request('query'));
});

// Route::get('/results/{query}',[
//     'uses' => 'FrontEndController@search',
//     'as' => '/results'
// ]);

Route::get('/post/{slug}',[
    'uses' => 'FrontEndController@singlePost',
    'as' => 'post.single'
]);

Route::get('/category/{id}',[
    'uses' => 'FrontEndController@category',
    'as' => 'category.single'
]);

Route::get('/tag/{id}',[
    'uses' => 'FrontEndController@tag',
    'as' => 'tag.single'
]);




// Comment 
    // Comments
    Route::post('comments/{post_id}', [
        'uses' => 'CommentsController@store',
         'as' => 'comments.store']);

    Route::get('comments/{id}/edit', [
        'uses' => 'CommentsController@edit',
         'as' => 'comments.edit']);

    Route::put('comments/{id}', [
        'uses' => 'CommentsController@update',
         'as' => 'comments.update']);

    Route::get('comments/delete/{id}', [
        'uses' => 'CommentsController@destroy',
         'as' => 'comments.delete']);

    Route::get('/comments' ,[
    'uses' => 'CommentsController@index',
    'as' => 'comments'
    ]);

    Route::get('/test' ,[
    'uses' => 'CommentsController@show',
    'as' => 'comments'
    ]);

Auth::routes();

Route::group(['prefix'=> 'admin' ,'middleware' => 'auth'] , function(){

    Route::get('/dashboard', [
        'uses' => 'HomeController@index',
        'as' => 'home'
    ]);

    // Post 
    Route::get('/post/create' ,[
        'uses' => 'PostsController@create',
        'as' => 'post.create'
    ]);

    Route::POST('/post/store' ,[
        'uses' => 'PostsController@store',
        'as' => 'post.store'
    ]);

    Route::get('/post/delete/{id}' ,[
        'uses' => 'PostsController@destroy',
        'as' => 'post.delete'
    ]);

    Route::get('posts',[
        'uses' => 'PostsController@index',
        'as' => 'posts'
    ]); 

    Route::get('posts/trashed',[
        'uses' => 'PostsController@trashed',
        'as' => 'posts.trashed'
    ]);

    Route::get('posts/kill/{id}',[
        'uses' => 'PostsController@kill',
        'as' => 'post.kill'
    ]);

    Route::get('posts/restore/{id}',[
        'uses' => 'PostsController@restore',
        'as' => 'post.restore'
    ]);

    Route::get('posts/edit/{id}',[
        'uses' => 'PostsController@edit',
        'as' => 'post.edit'
    ]);

    Route::post('posts/update/{id}',[
        'uses' => 'PostsController@update',
        'as' => 'post.update'
    ]);
    
    // Category
    Route::get('/category/create' ,[
        'uses' => 'CategoriesController@create',
        'as' => 'category.create'
    ]);

    Route::get('/categories' ,[
        'uses' => 'CategoriesController@index',
        'as' => 'categories'
    ]);

    Route::post('/category/store' ,[
        'uses' => 'CategoriesController@store',
        'as' => 'category.store'
    ]);

    Route::get('/category/edit/{id}',[
        'uses' => 'CategoriesController@edit',
        'as' => 'category.edit'
    ]);

    Route::get('/category/delete/{id}',[
        'uses' => 'CategoriesController@destroy',
        'as' => 'category.delete'
    ]);

    Route::POST('/category/update/{id}',[
        'uses' => 'CategoriesController@update',
        'as' => 'category.update'
    ]);

    // Tag
    Route::get('/tags',[
        'uses' => 'TagsController@index',
        'as' => 'tags'
    ]);

    Route::get('/tag/edit/{id}',[
        'uses' => 'TagsController@edit',
        'as' => 'tag.edit'
    ]);

    Route::get('/tag/create',[
        'uses' => 'TagsController@create',
        'as' => 'tag.create'
    ]);

    Route::post('/tag/store',[
        'uses' => 'TagsController@store',
        'as' => 'tag.store'
    ]);

    Route::post('/tag/update/{id}',[
        'uses' => 'TagsController@update',
        'as' => 'tag.update'
    ]);

    Route::get('/tag/delete/{id}',[
        'uses' => 'TagsController@destroy',
        'as' => 'tag.delete'
    ]);

             
    // User
    Route::get('/users',[
        'uses' => 'UsersController@index',
        'as' => 'users'
    ]);

    Route::get('/user/create',[
        'uses' => 'UsersController@create',
        'as' => 'user.create'
    ]);

    Route::post('/user/store',[
        'uses' => 'UsersController@store',
        'as' => 'user.store'
    ]);

    Route::get('/user/admin/{id}',[
        'uses' => 'UsersController@admin',
        'as' => 'user.admin'
    ])->middleware('admin');

    Route::get('/user/not_admin/{id}',[
        'uses' => 'UsersController@not_admin',
        'as' => 'user.not.admin'
    ]);

    Route::get('/user/profile',[
        'uses' => 'profilesController@index',
        'as' => 'user.profile'
    ]);
    
    Route::get('/user/delete/{id}',[
        'uses' => 'UsersController@destroy',
        'as' => 'user.delete'
    ]);

    Route::post('/user/profile/update',[
        'uses' => 'profilesController@update',
        'as' => 'user.profile.update'
    ]);

    Route::get('/settings',[
        'uses' => 'SettingsController@index',
        'as' => 'settings'
    ]);

    Route::post('/settings/update',[
        'uses' => 'SettingsController@update',
        'as' => 'settings.update'
    ]);
});
