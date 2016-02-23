<?php

namespace PhotoGallery\Controller;

use ControlPanel\Controller\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController
{
	/**
	 * Método responsável pela inicialização e atribuição de alguns valores após o bootstrap para o correto funcionamento do plugin.
	 *
	 * @return void
	 */
	public function initialize(){
		parent::initialize();
    $this->viewBuilder()->helpers(['Form' => ['className' => 'MswAgencia.Form']]);
	}
}
