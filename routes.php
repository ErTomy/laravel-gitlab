<?php

use Ertomy\Gitlab\Middleware\AuthDeployUsers;


Route::group(['prefix' => 'gitlabdeploy',  'middleware' => ['web', 'auth', AuthDeployUsers::class]], function()
{

    Route::get('/', 'Ertomy\Gitlab\Controllers\DeployController@index');
    Route::get('/updates', 'Ertomy\Gitlab\Controllers\DeployController@updates')->name('gitdeploy.updates');
    Route::get('/logs', 'Ertomy\Gitlab\Controllers\DeployController@logs')->name('gitdeploy.logs');
    
    Route::post('updates', 'Ertomy\Gitlab\Controllers\DeployController@update');
    Route::post('updates/end', 'Ertomy\Gitlab\Controllers\DeployController@updateCommit');

    Route::get('/migrate', 'Ertomy\Gitlab\Controllers\DeployController@migrate')->name('gitdeploy.migrate');
    Route::post('/migrate', 'Ertomy\Gitlab\Controllers\DeployController@migrateExecute')->name('gitdeploy.migrate.execute');
});