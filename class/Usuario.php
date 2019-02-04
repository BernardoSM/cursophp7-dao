<?php 

class Usuario {
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdUsuario(){
		return $this->idusuario;
	}

	public function setIdUsuario($value){
		$this->idusuario = $value;
	}

	public function getDesLogin(){
		return $this->deslogin;
	}

	public function setDesLogin($value){
		$this->deslogin = $value;
	}

	public function getDesSenha(){
		return $this->dessenha;
	}

	public function setDesSenha($value){
		$this->dessenha = $value;
	}

	public function getDtCadastro(){
		return $this->dtcadastro;
	}

	public function setDtCadastro($value){
		$this->dtcadastro = $value;
	}

	public function loadById($id){
		$sql = new Sql(); //chamar o sql para fazer a função do banco

		$results = $sql->select(" SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			":ID"=>$id
		)); //função do banco para puxar do banco o idusuario da tabela tb_usuario (apenas um usuário)

		if (count($results) > 0){ //tratamento de erro para selecionar somente os tb_usuarios existentes
			$row = $results[0];

			$this->setData($results[0]);
		}
	}

	//FUNÇÃO QUE RETORNA A LISTA DE TODOS OS USUÁRIOS DO BANCO
	public static function getList(){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;"); //essa função chama todos os usuários da tabela
	}

	//FUNÇÃO QUE BUSCA OS USUÁRIOS NO BANCO
	public static function search($login){
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"
		));
	}

	//FUNÇÃO QUE PEDE PRO USUÁRIO COLOCAR LOGIN E SENHA
	public function login($login, $password){
		$sql = new Sql(); //chamar o sql para fazer a função do banco

		$results = $sql->select(" SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password
		)); //função do banco para puxar do banco o idusuario da tabela tb_usuario (apenas um usuário)

		if (count($results) > 0){ //tratamento de erro para aceitar o login e senha existentes na tabela tb_usuarios
			$row = $results[0];

			$this->setData($results[0]);
		} else { // caso o login e senha estejam incorretos aparecerá a seguinte mensagem
			throw new Exception("Login e/ou senha inválidos.");
		}
	}

	//FUNÇÃO PARA SIMPLIFICAR O CÓDIGO, FAZ OS SETERS DE TODOS OS VALORES DE UM USUÁRIO DA TABELA
	public function setData($data){
		$this->setIdUsuario($data["idusuario"]);
		$this->setDesLogin($data["deslogin"]);
		$this->setDesSenha($data["dessenha"]);
		$this->setDtCadastro(new DateTime($data["dtcadastro"]));
	}

	//FUNÇÃO QUE INSERE UM NOVO USUÁRIO E SENHA
	public function insert(){
		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha()
		));

		if (count($results) > 0){
			$this->setData($results[0]);
		}
	}

	//FUNÇÃO PARA ATUALIZAR UM NOVO USUÁRIO E SENHA
	public function update($login, $password){
		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdusuario()
		));
	}

	//FUNÇÃO DE DELETAR UM USUÁRIO
	public function delete(){
		$sql = new Sql();
		$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
			':ID'=>$this->getIdusuario()
		));

		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(new DateTime());
	}

	public function __construct($login = "", $password = ""){ //colocando as aspas vai preencher a variável com nada se ela não for chamada, então a torna não obrigatória
		$this->setDeslogin($login);
		$this->setDessenha($password);
	}

	public function __toString(){
		return json_encode(array(
			"idusuario"=>$this->getIdUsuario(),
			"deslogin"=>$this->getDesLogin(),
			"dessenha"=>$this->getDesSenha(),
			"dtcadastro"=>$this->getDtCadastro()->format("d/m/Y H:i:s")
		));
	}
}

 ?>