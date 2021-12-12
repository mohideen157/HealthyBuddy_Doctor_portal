<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Helpers\Helper;

use App\Model\Notification;
use App\User;
use Auth;

use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->composer('admin/*', function ($view) {
			if (Auth::check()) {
				$user = Auth::user();

				$notifications = array();

				$unread_count = $user->notifications()->unread()->count();

				if ($unread_count > 0) {
					$notifications = $user->notifications()->unread()->take(5)->select('id', 'subject', 'body', 'created_at')->orderBy('created_at', 'desc')->get();
				}

				$notification_arr = array(
					'count' => $unread_count,
					'notifications' => $notifications
				);

				$view->with('notifications', $notification_arr);
			}
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
