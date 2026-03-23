<?php
/**
 * Clase Base para Modelos - DeporteFit POO
 * 
 * Clase abstracta que proporciona métodos comunes para todos los modelos
 */

abstract class ModeloBase {
    protected $db;
    protected $tableName;
    protected $fillable = [];
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Obtener todos los registros
     */
    public function all($orderBy = 'id', $order = 'DESC') {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY {$orderBy} {$order}";
        $result = $this->db->query($sql);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    /**
     * Obtener registros por usuario
     */
    public function getByUsuario($usuarioId, $orderBy = 'id', $order = 'DESC') {
        $sql = "SELECT * FROM {$this->tableName} WHERE usuario_id = ? OR usuario_id IS NULL ORDER BY {$orderBy} {$order}";
        $result = $this->db->query($sql, [$usuarioId]);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    /**
     * Obtener un registro por ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        
        return $result->fetch_assoc();
    }
    
    /**
     * Crear un nuevo registro
     */
    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$placeholders})";
        
        $result = $this->db->execute($sql, array_values($data));
        
        return [
            'success' => $result['affected_rows'] > 0,
            'id' => $result['insert_id'],
            'error' => $result['error']
        ];
    }
    
    /**
     * Actualizar un registro
     */
    public function update($id, $data) {
        $sets = [];
        foreach (array_keys($data) as $key) {
            $sets[] = "{$key} = ?";
        }
        
        $sql = "UPDATE {$this->tableName} SET " . implode(', ', $sets) . " WHERE id = ?";
        
        $params = array_values($data);
        $params[] = $id;
        
        $result = $this->db->execute($sql, $params);
        
        return [
            'success' => $result['affected_rows'] >= 0,
            'error' => $result['error']
        ];
    }
    
    /**
     * Eliminar un registro
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
        $result = $this->db->execute($sql, [$id]);
        
        return [
            'success' => $result['affected_rows'] > 0,
            'error' => $result['error']
        ];
    }
    
    /**
     * Contar registros
     */
    public function count($condition = '', $params = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->tableName}";
        
        if (!empty($condition)) {
            $sql .= " WHERE {$condition}";
        }
        
        $result = $this->db->query($sql, $params);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    /**
     * Obtener el primero registro
     */
    public function first($condition = '', $params = []) {
        $sql = "SELECT * FROM {$this->tableName}";
        
        if (!empty($condition)) {
            $sql .= " WHERE {$condition}";
        }
        
        $sql .= " LIMIT 1";
        
        $result = $this->db->query($sql, $params);
        
        return $result->fetch_assoc();
    }
}
