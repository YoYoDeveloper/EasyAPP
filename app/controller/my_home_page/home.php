<?php

/**
* @package      Home page example
* @version      v1.0.0
* @author       YoYo
* @copyright    Copyright (c) 2022, script-php.ro
* @link         https://script-php.ro
*/

class ControllerMyHomePageHome extends Controller {

	
	function __construct($registry) {
		$this->registry = $registry;
	}
	

	function index() {
		// show or do something something when index.php?route=home or index.php?route=home/index its accessed

		$this->load->language('my_language'); // load the language

		$data['title'] = $this->language->get('title');
		$data['body'] = $this->language->get('text');

		// $this->load->controller('my_error_page/error');
		$this->load->model('another_model/another_one');

		// $this->settings->edit('general_website', [
		// 	'key' => [1,2,3],
		// 	'key2' => 123,
		// 	'key3' => '123'
		// ]);

		// $this->settings->delete('general');

		// $settings = $this->settings->all('general');

		// $this->settings->add('general', [
		// 	'general_url' => 'https://smehh.com',
		// 	'general_website' => 'Smehh',
		// 	'general_serialize' => [
		// 		'ceva'=>'da',
		// 		'altceva'
		// 	]
		// ]);
		
		// $this->settings->deleteKey('general_website');
		// $this->settings->delete('general');
		
		$this->response->setOutput($this->load->view('my_folder/my_view.html', $data));
		
	}


	function controllers() {
		// you cann use call controllers in other controller in 2 ways:
		$data = []; 

		// in this way we use index method
		$this->load->controller('path/controller', $data); 

		// or
		// if we want to use any method from controller
		$this->load->var_controller('path/controller');
		$this->controller_path_controller->method();
	}
	

	function utils() {
		// show or do something something when index.php?route=home/utils its accessed
		
		$text = "This is an example !@#$%^&*()_+:|<>,.?/{}][";

		// example #1
		$chars2html = $this->util->chars2Html($text); // text to html
		$html2chars = $this->util->html2Chars($chars2html); // html to text
		echo $html2chars;

		// example #2
		$check = $this->util->checkChars($text, "abcdefghijklmnopqrstuvwxyz");
		if(!$check) {
			pre('The text contains more characters than accepted');
		}

		// example #3
		$check = $this->util->contains($text, 'exampl');
		if($check) {
			pre('the string contains this piece of text');
		}

		// example #4
		pre($this->util->file2Class('my_new_home_page'));

		// example #5
		pre($this->util->class2File('MyNewHomePage'));

		// example #6
		$minlength = 5;
		$maxlength = 30;
		$uselower = true;
		$useupper = true;
		$usenumbers = true;
		$usespecial = false;
		$random = $this->util->random($minlength, $maxlength, $uselower, $useupper, $usenumbers, $usespecial);
		pre($random);

		// example #7
		$text = "This is a                     						text with 							            a 



		lot of           				whitespaces and new lines.";
		pre($this->util->textIntegrity($text));

	}


	function model_usage() {

		$this->load->model('another_model/another_one');

		$users = $this->model_another_model_another_one->test();

		foreach($users as $user) {
			echo $user['name'];
		}

	}

	function controller_usage() {

		$this->load->controller('error');

		echo $this->controller_error->index();

	}


	function db_usage() {
		// show or do something something when index.php?route=home/db_usage its accessed

		// How to use a database:
		$users = $this->db->query("SELECT * FROM users WHERE validated='1' AND active=:active", [
			':active'		=> '1',
			':something'	=> 'something'
		]);

		//How to use a different database:
		$files = $this->db->query("SELECT * FROM users");
	}


	// show or do something something when index.php?route=home/show_template its accessed
	function show_template() {
		// here you have two options:

		// first one is when you just want to populate the template with data, 
		// the template will be like this: <div>{CONTENT}</div>
		$data['body'] = 'Show you content!';
		echo $this->load->view('base.html', $data, false);

		// OR
		// when you need to use variables in the template
		// the template will be like this:
		/* <div><?php foreach($posts as $post) { ?>
				<div><?php echo $post; ?>
			<?php } ?></div>
		*/
		$data['posts'] = array('post 1', 'post 2');
		echo $this->load->view('base_v2.html', $data);

	}

}
