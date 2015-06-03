<?php

namespace Ubicacion\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ubicacion\MainBundle\Entity\Lugar;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MapaController extends Controller
{
	public function ubicacionAction(Request $request)
		{
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
		return $this->render('UbicacionMainBundle:Default:lugar.html.twig');			
	}
	
}
