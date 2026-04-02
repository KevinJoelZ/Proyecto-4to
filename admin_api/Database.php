<?php
/**
 * Clase Base de Conexión a la Base de Datos
 * DeporteFit - POO Architecture
 * 
 * Esta clase maneja la conexión a MySQL usando MySQLi
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // Configuración de la base de datos
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'plataforma_fitness';
    
    /**
     * Constructor - Establece la conexión a la base de datos
     */
    private function __construct() {
        $this->connection = new mysqli(
            $this->host, 
            $this->username, 
            $this->password, 
            $this->database
        );
        
        if ($this->connection->connect_error) {
            throw new Exception("Error de conexión: " . $this->connection->connect_error);
        }
        
        $this->connection->set_charset("utf8mb4");
    }
    
    /**
     * Obtener instancia única (Singleton)
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    /**
     * Obtener la conexión
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Ejecutar una consulta SELECT
     */
    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en prepare: " . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar query: " . $stmt->error);
        }
        $result = $stmt->get_result();
        
        return $result;
    }
    
    /**
     * Ejecutar una consulta INSERT/UPDATE/DELETE
     */
    public function execute($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en prepare: " . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar sentencia: " . $stmt->error);
        }
        
        return [
            'affected_rows' => $stmt->affected_rows,
            'insert_id' => $stmt->insert_id,
            'error' => $stmt->error
        ];
    }
    
    /**
     * Obtener último ID insertado
     */
    public function getLastInsertId() {
        return $this->connection->insert_id;
    }
    
    /**
     * Iniciar transacción
     */
    public function beginTransaction() {
        $this->connection->begin_transaction();
    }
    
    /**
     * Confirmar transacción
     */
    public function commit() {
        $this->connection->commit();
    }
    
    /**
     * Revertir transacción
     */
    public function rollback() {
        $this->connection->rollback();
    }
    
    /**
     * Cerrar conexión
     */
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    // Previene la clonación del objeto
    private function __clone() {}
    
    // Previene la deserialización
    public function __wakeup() {
        throw new Exception("No se puede deserializar singleton");
    }
}
