<?php 

	class UsuariosModel extends Mysql
	{
		private $intidusuario;
		private $srtavatar;		
		private $srtpass;
		private $srtnombres;
		private $srtapellidos;	
		private $srtcelular;	
		private $srtcorreo;	
		private $introlid;
      

		public function __construct()
		{
			parent::__construct();
		}	

		public function getusuarios(){
			//EXTRAE conductores
			$sql = "SELECT u.idusuario, u.avatar, u.nombres, u.apellidos, u.celular, u.correo, u.rolid, u.status, r.idrol, r.nombrerol, r.descripcion FROM  usuario as u 
			left join rol as r on u.rolid = r.idrol		
			where u.rolid != 5 ";
			$request = $this->select_all($sql);
			return $request;
		}

		public function insertUsario( String $avatar, String $pass,String $nombres,String $apellidos, String $celular, String $correo, int $rolid ) {
        $this->srtavatar  = $avatar;      
        $this->srtpass  = $pass;      
        $this->srtnombres  = $nombres;
        $this->srtapellidos  = $apellidos;      
        $this->srtcelular  = $celular;     
        $this->srtcorreo  = $correo;      
        $this->introlid  = $rolid;    
        $return = 0;
        $sql = "SELECT * FROM usuario WHERE 
            correo = '{$this->srtcorreo}' or celular = '{$this->srtcelular}' ";
        $request = $this->select_all($sql);
        if (empty($request)) {

            $query_insert  = "INSERT INTO usuario(avatar, pass,nombres, apellidos,  celular, correo, rolid )VALUES(?,?,?,?,?,?,?)";
            $arrData = array(
                $this->srtavatar,              
                $this->srtpass,             
                $this->srtnombres,
                $this->srtapellidos,             
                $this->srtcelular,              
                $this->srtcorreo,
                $this->introlid
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateUsuario(int $idusuario,  String $avatar,  String $nombres,  String $apellidos,  String $celular,  String $correo, int $rolid){
    $this->intidusuario = $idusuario;
    $this->srtavatar  = $avatar;      
    $this->srtnombres  = $nombres;
    $this->srtapellidos  = $apellidos;     
    $this->srtcelular  = $celular;   
    $this->srtcorreo  = $correo;   
    $this->introlid  = $rolid;
    $return = 0;
    $sql = "SELECT * FROM usuario WHERE (correo = '{$this->srtcorreo}' or celular = '{$this->srtcelular}')  AND idusuario != $this->intidusuario";
    $request = $this->select_all($sql);
    if (empty($request)) {

        $sql = "UPDATE usuario SET avatar =?, nombres=?, apellidos=?, celular=?,  correo=?,  rolid=? WHERE idusuario = $this->intidusuario  ";
        $arrData = array(
            $this->srtavatar,          
            $this->srtnombres,
            $this->srtapellidos,           
            $this->srtcelular,        
            $this->srtcorreo,          
            $this->introlid
        );
        $request_update  = $this->update($sql, $arrData);
        $return =    $request_update;
    } else {
        $return = "exist";
    }
    return $return;


    }

    public function setPassword(int $idusuario,  String $pass){
        $this->intidusuario = $idusuario;
        $this->srtpass  = $pass; 
            $sql = "UPDATE usuario SET pass =? WHERE idusuario = $this->intidusuario  ";
            $arrData = array(
                $this->srtpass
            );
            $request_update  = $this->update($sql, $arrData);
            $return =    $request_update;       
        return $return;    
    
    }

	public function getUsuario(int $idusuario){
        $this->intidusuario  = $idusuario;

        $sql = "SELECT 
        u.idusuario, u.avatar,  u.nombres, u.apellidos, u.celular,  u.correo, r.idrol, r.nombrerol, u.status
        FROM  usuario as u 
        left join rol as r on u.rolid = r.idrol  
        where u.idusuario = $this->intidusuario";
        $request = $this->select($sql);
        return $request;
    }
    
    public function deleteUsuario(int $intIdpersona)
    {
        $this->intIdUsuario = $intIdpersona;
        $sql = "UPDATE usuario SET status = ? WHERE idusuario = $this->intIdUsuario ";
        $arrData = array(0);
        $request = $this->update($sql,$arrData);
        return $request;
    }

    public function actUsuario(int $intIdpersona)
    {
        $this->intIdUsuario = $intIdpersona;
        $sql = "UPDATE usuario SET status = ? WHERE idusuario = $this->intIdUsuario ";
        $arrData = array(1);
        $request = $this->update($sql,$arrData);
        return $request;
    }



	}
 ?>