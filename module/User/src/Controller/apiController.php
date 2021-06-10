<?php

namespace User\Controller;

use User\Entity\mapsEntity;
use User\Entity\corpEntity;
use User\Entity\datosDeUsuarioEntity;
use User\Entity\espacio_disponibleEntity;
use User\Entity\inquilino_naveEntity;
use User\Entity\logEntity;
use User\Entity\naveEntity;
use User\Entity\copomexEntity;
use User\Entity\parqueEntity;
use User\Entity\parquesuserEntity;
use User\Entity\userEntity;
use User\Entity\Role;
use User\Entity\userRole;
use User\Entity\extrasEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


class apiController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    private $url;
    private $mailFactory;

    public function __construct($entityManager, $mailFactoy)
    {
        $this->url = "http://localhost:8000/panel/#/";
        $this->entityManager = $entityManager;
        $this->mailFactory =$mailFactoy;

    }

    //******************SOLO PERMISOS*********************

    public function getPermision($id)
    {
        $permision = $this->entityManager->getRepository(userRole::class)->findBy(['user_id' => $id]);
        $result = [];

        foreach ($permision as $role) {
            if ($role->getId() != "") {
                $result["role_id"] = $role->getRoleId();
            } else {
                $result["error"] = 0;
            }
        }
        $getType = $this->entityManager->getRepository(Role::class)->findById($result["role_id"]);
        $result = [];

        foreach ($getType as $role) {
            if ($role->getId() != "") {
                $result["name"] = $role->getName();
            } else {
                $result["error"] = 0;
            }
        }
        return $result;
    }

    public function getcargo($id)
    {
        //$id = $this->params()->fromPost('id', '');
        $id_user = $this->entityManager->getRepository(userEntity::class)->findById($id);

        $list = [];
        foreach ($id_user as $ids) {
            $list["ids"] = $ids->gettypeOfUser();
        }

        $search_cargo = $this->entityManager->getRepository(Role::class)->findById($list["ids"]);

        $cargos = [];
        foreach ($search_cargo as $cargo) {
            $cargos["cargo"] = $cargo->getName();
        }
        return $cargos["cargo"];
    }

    public function  getparquesusuariosAction()
    {
        if ($this->getRequest()->isPost()) {
            $query = $this->params()->fromPost("query");
            switch ($query){
                case 1:
                    $id = $this->params()->fromPost("id");
                    $permisos = $this->entityManager->getRepository(parquesuserEntity::class)->findBy(["persona" => $id]);
                    $arr = array();
                    $rolepermisos = [];

                    foreach ($permisos as $permiso) {
                        $rolepermisos["permiso"] = $permiso->getpermiso();
                        $rolepermisos["id"] = $permiso->getid();
                        array_push($arr, $rolepermisos);
                    }

                    return new JsonModel($arr);
                break;
                case 2:
                    $id = $this->params()->fromPost("id_parque");
                    $permisos = $this->entityManager->getRepository(parquesuserEntity::class)->findBy(["id_parque" => $id]);
                    $arr = array();
                    

                    foreach ($permisos as $permiso) {
                        $id_people = $permiso->getPersona();
                        $search = $this->entityManager->getRepository(userEntity::class)->findById($id_people);
                        $items = [];
                        foreach($search as $item){
                            $items['id']  = $item->getId();
                            $items['email']  = $item->getEmail();
                            $items['fullName']= $item->getFullName();
                            $items['status'] = $item->getStatus();
                            $items['permisos'] = $permiso->getpermiso();
                        }
                        array_push($arr, $items);
                    }

                    return new JsonModel($arr);
                break;
                default:
                    return new JsonModel(["message"=>"sin query"]);
            }
        } else {
            return new JsonModel(["message" => "ruta post"]);
        }
    }
    /*
     * datosDelCorporativo CRUD
     *
     */
    public function corpAction()
    {
        if ($this->getRequest()->isPost()) {

            if ($this->getRequest()->isPost()) {
                $identify = $this->params()->fromPost('id', '');
                $response = $this->entityManager->getRepository(corpEntity::class)->findById($identify);
                $result = [];
                foreach ($response as $role) {
                    if ($role->getId() != "") {
                        $result["id"] = $role->getid();
                        $result["corporativo"] = $role->getcorporativo();
                        $result["nombre_es"] = $role->getnombre_es();
                        $result["nombre_en"] = $role->getnombre_en();
                        $result["tipoDeSocio"] = $role->gettipoDeSocio();
                        $result["rfc"] = $role->getrfc();
                        $result["direccion"] = $role->getdireccion();
                        $result["cp"] = $role->getcp();
                        $result["colonia"] = $role->getcolonia();
                        $result["estado"] = $role->getestado();
                        $result["municipio"] = $role->getmunicipio();
                        $result["celular"] = $role->getcelular();
                        $result["logo"] = $role->getlogo();
                        $result["inversionAnualSiguiente"] = $role->getinversionAnualSiguiente();
                        $result["inversionRealizadaActual"] = $role->getinversionRealizadaActual();
                        $result["inversionRealizadaAnterior"] = $role->getinversionRealizadaAnterior();
                        $result["validadoPor"] = $role->getvalidadoPor();
                        $result["fechaDeValidacion"] = $role->getfechaDeValidacion();
                        $result["fechaDeAlta"] = $role->getfechaDeAlta();
                        $result["fechaDeBaja"] = $role->getfechaDeBaja();
                        $result["status"] = $role->getstatus();
                        $result["habilitar"] = $role->gethabilitar();
                    } else {
                        $result["error"] = "2541";
                    }
                }

                return new JsonModel($result);
            } else {
                return $this->redirect()->toUrl(
                    $this->url
                );
            }
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function getallcorpAction()
    {
        if ($this->getRequest()->isPost()) {

                $query = $this->params()->fromPost("query");
                
                switch ($query) {
                    case 1:
                        $response = $this->entityManager->getRepository(corpEntity::class)->findBy(["tipoDeSocio"=>"Desarrollador"]);
                        $arrCorps = array();
                        $result = [];
                        foreach ($response as $role) {
                            if ($role->getId() != "") {
                                $result["id"] = $role->getid();
                                $result["corporativo"] = $role->getcorporativo();
                                $result["nombre_es"] = $role->getnombre_es();
                                $result["nombre_en"] = $role->getnombre_en();
                                $result["tipoDeSocio"] = $role->gettipoDeSocio();
                                $result["rfc"] = $role->getrfc();
                                $result["direccion"] = $role->getdireccion();
                                $result["cp"] = $role->getcp();
                                $result["colonia"] = $role->getcolonia();
                                $result["estado"] = $role->getestado();
                                $result["municipio"] = $role->getmunicipio();
                                $result["celular"] = $role->getcelular();
                                $result["logo"] = $role->getlogo();
                                $result["inversionAnualSiguiente"] = $role->getinversionAnualSiguiente();
                                $result["inversionRealizadaActual"] = $role->getinversionRealizadaActual();
                                $result["inversionRealizadaAnterior"] = $role->getinversionRealizadaAnterior();
                                $result["validadoPor"] = $role->getvalidadoPor();
                                $result["fechaDeValidacion"] = $role->getfechaDeValidacion();
                                $result["fechaDeAlta"] = $role->getfechaDeAlta();
                                $result["fechaDeBaja"] = $role->getfechaDeBaja();
                                $result["status"] = $role->getstatus();
                                $result["habilitar"] = $role->gethabilitar();
                                $result["type"] = $role->getType();
                                array_push($arrCorps, $result);
                            } else {
                                $result["error"] = "2541";
                            }
                        }
                        return new JsonModel($arrCorps);
                        break;
                    case 2:
                        $response = $this->entityManager->getRepository(corpEntity::class)->findBy(["tipoDeSocio"=>"Patrocinador"]);
                        $arrCorps = array();
                        $result = [];
                        foreach ($response as $role) {
                            if ($role->getId() != "") {
                                $result["id"] = $role->getid();
                                $result["corporativo"] = $role->getcorporativo();
                                $result["nombre_es"] = $role->getnombre_es();
                                $result["nombre_en"] = $role->getnombre_en();
                                $result["tipoDeSocio"] = $role->gettipoDeSocio();
                                $result["rfc"] = $role->getrfc();
                                $result["direccion"] = $role->getdireccion();
                                $result["cp"] = $role->getcp();
                                $result["colonia"] = $role->getcolonia();
                                $result["estado"] = $role->getestado();
                                $result["municipio"] = $role->getmunicipio();
                                $result["celular"] = $role->getcelular();
                                $result["logo"] = $role->getlogo();
                                $result["inversionAnualSiguiente"] = $role->getinversionAnualSiguiente();
                                $result["inversionRealizadaActual"] = $role->getinversionRealizadaActual();
                                $result["inversionRealizadaAnterior"] = $role->getinversionRealizadaAnterior();
                                $result["validadoPor"] = $role->getvalidadoPor();
                                $result["fechaDeValidacion"] = $role->getfechaDeValidacion();
                                $result["fechaDeAlta"] = $role->getfechaDeAlta();
                                $result["fechaDeBaja"] = $role->getfechaDeBaja();
                                $result["status"] = $role->getstatus();
                                $result["habilitar"] = $role->gethabilitar();
                                array_push($arrCorps, $result);
                            } else {
                                $result["error"] = "2541";
                            }
                        }
                        return new JsonModel($arrCorps);
                        break;
                    default:
                        return new JsonModel(["message"=>"eror"]);
                }


        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //admin permisos
    public function createcorpAction()
    { 
        if ($this->getRequest()->isPost()) {
            $corporativo = $this->params()->fromPost("corporativo");
            $nombre_es = $this->params()->fromPost("nombre_es");
            $nombre_en = $this->params()->fromPost("nombre_en");
            $tipoDeSocio = $this->params()->fromPost("tipoDeSocio", "");
            $direccion = $this->params()->fromPost("direccion", "");
            $cp = $this->params()->fromPost("cp", "");
            $colonia = $this->params()->fromPost("colonia", "");
            $estado = $this->params()->fromPost("estado", "");
            $municipio = $this->params()->fromPost("municipio", "");
            $telefono = $this->params()->fromPost("telefono", "");
            $logo = $this->params()->fromPost("logo", "");
            $inversionAnualSiguiente = $this->params()->fromPost("inversionAnualSiguiente", "");
            $inversionRealizadaActual = $this->params()->fromPost("inversionRealizadaActual", "");
            $inversionRealizadaAnterior = $this->params()->fromPost("inversionRealizadaAnterior", "");
            $validadoPor = $this->params()->fromPost("validadoPor", "");
            $status = $this->params()->fromPost("status", "");
            $habilitar = $this->params()->fromPost("habilitar", "");
            $rfc = $this->params()->fromPost("rfc", "");
            $idDeUsuario = $this->params()->fromPost("id", null);
            $type = $this->params()->fromPost("type");
            $isDispo = $this->entityManager->getRepository(corpEntity::class)->findBy(['corporativo' => $corporativo]);


            if (true) {
                $corporativoNew = new corpEntity();
                $corporativoNew->setcorporativo($corporativo);
                $corporativoNew->setnombre_es($nombre_es);
                $corporativoNew->setnombre_en($nombre_en);
                $corporativoNew->settipoDeSocio($tipoDeSocio);
                $corporativoNew->setrfc($rfc);
                $corporativoNew->setdireccion($direccion);
                $corporativoNew->setcp($cp);
                $corporativoNew->setcolonia($colonia);
                $corporativoNew->setestado($estado);
                $corporativoNew->setmunicipio($municipio);
                $corporativoNew->setcelular($telefono);
                $corporativoNew->setlogo($logo);
                $corporativoNew->setinversionAnualSiguiente($inversionAnualSiguiente);
                $corporativoNew->setinversionRealizadaActual($inversionRealizadaActual);
                $corporativoNew->setinversionRealizadaAnterior($inversionRealizadaAnterior);
                $corporativoNew->setvalidadoPor($validadoPor);
                $corporativoNew->setfechaDeValidacion(date('Y-m-d H:i:s'));
                $corporativoNew->setstatus($status);
                $corporativoNew->sethabilitar($habilitar);
                $corporativoNew->setType($type);
                $this->entityManager->persist($corporativoNew);
                $this->entityManager->flush();

                $getId = $this->entityManager->getRepository(corpEntity::class)->findBy(["rfc" => $rfc]);

                $idKey_corp = [];
                foreach ($getId as $i) {
                    $idKey_corp["id"] = $i->getId();
                }

                $update = $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUser(".key_corp", $idKey_corp["id"], $idDeUsuario);


                return new JsonModel(["message", "listo"]);
            } else {
                return new JsonModel(["message" => "El usuario " . $rfc . " ya tiene una cuenta"]);
            }
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //admin permisos
    public function updatecorpAction()
    {
        if ($this->getRequest()->isPost()) {
            //Id del usuario que edita
            $id_key = $this->params()->fromPost("id", );
            if (true) {
                //id del corporativo no cambiable

                $nombre_es = $this->params()->fromPost("nombre_es", null);
                $nombre_en = $this->params()->fromPost("nombre_en", null);
                $direccion = $this->params()->fromPost("direccion", null);
                $rfc = $this->params()->fromPost("rfc", null);
                $cp = $this->params()->fromPost("cp", null);
                $colonia = $this->params()->fromPost("colonia", null);
                $estado = $this->params()->fromPost("estado", null);
                $municipio = $this->params()->fromPost("municipio", null);
                $telefono = $this->params()->fromPost("telefono", null);
                $inversionAnualSiguiente = $this->params()->fromPost("inversionAnualSiguiente", null);
                $inversionAnualActual = $this->params()->fromPost("inversionAnualActual", null);
                $inversionAnualAnterior = $this->params()->fromPost("inversionAnualAnterior", null);
                $habilitar = $this->params()->fromPost("habilitar", null);
                $search = $this->entityManager->getRepository(corpEntity::class)->findById($id_key);

                if ($search != null) {
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".nombre_es", $nombre_es, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".nombre_en", $nombre_en, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".direccion", $direccion, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".cp", $cp, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".rfc", $rfc, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".colonia", $colonia, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".estado", $estado, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".municipio", $municipio, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".celular", $telefono, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".inversionAnualSiguiente", $inversionAnualSiguiente, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".inversionRealizadaActual", $inversionAnualActual, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".inversionRealizadaAnterior", $inversionAnualAnterior, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".habilitar", $habilitar, $id_key);
                    $this->entityManager->getRepository(corpEntity::class)->updateUser(".fechaDeValidacion", date('Y-m-d H:i:s'), $id_key);
                    return new JsonModel(["message" => "listo"]);
                } else {
                    $this->logs("El usuario con id  intento actualizar la corporacion con id ", 0);
                    return new JsonModel(["message" => "corporacion no encontrada"]);
                }
            } else {
                $this->logs("El usuario con id $id intento actualizar la corṕoracion con id   $id_key pero no tiene suficientes permisos", $id);
                return new JsonModel(["message" => "permiso insuficiente"]);
            }
        } else {
            $this->logs("se intento acceder a la ruta mediante get", 0);
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function getallcorpsAction()
    {
        if ($this->getRequest()->isPost()) {
            $corps = $this->entityManager->getRepository(corpEntity::class)->findAll();
            $arregloCorps = array();
            $listCorps = [];
            foreach ($corps as $item) {
                $listCorps['id'] = $item->getid();
                $listCorps['rfc'] = $item->getrfc();
                $listCorps['name'] = $item->getnombre_es();
                $listCorps['status'] = $item->getstatus();

                array_push($arregloCorps, $listCorps);
            }
            $this->logs("Se obtubieron todas las corporaciones", "ADMIN");
            return new JsonModel($arregloCorps);
        } else {
            $this->logs("Se intento acceder a la ruta obtener corporaciones", "desc");
            return $this->redirect()->toUrl(
                $this->url
            );   
        }
    }

    public function getallusercorpAction()
    {
        if ($this->getRequest()->isPost()) {
            $users = $this->entityManager->getRepository(userEntity::class)->findAll();

            $arregloUsuario = array();
            $listUsuario = [];

            foreach ($users as $item) {
                $listUsuario['id'] = $item->getId();
                $listUsuario['email'] = $item->getEmail();
                $listUsuario['name'] = $item->getFullName();
                $listUsuario['pass'] = $this->encript("dec", $item->getPassword() , "4MP1P");

                if( $item->getStatus() != 0  && $item->getFullName() != "Administrator"){
                    array_push($arregloUsuario, $listUsuario);
                } 
            }
            $this->logs("Se obtubieron todos los usuarios", "ADMIN");
            return new JsonModel($arregloUsuario);
        } else {
            $this->logs("Se intento obtener uruarios por el metodo get", "desc");
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    /*
     * 
     * usuario CRUD
     *
     */
    public function loginAction()
    {
        if ($this->getRequest()->isPost()) {

            $email = $this->params()->fromPost('email', 'q');
            $pass = $this->params()->fromPost('pass', 'q');
            /*  $this->encript("dec", $item->getPassword() , "4MP1P"); */
            $decryptPass = $this->encript("enc", $pass, "4MP1P");
            $response = $this->entityManager->getRepository(userEntity::class)->findBy(['email' => $email, 'password' => $decryptPass, 'status' => 1]);
            $roleList = [];
            foreach ($response as $role) {
                if ($role->getStatus() != 0) {
                    $roleList["id"] = $role->getId();
                    $roleList["name"] = $role->getFullName();
                    $roleList["email"] = $role->getEmail();
                    $roleList["userForAmpip"] = $role->getuseForAmpi();
                    $roleList["cargo"] = $role->gettypeOfUser();
                } else {
                    $roleList["error"] = "Usuario no reconocido comunicate con ampip por si el usuario aun no esta registrado";
                }
            }
            $this->logs("el usuario $email inicio secion", $email);
            return new JsonModel([$roleList]);
        } else {
            $this->logs("Se intento hacer login por get", "desc");
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //admin permisos
    public function createuserAction()
    {

        if ($this->getRequest()->isPost()) {
            $email = $this->params()->fromPost("email", "");
            $fullName = $this->params()->fromPost("fullname");
            $pass = $this->params()->fromPost("pass", "");
            $userForAmpip = $this->params()->fromPost("useForAmpi", "");
            $typeOfUser = $this->params()->fromPost("typeOfUser", 0);
            $user = $this->entityManager->getRepository(userEntity::class)->findBy(['email' => $email]);


            if ($user == null) {
                $news = new userEntity();
                $news->setEmail($email);
                $news->setFullName($fullName);
                $news->setPassword($this->encript("enc", $pass, "4MP1P"));
                $news->setStatus(1);
                $news->setDateCreated(date('Y-m-d H:i:s'));
                $news->settypeOfUser(intval($typeOfUser));
                $news->setuseForAmpi(intval($userForAmpip));


                // Add the entity to the entity manager.
                $this->entityManager->persist($news);

                // Apply changes to database.
                $this->entityManager->flush();

                //crear la liga del usuario con su rol o tipo de usuario
                $idOfUser = $this->entityManager->getRepository(userEntity::class)->findBy(["email" => $email]);
                $id = null;

                foreach ($idOfUser as $user) {
                    $id = $user->getId();
                }
                if ($id != null) {
                    $role = new userRole();
                    $role->setUserid($id);
                    $role->setRoleid(4);
                    // Add the entity to the entity manager.
                    $this->entityManager->persist($role);

                    // Apply changes to database.
                    $this->entityManager->flush();
                }
                $this->logs("Se dio de alta al usuario $email", $email);
                return new JsonModel(["message" => 1]);
            } else {
                $this->logs("Se intento dar de alta al usuario $email", $email);
                return new JsonModel(["message" => 0]);
            }
        } else {
            $this->logs("se intento acceder a la ruta altaUsuarios con get", "desc");
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //cualquier usuario podra editarlo
    public function updateuserAction()
    {
        if ($this->getRequest()->isPost()) {

            $id = $this->params()->fromPost("id");
            $email = $this->params()->fromPost("email");
            $full_name = $this->params()->fromPost("full_name");
            $password = $this->params()->fromPost("password");
            $status = $this->params()->fromPost("status");

            $decryptPass = $this->encript("enc", $password, "4MP1P");
            $user = $this->entityManager->getRepository(userEntity::class)->findBy (['email' => $email, 'password' => $decryptPass]);
            if ($user != null) {
                $this->entityManager->getRepository(userEntity::class)->updateUser(".email", $email, $id);
                $this->entityManager->getRepository(userEntity::class)->updateUser(".fullName", $full_name, $id);
                $this->entityManager->getRepository(userEntity::class)->updateUser(".status", $status, $id);


                $this->entityManager->getRepository(userEntity::class)->updateUser(".passwordResetTokenCreationDate", date('Y-m-d H:i:s'), $id);
                //$this->entityManager->getRepository(userEntity::class)->updateUser(".typeOfUser", $typeOfUser, $id);
                $this->logs("Se modifico el usuario $email", $email);
                return new JsonModel(["message" => 1]);
            } else {
                $this->logs("se intento modificar el usuario $email pero no existe", $email);
                return new JsonModel(["message" => 2]);
            }
        } else {
            $this->logs("Se intento acceder a actualizar usuario por get", "DESC");
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }


    public function getalluserAction()
    {

        if ($this->getRequest()->isPost()) {
            $usersNotAllowed = $this->entityManager->getRepository(userEntity::class)->findBy(['status' => 0]);
            $roleList = [];
            foreach ($usersNotAllowed as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getId();
                    $roleList["name"] = $role->getFullName();
                    $roleList["email"] = $role->getEmail();
                } else {
                    $roleList["error"] = "no hay usuarios";
                }
            }
            $this->logs("Se obtubieron todos los usuarios no activos", "ADMIN");
            return new JsonModel([$roleList]);
        } else {
            $this->logs("Se intento ingresar a la ruta de obtener usuarios con get", "DESC");
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function activeuserAction()
    {
        if ($this->getRequest()->isPost()) {
            $id_key = $this->params()->fromPost("id_key");
            $corpAsig = $this->params()->fromPost("corpAsig");
            $rolasign = $this->params()->fromPost("rolasign");
            $id = $this->params()->fromPost("id");
            $parqueasig = $this->params()->fromPost("parqueasig");

            
            if (true) {
                $this->logs("Se activo el usuario con id : $id", $id_key);
                $this->entityManager->getRepository(userEntity::class)->updateUser(".status", 1, $id);
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUserActive(".key_corp", $corpAsig, $id);
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUserActive(".cargo", $rolasign, $id);
                return new JsonModel(["message" => "activado"]);
            } else {
                $this->logs("el usuario con id $id_key intento activar al usuario con id $id (permisos insuficientes)", $id_key);
                return new JsonModel(["message"=>"error"]);
            }

            return new JsonModel(["message" => "echo"]);
        } else {
            $this->logs("Se intento acceder con get a la ruta activarusuarios", "ADMIN");
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    /*
     * datosDelusuario CRUD
     */

    public function getdatauserAction()
    {

        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id", "");

            $dataUser = $this->entityManager->getRepository(datosDeUsuarioEntity::class)->findBy(['idAmpip' => $id]);
            $data = [];

            foreach ($dataUser as $item) {
                $data['id'] = $item->getId();
                $data['key_corp'] = $item->getkey_corp();
                $data['cargo'] = $item->getcargo();
                $data['telefonoOfficina'] = $item->gettelefonoOfficina();
                $data['celular'] = $item->getcelular();
                $data['direccionDeOfficina'] = $item->getdireccionDeOfficina();
                $data['cumpleanios'] = $item->getcumpleanios();
                $data['compartirDatos'] = $item->getcompartirDatos();
                $data['habilitar'] = $item->gethabilitar();
                $data['id_A'] = $item->getidAmpip();
            }
            $this->logs("el usuario con id $id obtubo sus datos", $id);
            return new JsonModel($data);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //admin permisos
    public function createdatauserAction()
    {

        if ($this->getRequest()->isPost()) {
            //id de usuario de la tabla User
            $id = $this->params()->fromPost("id");
            $telefonoOfficina = $this->params()->fromPost("telefonoOfficina");
            $celular = $this->params()->fromPost("celular");
            $direccionDeOfficina = $this->params()->fromPost("direccionDeOfficina");
            $cumpleanios = $this->params()->fromPost("cumpleanios");
            $compartirDatos = $this->params()->fromPost("compartirDatos", 1);
            $key_corp = $this->params()->fromPost("key_corp", 0);
            $cargo = $this->params()->fromPost("charge");
            $findUser = $this->entityManager->getRepository(datosDeUsuarioEntity::class)->findBy(['idAmpip' => $id]);


            if ($findUser != null) {
                return new JsonModel(["message" => "Ya hay datos"]);
                $this->logs("el usuario con id $id intento crear nuevos datos error de duplicidad", $id);
            } else {
                $newDatauser = new datosDeUsuarioEntity();
                $newDatauser->settelefonoOfficina($telefonoOfficina);
                $newDatauser->setcelular($celular);
                $newDatauser->setdireccionDeOfficina($direccionDeOfficina);
                $newDatauser->setcumpleanios($cumpleanios);
                $newDatauser->setcompartirDatos($compartirDatos);
                $newDatauser->sethabilitar(1);
                $newDatauser->setidAmpip($id);
                $newDatauser->setcargo($cargo);
                $newDatauser->setkey_corp($key_corp);
                $this->entityManager->persist($newDatauser);
                $this->entityManager->flush();
                return new JsonModel(["message" => "creado"]);
                $this->logs("el usuario con id $id creo sus datos", $id);
            }
        } else {

            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //admin permision
    public function updatedatauserAction()
    {
        if ($this->getRequest()->isPost()) {

            $id = $this->params()->fromPost("id","");
            $telefonoOfficina = $this->params()->fromPost("telefonoOfficina");
            $celular = $this->params()->fromPost("celular");
            $direccionDeOfficina = $this->params()->fromPost("direccionDeOfficina");
            $cumpleanios = $this->params()->fromPost("cumpleanios");
            $compartirDatos = $this->params()->fromPost("compartirDatos", 1);
            $habilitar = $this->params()->fromPost("habilitar", 1);


            if (true) {
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUser(".telefonoOfficina", $telefonoOfficina, $id);
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUser(".celular", $celular, $id);
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUser(".direccionDeOfficina", $direccionDeOfficina, $id);
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUser(".cumpleanios", $cumpleanios, $id);
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUser(".compartirDatos", $compartirDatos, $id);
                $this->entityManager->getRepository(datosDeUsuarioEntity::class)->updateUser(".habilitar", $habilitar, $id);
                return new JsonModel(["message" => "listo"]);
                $this->logs("el usuario con id $id actualizo sus datos", $id);
            } else {
                $this->logs("el usuario con id $id no tiene permisos suficientes para actualizar informacion ", $id);
                return new JsonModel(["message" => "sin permisos requeridos"]);
            }
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }


    /*
     * parques CRUD
     */

    public function getparkAction()
    {
        $id = $this->params()->fromPost("id", "");
        if ($this->getRequest()->isPost()) {
            $result = $this->entityManager->getRepository(parqueEntity::class)->findById($id);
            $roleList = [];
            foreach ($result as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getid();
                    $roleList["key_corp"] = $role->getkey_corp();
                    $roleList["key_user"] = $role->getkey_user();
                    $roleList["nombre_es"] = $role->getnombre_es();
                    $roleList["nombre_en"] = $role->getnombre_en();
                    $roleList["adminParq"] = $role->getadminParq();
                    $roleList["parqProp"] = $role->getparqProp();
                    $roleList["parqIntoParq"] = $role->getparqIntoParq();
                    $roleList["region"] = $role->getregion();
                    $roleList["mercado"] = $role->getmercado();
                    $roleList["tipoDeIndustria"] = $role->gettipoDeIndustria();
                    $roleList["superficieTotal"] = $role->getsuperficieTotal();
                    $roleList["superficieUrban"] = $role->getsuperficieUrban();
                    $roleList["superficieOcup"] = $role->getsuperficieOcup();
                    $roleList["superficieDisp"] = $role->getsuperficieDisp();
                    $roleList["tipoDePropiedad"] = $role->gettipoDePropiedad();
                    $roleList["inicioOperaciones"] = $role->getinicioOperaciones();
                    $roleList["numEmpleados"] = $role->getnumEmpleados();
                    $roleList["reconocimientoPracticas"] = $role->getreconocimientoPracticas();
                    $roleList["ifraestructura"] = $role->getifraestructura();
                    $roleList["numeroDeNaves"] = $role->getnumeroDeNaves();
                    $roleList["observacion"] = $role->getobservacion();
                    $roleList["kmz"] = $role->getkmz();
                    $roleList["planMaestro"] = $role->getplanMaestro();
                    $roleList["contactName"] = $role->getcontactName();
                    $roleList["contactEmail"] = $role->getcontactEmail();
                    $roleList["data"] = $role->getedit();
                } else {
                    $roleList["error"] = "2541";
                }
            }
            return new JsonModel([$roleList]);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //admin permisos
    public function createparkAction()
    {
        if ($this->getRequest()->isPost()) {
            $dates = date("Y-m-d");
            $key_corp = $this->params()->fromPost("key_corp");
            $key_user = $this->params()->fromPost("key_user", null);
            $nombre_es = $this->params()->fromPost("nombre_es");
            $nombre_en = $this->params()->fromPost("nombre_en", "");
            $adminParq = $this->params()->fromPost("adminParq", null);
            $parqProp = $this->params()->fromPost("parqProp");
            $parqIntoParq = $this->params()->fromPost("parqIntoParq", 0);
            $region = $this->params()->fromPost("region");
            $mercado = $this->params()->fromPost("mercado");
            $tipoDeIndustria = $this->params()->fromPost("tipoDeIndustria");
            $superficieTotal = $this->params()->fromPost("superficieTotal");
            $superficieUrban = $this->params()->fromPost("superficieUrban");
            $superficieOcup = $this->params()->fromPost("superficieOcup");
            $superficieDisp = $this->params()->fromPost("superficieDisp");
            $tipoDePropiedad = $this->params()->fromPost("tipoDePropiedad");
            $inicioOperaciones = $this->params()->fromPost("inicioOperaciones", date('Y-m-d H:i:s'));
            $numEmpleados = $this->params()->fromPost("numEmpleados");
            $reconocimientoPracticas = $this->params()->fromPost("reconocimientoPracticas", null);
            $ifraestructura = $this->params()->fromPost("ifraestructura");
            $numeroDeNaves = $this->params()->fromPost("numeroDeNaves");
            $observacion = $this->params()->fromPost("observacion");
            $kmz = $this->params()->fromPost("kmz");
            $planMaestro = $this->params()->fromPost("planMaestro");
            $contactName = $this->params()->fromPost("contactName");
            $contactEmail = $this->params()->fromPost("contactEmail");
            $isDispo = $this->entityManager->getRepository(parqueEntity::class)->findBy(["nombre_es" => $nombre_es, "key_corp" => $key_corp]);


            if ($isDispo == null) {
                $newpark = new parqueEntity();

                $newpark->setkey_corp($key_corp);
                $newpark->setkey_user($key_user);
                $newpark->setnombre_es($nombre_es);
                $newpark->setnombre_en($nombre_en);
                $newpark->setadminParq($adminParq);
                $newpark->setparqProp($parqProp);
                $newpark->setparqIntoParq($parqIntoParq);
                $newpark->setregion($region);
                $newpark->setmercado($mercado);
                $newpark->settipoDeIndustria($tipoDeIndustria);
                $newpark->setsuperficieTotal($superficieTotal);
                $newpark->setsuperficieUrban($superficieUrban);
                $newpark->setsuperficieOcup($superficieOcup);
                $newpark->setsuperficieDisp($superficieDisp);
                $newpark->settipoDePropiedad($tipoDePropiedad);
                $newpark->setinicioOperaciones($inicioOperaciones);
                $newpark->setnumEmpleados($numEmpleados);
                $newpark->setreconocimientoPracticas($reconocimientoPracticas);
                $newpark->setifraestructura($ifraestructura);
                $newpark->setnumeroDeNaves($numeroDeNaves);
                $newpark->setobservacion($observacion);
                $newpark->setkmz($kmz);
                $newpark->setplanMaestro($planMaestro);
                $newpark->setcontactName($contactName);
                $newpark->setcontactEmail($contactEmail);
                $newpark->setedit($dates);
                $this->entityManager->persist($newpark);
                $this->entityManager->flush();
                return new JsonModel(["message" => "Listo"]);
            } else {
                return new JsonModel(["err" => "parque con mismo nombre registrado"]);
            }
        } else {
            return $this->redirect()->toUrl($this->url);
        }
    }

    //admin permisos
    public function updateparkAction()
    {
        if ($this->getRequest()->isPost()) {
            //id para poder editar
            $key_id = $this->params()->fromPost("key_id");
            $id = $this->params()->fromPost("id", "");
            $nombre_es = $this->params()->fromPost("nombre_es");
            $nombre_en = $this->params()->fromPost("nombre_en", "");
            $adminParq = $this->params()->fromPost("adminParq");
            $parqProp = $this->params()->fromPost("parqProp");
            $parqIntoParq = $this->params()->fromPost("parqIntoParq");
            $region = $this->params()->fromPost("region");
            $mercado = $this->params()->fromPost("mercado");
            $tipoDeIndustria = $this->params()->fromPost("tipoDeIndustria");
            $superficieTotal = $this->params()->fromPost("superficieTotal");
            $tipoDePropiedad = $this->params()->fromPost("tipoDePropiedad");
            $numEmpleados = $this->params()->fromPost("numEmpleados");
            $reconocimientoPracticas = $this->params()->fromPost("reconocimientoPracticas");
            $ifraestructura = $this->params()->fromPost("ifraestructura");
            $numeroDeNaves = $this->params()->fromPost("numeroDeNaves");
            $observacion = $this->params()->fromPost("observacion");
            $kmz = $this->params()->fromPost("kmz");
            $planMaestro = $this->params()->fromPost("planMaestro");
            $contactName = $this->params()->fromPost("contactName");
            $contactEmail = $this->params()->fromPost("contactEmail");
            $date= $this->params()->fromPost("date", date("Y-m-d"));

            $user = $this->entityManager->getRepository(parqueEntity::class)->findById($id);
            $permiso = $this->getPermision($key_id);
            if (true) {
                if ($user != null) {
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".nombre_es", $nombre_es, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".nombre_en", $nombre_en, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".adminParq", $adminParq, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".parqProp", $parqProp, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".parqIntoParq", $parqIntoParq, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".region", $region, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".mercado", $mercado, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".tipoDeIndustria", $tipoDeIndustria, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".superficieTotal", $superficieTotal, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".tipoDePropiedad", $tipoDePropiedad, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".numEmpleados", $numEmpleados, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".reconocimientoPracticas", $reconocimientoPracticas, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".ifraestructura", $ifraestructura, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".numeroDeNaves", $numeroDeNaves, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".observacion", $observacion, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".kmz", $kmz, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".planMaestro", $planMaestro, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".contactName", $contactName, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".contactEmail", $contactEmail, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".edit", $date,$id);
                    return new JsonModel(["message" => "echo"]);
                } else {
                    return new JsonModel(["message" => "El id no existe"]);
                }
            } else {
                return new JsonModel(["message" => "Usuario no permitido"]);
            }
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    //
    public function getallparkAction()
    {
        $id = $this->params()->fromPost("id", "");
        if ($this->getRequest()->isPost()) {
            $result = $this->entityManager->getRepository(parqueEntity::class)->findBy(["key_corp" => $id]);
            $arr = array();
            $roleList = [];

            foreach ($result as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getid();
                    $roleList["key_corp"] = $role->getkey_corp();
                    $roleList["key_user"] = $role->getkey_user();
                    $roleList["nombre_es"] = $role->getnombre_es();
                    $roleList["nombre_en"] = $role->getnombre_en();
                    $roleList["adminParq"] = $role->getadminParq();
                    $roleList["parqProp"] = $role->getparqProp();
                    $roleList["parqIntoParq"] = $role->getparqIntoParq();
                    $roleList["region"] = $role->getregion();
                    $roleList["mercado"] = $role->getmercado();
                    $roleList["tipoDeIndustria"] = $role->gettipoDeIndustria();
                    $roleList["superficieTotal"] = $role->getsuperficieTotal();
                    $roleList["superficieUrban"] = $role->getsuperficieUrban();
                    $roleList["superficieOcup"] = $role->getsuperficieOcup();
                    $roleList["superficieDisp"] = $role->getsuperficieDisp();
                    $roleList["tipoDePropiedad"] = $role->gettipoDePropiedad();
                    $roleList["inicioOperaciones"] = $role->getinicioOperaciones();
                    $roleList["numEmpleados"] = $role->getnumEmpleados();
                    $roleList["reconocimientoPracticas"] = $role->getreconocimientoPracticas();
                    $roleList["ifraestructura"] = $role->getifraestructura();
                    $roleList["numeroDeNaves"] = $role->getnumeroDeNaves();
                    $roleList["observacion"] = $role->getobservacion();
                    $roleList["kmz"] = $role->getkmz();
                    $roleList["planMaestro"] = $role->getplanMaestro();
                    $roleList["contactName"] = $role->getcontactName();
                    $roleList["contactEmail"] = $role->getcontactEmail();
                    $roleList["edit"] = $role->getedit();
                    if($role->getkey_corp() != "" ){
                    array_push($arr, $roleList);
                    }
                } else {
                    $roleList["error"] = "2541";
                }
            }

            return new JsonModel($arr);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function getallnaveforparkAction(){
        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id");
            $parques = $this->entityManager->getRepository(parqueEntity::class)->findBy(["key_corp"=>$id]);
            $items = [];
            $arr = array();
            foreach($parques as $parque){
                
                $naves = $this->entityManager->getRepository(naveEntity::class)->findBy(["parque_id"=>$parque->getid()]);
                foreach($naves as $nave){
                    $items['id'] = $nave->getid();
                    $items['name'] = $nave->getname();
                    $items['parque_id'] = $nave->getparque_id();
                    array_push($arr, $items);
                }
            }
            return new JsonModel($arr);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }


    public function getparksAction()
    {
        if ($this->getRequest()->isPost()) {
            $result = $this->entityManager->getRepository(parqueEntity::class)->findAll();
            $arr = array();
            $roleList = [];

            foreach ($result as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getid();
                    $roleList["key_corp"] = $role->getkey_corp();
                    $roleList["key_user"] = $role->getkey_user();
                    $roleList["nombre_es"] = $role->getnombre_es();
                    $roleList["nombre_en"] = $role->getnombre_en();
                    $roleList["adminParq"] = $role->getadminParq();
                    $roleList["parqProp"] = $role->getparqProp();
                    $roleList["parqIntoParq"] = $role->getparqIntoParq();
                    $roleList["region"] = $role->getregion();
                    $roleList["mercado"] = $role->getmercado();
                    $roleList["tipoDeIndustria"] = $role->gettipoDeIndustria();
                    $roleList["superficieTotal"] = $role->getsuperficieTotal();
                    $roleList["superficieUrban"] = $role->getsuperficieUrban();
                    $roleList["superficieOcup"] = $role->getsuperficieOcup();
                    $roleList["superficieDisp"] = $role->getsuperficieDisp();
                    $roleList["tipoDePropiedad"] = $role->gettipoDePropiedad();
                    $roleList["inicioOperaciones"] = $role->getinicioOperaciones();
                    $roleList["numEmpleados"] = $role->getnumEmpleados();
                    $roleList["reconocimientoPracticas"] = $role->getreconocimientoPracticas();
                    $roleList["ifraestructura"] = $role->getifraestructura();
                    $roleList["numeroDeNaves"] = $role->getnumeroDeNaves();
                    $roleList["observacion"] = $role->getobservacion();
                    $roleList["kmz"] = $role->getkmz();
                    $roleList["planMaestro"] = $role->getplanMaestro();
                    $roleList["contactName"] = $role->getcontactName();
                    $roleList["contactEmail"] = $role->getcontactEmail();
                    array_push($arr, $roleList);
                } else {
                    $roleList["error"] = "2541";
                }
            }

            return new JsonModel($arr);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }


    public function setspaceAction(){
        if ($this->getRequest()->isPost()) {
            //id para poder editar
            $id = $this->params()->fromPost("id", "");
           
            $superficieDisp = $this->params()->fromPost("superficieDisp");
            $dates = date("d.m.y");

            $user = $this->entityManager->getRepository(parqueEntity::class)->findById($id);
            if (true) {
                if ($user != null) {
                    
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".superficieDisp", $superficieDisp, $id);
                    $this->entityManager->getRepository(parqueEntity::class)->updatePark(".dates", $dates,$id);

                    return new JsonModel(["message" => "El parque fue modificado"]);
                } else {
                    return new JsonModel(["message" => "El id no existe"]);
                }
            } else {
                return new JsonModel(["message" => "Usuario no permitido"]);
            }
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }
    /*
     * nave
     */

    public function createnaveAction()
    {
        $space = $this->params()->fromPost("space");        
        $name = $this->params()->fromPost("name");
        $idParque = $this->params()->fromPost("idParque");

        $newNave = new naveEntity();
        $newNave->setname($name);
        $newNave->setparque_id($idParque);
       /*  $this->entityManager->getRepository(parqueEntity::class)->updatePark(".nombre_es", $space, $idParque); */
        $this->entityManager->persist($newNave);
        $this->entityManager->flush();
        $naveData = $this->entityManager->getRepository(naveEntity::class)->findBy(["name"=>$name, "parque_id"=>$idParque]);

        $data = null ;
        foreach ($naveData as $naveDatum) {
            $data= $naveDatum->getid();
        }

        return new JsonModel(["id"=>$data]);
    }

    public function getnaveAction()
    {
        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id", "");
            $nave = $this->entityManager->getRepository(naveEntity::class)->findById($id);


            $roleList = [];
            foreach ($nave as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getId();
                    $roleList["name"] = $role->getname();
                    $roleList["parque_id"] = $role->getparque_id();
                } else {
                    $roleList["error"] = "2541";
                }
            }


            return new JsonModel($roleList);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function getallnaveAction()
    {
        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id", "");
            $nave = $this->entityManager->getRepository(naveEntity::class)->findBy(["parque_id" => $id]);

            $arr = array();
            $roleList = [];
            foreach ($nave as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getId();
                    $roleList["name"] = $role->getname();
                    $roleList["parque_id"] = $role->getparque_id();
                    array_push($arr, $roleList);
                } else {
                    $roleList["error"] = "2541";
                }
            }


            return new JsonModel($arr);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    /*
     *inquilino
     */


    public function getinquilinoAction()
    {
        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id");
            $inquilino = $this->entityManager->getRepository(inquilino_naveEntity::class)->findBy(["id_nave"=>$id]);

            $allsinqui = array();
            $roleList = [];
            foreach ($inquilino as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getid();
                    $roleList["corporativo"] = $role->getcorporativo();
                    $roleList["tipoDeNave"] = $role->gettipoDeNave();
                    $roleList["nombre_es"] = $role->getnombre_es();
                    $roleList["nombre_en"] = $role->getnombre_en();
                    $roleList["propietario"] = $role->getpropietario();
                    $roleList["id_nave"] = $role->getid_nave();
                    $roleList["nombreEmpresa"] = $role->getnombreEmpresa();
                    $roleList["numEmpleados"] = $role->getnumEmpleados();
                    $roleList["paisOrigen"] = $role->getpaisOrigen();
                    $roleList["productoInsignia"] = $role->getproductoInsignia();
                    $roleList["sectorEmpresarial"] = $role->getsectorEmpresarial();
                    $roleList["id_SCIAN"] = $role->getid_SCIAN();
                    $roleList["id_DENUE"] = $role->getid_DENUE();
                    $roleList["antiguedad"] = $role->getantiguedad();
                    $roleList["isAmpip"] = $role->getisAmpip();
                    $roleList["x"] = $role->getmedidaX();
                    array_push($allsinqui, $roleList);
                } else {
                    $roleList["error"] = "2541";
                }
            }

            return new JsonModel($allsinqui);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function setinquilinoAction()
    {

        if ($this->getRequest()->isPost()) {
            $corporativo = $this->params()->fromPost("corporativo");
            $tipoDeNave = $this->params()->fromPost("tipoDeNave");
            $nombre_es = $this->params()->fromPost("nombre_es");
            $nombre_en = $this->params()->fromPost("nombre_en");
            $propietario = $this->params()->fromPost("propietario");
            $id_nave = $this->params()->fromPost("id_nave", 12);
            $nombreEmpresa = $this->params()->fromPost("nombreEmpresa");
            $numEmpleados = $this->params()->fromPost("numEmpleados");
            $paisOrigen = $this->params()->fromPost("paisOrigen");
            $productoInsignia = $this->params()->fromPost("productoInsignia");
            $sectorEmpresarial = $this->params()->fromPost("sectorEmpresarial");
            $id_SCIAN = $this->params()->fromPost("id_SCIAN");
            $id_DENUE = $this->params()->fromPost("id_DENUE");
            $antiguedad = $this->params()->fromPost("antiguedad");
            $isAmpip = $this->params()->fromPost("isAmpip");
            $medidaX = $this->params()->fromPost("medidaX", 0);
            $search = $this->entityManager->getRepository(inquilino_naveEntity::class)->findBy(["nombre_es" => $nombre_es]);
            if ($search == null) {
                $newInquilino = new inquilino_naveEntity();
                $newInquilino->setcorporativo($corporativo);
                $newInquilino->settipoDeNave($tipoDeNave);
                $newInquilino->setnombre_es($nombre_es);
                $newInquilino->setnombre_en($nombre_en);
                $newInquilino->setpropietario($propietario);
                $newInquilino->setnombreEmpresa($nombreEmpresa);
                $newInquilino->setnumEmpleados($numEmpleados);
                $newInquilino->setpaisOrigen($paisOrigen);
                $newInquilino->setproductoInsignia($productoInsignia);
                $newInquilino->setsectorEmpresarial($sectorEmpresarial);
                $newInquilino->setid_SCIAN($id_SCIAN);
                $newInquilino->setid_DENUE($id_DENUE);
                $newInquilino->setantiguedad($antiguedad);
                $newInquilino->setisAmpip($isAmpip);
                $newInquilino->setmedidaX($medidaX);
                $newInquilino->setid_nave($id_nave);
                $this->entityManager->persist($newInquilino);
                $this->entityManager->flush();

                return new JsonModel(["message" => "listo"]);
            } else {
                return new JsonModel(["message" => "El inquilino ya esta existe"]);
            }
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function updateinquilinoAction()
    {
        if ($this->getRequest()->isPost()) {
            $key_id = $this->params()->fromPost("key", "");
            $id = $this->params()->fromPost("id", "");
            $tipoDeNave = $this->params()->fromPost("tipoDeNave", "");
            $nombre_es = $this->params()->fromPost("nombre_es", "");
            $nombre_en = $this->params()->fromPost("nombre_en", "");
            $propietario = $this->params()->fromPost("propietario", "");
            $nombreEmpresa = $this->params()->fromPost("nombreEmpresa", "");
            $numEmpleados = $this->params()->fromPost("numEmpleados", "");
            $paisOrigen = $this->params()->fromPost("paisOrigen", "");
            $productoInsignia = $this->params()->fromPost("productoInsignia", "");
            $sectorEmpresarial = $this->params()->fromPost("sectorEmpresarial", "");
            $id_SCIAN = $this->params()->fromPost("id_SCIAN", "");
            $id_DENUE = $this->params()->fromPost("id_DENUE", "");
            $antiguedad = $this->params()->fromPost("antiguedad", "");
            $isAmpip = $this->params()->fromPost("isAmpip", "");
            $medidaX = $this->params()->fromPost("medidaX");
            $medidaY = $this->params()->fromPost("medidaY");
            $medidaZ = $this->params()->fromPost("medidaZ");

            $permiso = $this->getPermision($key_id);
            if ($permiso['name'] == "Administrator") {
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".tipoDeNave", $tipoDeNave, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".nombre_es", $nombre_es, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".nombre_en", $nombre_en, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".propietario", $propietario, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".nombreEmpresa", $nombreEmpresa, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".numEmpleados", $numEmpleados, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".paisOrigen", $paisOrigen, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".productoInsignia", $productoInsignia, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".sectorEmpresarial", $sectorEmpresarial, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".id_SCIAN", $id_SCIAN, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".id_DENUE", $id_DENUE, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".antiguedad", $antiguedad, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".isAmpip", $isAmpip, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".medidaX", $medidaX, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".medidaY", $medidaY, $id);
                $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".medidaZ", $medidaZ, $id);
                return new JsonModel(["message" => "listo"]);
            } else {
                return new JsonModel(["message" => "permiso Insuficiente"]);
            }
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    public function getallAction()
    {
        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id");
            $inquilino = $this->entityManager->getRepository(inquilino_naveEntity::class)->findBy(["id_nave" => $id]);

            $arr = array();
            $roleList = [];
            foreach ($inquilino as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getid();
                    $roleList["corporativo"] = $role->getcorporativo();
                    $roleList["tipoDeNave"] = $role->gettipoDeNave();
                    $roleList["nombre_es"] = $role->getnombre_es();
                    $roleList["nombre_en"] = $role->getnombre_en();
                    $roleList["propietario"] = $role->getpropietario();
                    $roleList["id_nave"] = $role->getid_nave();
                    $roleList["nombreEmpresa"] = $role->getnombreEmpresa();
                    $roleList["numEmpleados"] = $role->getnumEmpleados();
                    $roleList["paisOrigen"] = $role->getpaisOrigen();
                    $roleList["productoInsignia"] = $role->getproductoInsignia();
                    $roleList["sectorEmpresarial"] = $role->getsectorEmpresarial();
                    $roleList["id_SCIAN"] = $role->getid_SCIAN();
                    $roleList["id_DENUE"] = $role->getid_DENUE();
                    $roleList["antiguedad"] = $role->getantiguedad();
                    $roleList["isAmpip"] = $role->getisAmpip();
                    array_push($arr, $roleList);
                } else {
                    $roleList["error"] = "2541";
                }
            }

            return new JsonModel($arr);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

    /*
     * DEJAR AL ULTIMO
     */
    public function espacioAction()
    {
        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id");
            $inquilino = $this->entityManager->getRepository(espacio_disponibleEntity::class)->findById($id);

            $roleList = [];
            foreach ($inquilino as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getid();
                    $roleList["corporativo"] = $role->getcorporativo();
                    $roleList["ubicacion"] = $role->getubicacion();
                    $roleList["tipo"] = $role->gettipo();
                    $roleList["tipoDeDispo"] = $role->gettipoDeDispo();
                    $roleList["uso"] = $role->getuso();
                    $roleList["municipio"] = $role->getmunicipio();
                    $roleList["estado"] = $role->getestado();
                    $roleList["web"] = $role->getweb();
                    $roleList["contacto"] = $role->getcontacto();
                    $roleList["precioPromedio"] = $role->getprecioPromedio();
                    $roleList["datoDeContacto"] = $role->getdatoDeContacto();
                    $roleList["id_parque"] = $role->getid_parque();
                    $roleList["x"] = $role->getmedidaX();
                    $roleList["y"] = $role->getmedidaY();
                    $roleList["z"] = $role->getmedidaZ();
                } else {
                    $roleList["error"] = "2541";
                }
            }

            return new JsonModel($roleList);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }

  
   


    public function getroleAction()
    {
        if ($this->getRequest()->isPost()) {
            $getRoles = $this->entityManager->getRepository(Role::class)->findAll();


            $arr = array();
            $roleList = [];
            foreach ($getRoles as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getId();
                    $roleList["name"] = $role->getName();
                    $roleList["description"] = $role->getDescription();
                } else {
                    $roleList["error"] = "2541";
                }

                array_push($arr, $roleList);
            }

            return new JsonModel($arr);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }
    }


    public function encript($option, $message, $key)
    {


        if ($option == "enc") {
            $result = '';
            for ($i = 0; $i < strlen($message); $i++) {
                $char = substr($message, $i, 1);
                $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                $char = chr(ord($char) + ord($keychar));
                $result .= $char;
            }
            return base64_encode($result);
        } else {
            $result = "";
            $string = base64_decode($message);
            for ($i = 0; $i < strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                $char = chr(ord($char) - ord($keychar));
                $result .= $char;
            }

            return $result;
        }
    }

    public function logs($message, $user)
    {


        $log = new logEntity();
        $log->setmessage($message);
        $log->setuser($user);
        $log->settime(date('Y-m-d H:i:s'));

        $this->entityManager->persist($log);
        $this->entityManager->flush();

        return new JsonModel(["message" => ["listo"]]);
    }


    public function getuseridloginAction()
    {
        $email = $this->params()->fromPost('email' );
        $pass = $this->params()->fromPost('pass');
        $decryptPass = $this->encript("enc", $pass, "4MP1P");
        $response = $this->entityManager->getRepository(userEntity::class)->findBy(['email' => $email]);
        $roleList = [];
        foreach ($response as $role) {
            if ($role->getId() != "") {
                $roleList["id"] = $role->getId();
            } else {
                $roleList["error"] = 0;
            }
        }
        $this->logs("el usuario $email inicio secion", $email);
        return new JsonModel([$roleList]);
    }
 
    public function setpermisosAction()
    {
        if ($this->getRequest()->isPost()) {
            $idUser = $this->params()->fromPost("idUser");
            $idParque = $this->params()->fromPost("idParque");
            $permiso = $this->params()->fromPost("permiso");

            if ($idUser != "" && $idParque != "" && $permiso != "") {
                $userPermisoParque = new parquesuserEntity();
                $userPermisoParque->setid_parque($idParque);
                $userPermisoParque->setPersona($idUser);
                $userPermisoParque->setpermiso($permiso);
                $this->entityManager->persist($userPermisoParque);
                $this->entityManager->flush();
                return new JsonModel(["message" => "Se otorgaron permisos"]);
            } else {
                return new JsonModel(["message" => "Datos nulos"]);
            }
        } else {
            return new JsonModel(["message" => "ruta solo post"]);
        }
    }

    public function activeinactiveAction()
    {
        if ($this->getRequest()->isPost()) {
            $type = $this->params()->fromPost("type");
            $table = $this->params()->fromPost("table");
            $id = $this->params()->fromPost("id");
            $key_corp = $this->params()->fromPost("parque", 0);
            switch ($type) {
                case "a":
                    switch ($table) {
                        case "c":
                            $this->entityManager->getRepository(corpEntity::class)->updateUser(".status", 1, $id);
                            return new JsonModel(["message" => "listo"]);
                        case "u":
                            $this->entityManager->getRepository(userEntity::class)->updateUser(".status", 1, $id);
                            return new JsonModel(["message" => "listo"]);
                        case "p":
                            $this->entityManager->getRepository(parqueEntity::class)->updatePark(".key_corp", $key_corp, $id);
                            return new JsonModel(["" => ""]);
                        
                        case "n":
                            $this->entityManager->getRepository(naveEntity::class)->updateData(".parque_id", $key_corp, $id);
                            return new JsonModel(["message" => "listo"]);
                    }

                    return new JsonModel(["message" => "listo"]);

                case "i":
                    switch ($table) {
                        case "c":
                            $this->entityManager->getRepository(corpEntity::class)->updateUser(".status", null, $id);
                            return new JsonModel(["message" => "listo"]);

                        case "u":
                            $this->entityManager->getRepository(userEntity::class)->updateUser(".status", 0, $id);
                            return new JsonModel(["message" => "Usuario eliminado"]);
                        case "p":
                            $this->entityManager->getRepository(parqueEntity::class)->updatePark(".key_corp", 0, $id);
                            return new JsonModel(["message" => "listo"]);

                    
                        case "n":
                            $this->entityManager->getRepository(naveEntity::class)->updateData(".parque_id", 0, $id);
                            $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".isAmpip", false, $id);
                            return new JsonModel(["message" => "Desactivado"]);
                    }
                    return new JsonModel(["message" => "listo"]);
            }
        }

        return new JsonModel(["message" => "solo post"]);
    }
    //para el widget mapa de bilda
    public function mapsAction()
    {
        if (true) {
            $maker = $this->entityManager->getRepository(mapsEntity::class)->findAll();
            $makersArray = array();
            $arr = [];

            foreach ($maker as $make){
                $arr['id'] = $make->getId();
                $arr['name'] = $make->getname();
                $arr['lat'] = $make->getlat();
                $arr['lng'] = $make->getlng();
                $arr['filters'] = $make->getfilters();
                array_push($makersArray, $arr);
            }
            $this->logs("Se obtubieron todos los parques", "WM");
            return new JsonModel($makersArray);

        } else {
            return new JsonModel(["message" => "solo post"]);
        }
    }
    public function mapsupAction()
    {
        if ($this->getRequest()->isPost()) {
            $maker = $this->entityManager->getRepository(mapsEntity::class)->findAll();
            $name = $this->params()->fromPost("name");
            $lat = $this->params()->fromPost("lat");
            $lng = $this->params()->fromPost("lng");

            $newMaps = new mapsEntity();
            $newMaps->setname($name);
            $newMaps->setlat($lat);
            $newMaps->setlng($lng);
            $this->entityManager->persist($newMaps);
            $this->entityManager->flush();
            return  new JsonModel(["message"=>"Mapa agregado"]);

        } else {
            return new JsonModel(["message" => "solo post"]);
        }
    }


    public function testAction() 
    {
        return new JsonModel(["message" => "Hello de nueno world"]);
    }


    public function uploadfilesAction(){
        $host= $_SERVER["HTTP_HOST"];
        $query = $this->params()->fromPost("query");
        $uniqueName = $this->params()->fromPost("uniqueName");

        switch ($query){
            case "logo":
                try {
                    move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], "./public/uploads/logos/"  . $uniqueName . ".jpg");
                    return new JsonModel(["message"=>"http://". $host . "/uploads/". $uniqueName . ".jpg"]);
                } catch (\Exception $e){
                    return new JsonModel(["message"=>$e]);
                }
                break;
            case "parks":
                try {
                    move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], "./public/uploads/parks/"  . $uniqueName . ".jpg");
                    return new JsonModel(["message"=>"http://". $host . "/uploads/". $uniqueName . ".jpg"]);
                } catch (\Exception $e){
                    return new JsonModel(["message"=>$e]);
                }
                break;
            case "perfil":
                try {
                    move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], "./public/uploads/perfil/"  . $uniqueName . ".jpg");
                    return new JsonModel(["message"=>"http://". $host . "/uploads/". $uniqueName . ".jpg"]);
                } catch (\Exception $e){
                    return new JsonModel(["message"=>$e]);
                }
                break;
            default:
                return new JsonModel(["message"=>"Error"]);

        }
    }


    public function getparkssheetsAction(){
        if ($this->getRequest()->isPost()) {
            $date = date("Y-m-d");
            $result = $this->entityManager->getRepository(parqueEntity::class)->findBy(["dates" => $date]);
            $arr = array();
            $roleList = [];

            foreach ($result as $role) {
                if ($role->getId() != "") {
                    $roleList["id"] = $role->getid();
                    $roleList["key_corp"] = $role->getkey_corp();
                    $roleList["key_user"] = $role->getkey_user();
                    $roleList["nombre_es"] = $role->getnombre_es();
                    $roleList["nombre_en"] = $role->getnombre_en();
                    $roleList["adminParq"] = $role->getadminParq();
                    $roleList["parqProp"] = $role->getparqProp();
                    $roleList["parqIntoParq"] = $role->getparqIntoParq();
                    $roleList["region"] = $role->getregion();
                    $roleList["mercado"] = $role->getmercado();
                    $roleList["tipoDeIndustria"] = $role->gettipoDeIndustria();
                    $roleList["superficieTotal"] = $role->getsuperficieTotal();
                    $roleList["superficieUrban"] = $role->getsuperficieUrban();
                    $roleList["superficieOcup"] = $role->getsuperficieOcup();
                    $roleList["superficieDisp"] = $role->getsuperficieDisp();
                    $roleList["tipoDePropiedad"] = $role->gettipoDePropiedad();
                    $roleList["inicioOperaciones"] = $role->getinicioOperaciones();
                    $roleList["numEmpleados"] = $role->getnumEmpleados();
                    $roleList["reconocimientoPracticas"] = $role->getreconocimientoPracticas();
                    $roleList["ifraestructura"] = $role->getifraestructura();
                    $roleList["numeroDeNaves"] = $role->getnumeroDeNaves();
                    $roleList["observacion"] = $role->getobservacion();
                    $roleList["kmz"] = $role->getkmz();
                    $roleList["planMaestro"] = $role->getplanMaestro();
                    $roleList["contactName"] = $role->getcontactName();
                    $roleList["contactEmail"] = $role->getcontactEmail();
                    if($role->getkey_corp() != "" ){
                        array_push($arr, $roleList);
                    }
                } else {
                    $roleList["error"] = "2541";
                }
            }

            return new JsonModel($roleList);
        } else {
            
            return new JsonModel(["message"=>"err"]);
        }
    }


    public function getlogAction(){
    }

    public function getnumbercorpspatAction(){
        $query = $this->params()->fromPost("query");
        
        switch ($query){
            case "corp":
                $search = $this->entityManager->getRepository(corpEntity::class)->findAll();
                $all = array();
                $items = [];
                foreach ($search as $item){
                    $items["id"] = $item->getid();
                    array_push($all, $items);
                }

                return new JsonModel($all);
            break;
            case "pat":
                $search = $this->entityManager->getRepository(datosDeUsuarioEntity::class)->findBy(["cargo"=>"Patrocinador"]);
                $all = array();
                $items = [];
                foreach ($search as $item){
                    $items["id"] = $item->getid();
                    array_push($all, $items);
                }
                return new JsonModel($all);
            break;
        }

        return new JsonModel(["s"=>"s"]);
    }

    public function getuserbykeycorpAction(){
        if ($this->getRequest()->isPost()) {
            $id = $this->params()->fromPost("id");
            $nave = $this->entityManager->getRepository(datosDeUsuarioEntity::class)->findBy(["key_corp" => $id]);

            $arr = array();
            

            foreach ($nave as $role) {
                
                    $ints = intval($role->getidAmpip());
                    array_push($arr, $ints);                
               
            }

            
            $arrs = array();
            $roleList = [];
            for($i = 0 ; $i < count($arr) ; ++$i){
                $user = $this->entityManager->getRepository(userEntity::class)->findBy(["id"=> $arr[$i]]);
                foreach ($user as $us){
                    $roleList['id'] = $us->getId();
                    $roleList['email'] = $us->getEmail();
                    $roleList['fullname'] = $us->getFullName();
                    if($us->getStatus() == 1){
                        array_push($arrs, $roleList);
                    }
                }
                
            }

            return new JsonModel($arrs);
        } else {
            return $this->redirect()->toUrl(
                $this->url
            );
        }

    }

    public function resetAction()
    {
        $id = $this->params()->fromPost("id");
        $pass= $this->params()->fromPost("pass");
        $type = $this->params()->fromPost("type");
        $user = $this->entityManager->getRepository(userEntity::class)->findById($id);

        switch ($type){
            case 1:
                $this->entityManager->getRepository(userEntity::class)->updateUser(".password", $this->encript("enc", $pass, "4MP1P"), $id);
                return new JsonModel(["message" => "ok"]);
                break;
            case 2:
                $this->entityManager->getRepository(userEntity::class)->updateUser(".password", "", $id);
                return  new JsonModel(["message"=>"red"]);
                break;
        }

    }

    public function getemailyidAction(){
        $id = $this->params()->fromPost("id");
        $email = $this->entityManager->getRepository(userEntity::class)->findById($id);
        $ems = [];
        foreach ($email as $em){
            $ems['email'] = $em->getEmail();
            $ems['name'] = $em->getFullName();
            $ems['id'] = $em->getId();
        }
        return new JsonModel([$ems]);
    }

    public function copomexAction(){
        $cp = $this->params()->fromPost("cp");
        $cp = $this->entityManager->getRepository(copomexEntity::class)->findBy(["cp"=>$cp]);
        $data = array();
        $list = [];
        foreach($cp as $item){
            $list['id'] = $item->getId();
            $list['colonia'] = $item->getColonia();
            $list['estado'] = $item->getEstado();
            $list['municipip'] = $item->getMunicipio();
            array_push($data, $list);
        }

        return new JsonModel($data);

    }

    public function updatepassAction(){
        $email = $this->params()->fromPost("email");
        $pass = $this->params()->fromPost("pass");
        $newPass = $this->params()->fromPost("newPass");
        $decryptPass = $this->encript("enc", $pass, "4MP1P");
        $encript = $this->encript("enc", $newPass, "4MP1P");
        $id = $this->params()->fromPost("id");
        $searchUser = $this->entityManager->getRepository(userEntity::class)->findBy(["email"=>$email, "password"=>$decryptPass]);
        if($searchUser != null){
            $this->entityManager->getRepository(userEntity::class)->updateUser(".password", $encript, $id);
            return new JsonModel(["message"=>"change Pass"]);
        } else{
            return new JsonModel(["message" => 0]);
        }

    }

    public function extrasAction(){
        $query = $this->params()->fromPost("query");
        switch ($query){
            case 1:
                $id = $this->params()->fromPost("id");
                $result = $this->entityManager->getRepository(extrasEntity::class)->findBy(["id_entity"=>$id]);
                $data = [];
                foreach($result as $item){
                    $data['id'] = $item->getId();
                    $data['id_entity'] = $item->getId_entity();
                    $data['data'] = $item->getdataextra();
                    
                }
                return new JsonModel($data);
                break;
            case 2 :
                $id = $this->params()->fromPost("id");
                $data = $this->params()->fromPost("data");
                $result = $this->entityManager->getRepository(extrasEntity::class)->findBy(["id_entity"=>$id]);
                if($result == null){
                    $dataExtra = new extrasEntity();
                    $dataExtra->setid_entity($id);
                    $dataExtra->setDataExtra($data);
                    $this->entityManager->persist($dataExtra);
                    $this->entityManager->flush();
                    return new JsonModel(["message"=>"Creado"]);
                } else {
                    $this->entityManager->getRepository(extrasEntity::class)->updateData(".dataExtra",$data, $id);
                    return new JsonModel(["message" => "Se actualizaron los datos"]);
                }
                break;
            default:
                return new JsonModel(["message"=>"hello"]);

        }
    }

    public function naveadminAction(){
        $query = $this->params()->fromPost("query");

        switch ($query) {
            case 1:
                $id_nave = $this->params()->fromPost("id");
                $id_user = $this->params()->fromPost("id_user");
                $naves = $this->entityManager->getRepository(naveEntity::class)->findById($id_nave);
                $ids = [];
                foreach ($naves as $nave){
                    $ids['id'] = $nave->getparque_id();
                    $this->entityManager->getRepository(inquilino_naveEntity::class)->updateData(".isAmpip", $id_user, $ids['id']);                    
                }

                return new JsonModel(["message"=>$ids['id']]);
                break;
            case 2:
                $id_user = $this->params()->fromPost("id_user");
                $inquilino = $this->entityManager->getRepository(inquilino_naveEntity::class)->findBy(["isAmpip"=>$id_user]);
                $roleList = [];
                foreach($inquilino as $item){
                    $roleList["id"] = $item->getid();
                    $roleList["corp"] = $item->getcorporativo();
                    $roleList["nombre_es"] = $item->getnombre_es();
                    $roleList["nombre_en"] = $item->getnombre_en();
                    $roleList["propietario"] = $item->getpropietario();
                    $roleList["nombre_empresa"] = $item->getnombreEmpresa();
                    $roleList["numero_empleados"] = $item->getnumEmpleados();
                    $roleList["pais_origen"] = $item->getpaisOrigen();
                    $roleList["producto_insignia"] = $item->getproductoInsignia();
                    $roleList["sector"] = $item->getsectorEmpresarial();
                    $roleList["antiguedad"] = $item->getantiguedad();
                }
                return new JsonModel([$roleList]);
                break;

        }

    }
}

