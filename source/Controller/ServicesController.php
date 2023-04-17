<?php

namespace Source\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Source\PageAdmin;
use Source\Model\Service;

class ServicesController extends Controller
{
	public static $msgError = "Selecione uma imagem válida.";
	public static $path = "storage/images";
	public static $folder = "services";

	public function index()
	{		
		
		$pg = $this->pagination('Service','/admin/services');
		$page = new PageAdmin();
		$page->setTpl("services", array(
			"services" => $pg['data'],
			"search" => $pg['search'],
			"pages"=> $pg['pages']
		));exit;		
	}

	public function create()
	{
		$page = new PageAdmin();
		$page->setTpl("services-create", [
			'msgError' => Service::getError(),
			'scripts' => ['https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js','/public/assets/admin/js/form.js']
		]);exit;
	}

	public function store(Request $request, Response $response, array $args)
	{
		$data = filter_var_array($request->getParsedBody(), FILTER_SANITIZE_STRIPPED);

		$service = new Service(); 
		$service->setData($data);
		$service->save();
		unset($_SESSION['recoversPost']);
		header("Location:/admin/servicos-online");
		exit;
	}

	public function destroy(Request $request, Response $response, array $args)
	{
		$service = new Service();
		$service->get((int) $args['id']);
	
		$service->delete();
		header("Location: /admin/servicos-online");
		exit;
	}

	public function edit(Request $request, Response $response, array $args)
	{
		$service = new Service();
		$service->get((int) $args['id']);
		$page = new PageAdmin();
		$page->setTpl("services-update", [
			"service" => $service->getValues(),
			'msgError' => Service::getError(),
			'scripts' => ['https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js','/public/assets/admin/js/form.js']
		]);exit;
	}

	public function update(Request $request, Response $response, array $args)
	{
		$sevice = new Service();
		$sevice->get((int) $args['id']);

		unset($_POST['_METHOD']);
		
		$sevice->setData($_POST);
		$sevice->save();

		header("Location:/admin/servicos-online/".$args['id']);
		exit;
	}

}//End Class