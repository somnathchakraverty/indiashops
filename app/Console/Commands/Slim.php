<?php namespace indiashopps\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Slim extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:slim';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command to generate Slim Index and JSON file.. This will hit a URL';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */

	private $urls = [
	    'http://backend.yourshoppingwizard.com/live_data',
        'http://backend.yourshoppingwizard.com/blogs',
    ];
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        foreach( $this->urls as $url )
        {
            file_get_contents($url);
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}

}
