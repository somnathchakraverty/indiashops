<?php namespace indiashopps\Commands;



use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use indiashopps\Http\Controllers\FcmController;

class FcmNotification implements ShouldQueue {

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $data;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct( $data = '' )
	{
		$this->data = $data;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$fcm = new FcmController;
		$fcm->sendNotifications($this->data);
	}

}
