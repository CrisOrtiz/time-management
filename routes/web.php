<?php

Route::get('login', 'AuthController@showLogin')->name('login');

Route::get('logout', 'AuthController@logout')->name('logout');

Route::post('login', 'AuthController@login');

Route::get('register', 'AuthController@showRegister')->name('register');

Route::post('register', 'AuthController@create')->name('register');

Route::post('managerregister', 'AuthController@managerCreate')->name('manager.register');

Route::post('managerdelete', 'AuthController@managerDelete')->name('manager.delete.user');

Route::post('managerupdate', 'AuthController@managerUpdate')->name('manager.update.user');

Route::post('adminregister', 'AuthController@adminCreate')->name('admin.register');

Route::post('admindelete', 'AuthController@adminDelete')->name('admin.delete.user');

Route::post('adminupdate', 'AuthController@adminUpdate')->name('admin.update.user');


Route::group(['middleware' => 'auth'], function () {
    Route::get('', function () {
        return redirect()->to('login');
    });

    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::group(['prefix' => 'worker'], function () {
        Route::get('{userId}/settings','WorkerController@showHomeWorker')->name('worker.home');
        Route::get('{userId}/tasks','WorkerController@showListWorker')->name('worker.list');
        Route::get('mytasks', 'WorkerController@getWorkerTasks')->name('get.worker.tasks');
        Route::post('updatepreferred', 'WorkerController@updatePreferred')->name('worker.update.preferred');
        Route::post('updateuserdata', 'WorkerController@updateUserData')->name('worker.update.data');
        Route::post('updateuserpassword', 'WorkerController@updateUserPassword')->name('worker.update.password');
        Route::post('createtask', 'TaskController@createTask')->name('task.create');
        Route::post('deletetask', 'TaskController@deleteTask')->name('task.delete');
        Route::post('updatetask', 'TaskController@updateTask')->name('task.update');
        Route::get('gettasks', 'TaskController@getTasks')->name('tasks.get');
        Route::post('getfilteredtasks', 'TaskController@getFilteredTasks')->name('tasks.filtered.get');
        Route::post('getsortedtasks', 'TaskController@getSortedTasks')->name('tasks.sorted.get');
        Route::resource('Task', 'TaskController');
        
    });

    Route::group(['prefix' => 'manager'], function () {
        Route::get('','ManagerController@showHomeManager')->name('manager.home');
        Route::get('workers','ManagerController@showListManager')->name('manager.list');
        Route::post('managerupdateuserdata', 'ManagerController@updateUserData')->name('manager.update.data');
        Route::post('managerupdateuserpassword', 'ManagerController@updateUserPassword')->name('manager.update.password');
        Route::post('managergetsortedworkers', 'ManagerController@getSortedWorkers')->name('workers.sorted.get');
        
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('','AdminController@showHomeAdmin')->name('admin.home');        
        Route::get('workers','AdminController@showListAdmin')->name('admin.list');        
        Route::post('adminupdateuserdata', 'AdminController@updateUserData')->name('admin.update.data');
        Route::post('adminupdateuserpassword', 'AdminController@updateUserPassword')->name('admin.update.password');
        Route::post('admingetnamesortedworkers', 'AdminController@getSortedNameWorkers')->name('admin.name.sorted.get');
        Route::post('admingetusertypesortedworkers', 'AdminController@getSortedUserTypeWorkers')->name('admin.usertype.sorted.get');
        Route::get('worker/tasks/{userId}','AdminController@showListWorker')->name('admin.worker.list');
        Route::get('{userId}/settings','AdminController@showHomeWorker')->name('admin.worker.home');
        Route::get('{userId}/tasks','AdminController@showListWorker')->name('admin.worker.list');
    });

});

