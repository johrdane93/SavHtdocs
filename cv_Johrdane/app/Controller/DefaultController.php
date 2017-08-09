<?php

namespace Controller;

use \W\Controller\Controller;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

	public function a_propos ()
	{
		$this->show('default/a_propos');
	}
	public function CompetancesTechniques ()
	{
		$this->show('default/CompetancesTechniques');
	}
	public function Console ()
	{
		$this->show('default/Console');
	}
	public function Contact ()
	{
		$this->show('default/Contact');
	}
	public function Portfolio ()
	{
		$this->show('default/Portfolio');
	}

}
