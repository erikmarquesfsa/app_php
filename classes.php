<?php
// classes.php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "cafeteria_poo";
    public $conexao;

    public function conectar() {
        $this->conexao = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conexao->connect_error) {
            die("Erro de conexão: " . $this->conexao->connect_error);
        }
        return $this->conexao;
    }
}

class Usuario {
    private $db;

    public function __construct($conexao_banco) {
        $this->db = $conexao_banco;
    }

    public function autenticar($usuario, $senha) {
        $sql = "SELECT id, nome FROM usuarios WHERE usuario = ? AND senha = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $usuario, $senha);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($linha = $resultado->fetch_assoc()) {
            return $linha; // Retorna os dados do usuário se logar
        }
        return false; // Retorna falso se errar a senha
    }
}

class Produto {
    private $db;

    public function __construct($conexao_banco) {
        $this->db = $conexao_banco;
    }

    public function cadastrar($nome, $categoria, $descricao, $preco) {
        $sql = "INSERT INTO produtos (nome, categoria, descricao, preco) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        // "sssd": string (nome), string (categoria), string (descricao), double (preco)
        $stmt->bind_param("sssd", $nome, $categoria, $descricao, $preco);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>