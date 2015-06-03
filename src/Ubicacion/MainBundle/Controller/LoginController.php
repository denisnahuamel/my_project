<?php

namespace Ubicacion\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ubicacion\MainBundle\Entity\Usuario;
use Ubicacion\MainBundle\Entity\Lugar;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
	public function verificarAction(Request $request)
	{
		/*==================Verificar si usuario esta registrado===========================*/
		$session=$request->getSession();
		if($session->has("id")){
			return $this->render('UbicacionMainBundle:Default:index.html.twig');
		}else{
			$this->get('session')->getFlashBag()->add(
					'mensaje',
					'debe estar logueado para ver este contenido'
			);
			return $this->redirect($this->generateUrl('inicio_login'));//lo envia a la pagina de acceso
		}
		//=============================================================================
		return $this->render('UbicacionMainBundle:Default:home.html.twig');
		/*$em=$this->getDoctrine()->getManager();
		$query=$em->createQuery(
				'SELECT p.titulo, p.detalle, c.id as id_categoria, c.nombre as categoria
    			FROM TrabajobdBundle:Noticias p
    			JOIN TrabajobdBundle:categoria c WITH c.id=p.id'
		);
		//$datos=$query->getResult();
		$datos=$query->getResult();
		return $this->render('TrabajobdBundle:Default:index.html.twig',array("datos"=>$datos));*/
	}
	public function homeAction(Request $request)
	{
		//==========================Verifica si es un usuario=========================
		$session=$request->getSession();
		if($session->has("id")){
			return $this->render('UbicacionMainBundle:Default:home.html.twig');
			$session->clear();
		}else{
			$this->get('session')->getFlashBag()->add(
					'mensaje',
					'debe estar logueado para ver este contenido'
			);
			return $this->redirect($this->generateUrl('inicio_login'));
		}
		//===============================================================================
		return $this->render('UbicacionMainBundle:Default:home.html.twig');
	}
	public function loginAction(Request $request)//recibe los datos enviados mediante el metodo action del formulario
	{
		if($request->getMethod()=="POST"){
			$correo=$request->get("correo");//almacena el correo y la contraseña en sus respectivas variables
			$password=$request->get("password");
			$user=$this->getDoctrine()->getRepository('UbicacionMainBundle:Usuario')
			->findOneBy(array("correo"=>$correo, "password"=>$password));
			if($user){
				$session=$request->getSession();//recibimos los datos de la sesion
				$session->set("id",$user->getId());//almacenamos datos enviados por $request
				$session->set("nombre",$user->getnombre());
				$session->set("correo",$user->getcorreo());
				$session->set("password",$user->getpassword());
				//redireccionamos a la pagina que solo pueden ver los
				//usuarios
				return $this->redirect($this->generateUrl('ubicacion_otro'));
			}
			else{
				$this->get('session')->getFlashBag()->add(
						'mensaje',
						'email o password incorrectos'
				);
				return $this->redirect($this->generateUrl('inicio_login'));
			}
		}
		 
		return $this->render('UbicacionMainBundle:Default:login.html.twig');
	}
	public function logoutAction(Request $request){
		$session=$request->getSession();//recibimos los datos de la sesion
		$session->clear();
		$this->get('session')->getFlashBag()->add(
				'mensaje',
				'se ha cerrado sesion correctamente'
		);
		return $this->redirect($this->generateUrl('inicio_login'));
	}
	
	public function ubicacionAction(Request $request)
	{
		/*==================Verificar si usuario esta registrado===========================*/
		$session=$request->getSession();
		if($session->has("id")){
			return $this->render('UbicacionMainBundle:Default:ubicacion.html.twig');
		}else{
			$this->get('session')->getFlashBag()->add(
					'mensaje',
					'debe estar logueado para ver este contenido'
			);
			return $this->redirect($this->generateUrl('inicio_login'));//lo envia a la pagina de acceso
		}
		//=============================================================================
		$descrip='a';
		$titulo='b';
		if($request->getMethod()=="POST"){
			$lat=$request->get("latitud");//almacena latitud, altitud, descripcion, y titulo del lugar
			$long=$request->get("altitud");
			$descrip=$request->get("descripcion");
			$titulo=$request->get("titulo");
			$lugar =new Lugar();
			$lugar->setLongitud($lat);//se envian los datos a la entidad lugar
			$lugar->setLatitud($long);
			$lugar->setNombre($descrip);
			$lugar->setCategoria($titulo);
			$em=$this->getDoctrine()->getManager();//se conecta con la base de datos
			$em->persist($lugar);//se guarda los datos en la base de datos
			$em->flush();//se cierra la conexion
		}
		return $this->render('UbicacionMainBundle:Default:ubicacion.html.twig');
	}
}
