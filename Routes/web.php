<?php

Route::prefix('epanel/content')->as('epanel.')->middleware(['auth', 'check.permission:Pengumuman'])->group(function() 
{
    Route::resources([
        'pengumuman' => 'PengumumanController'
    ]);
});