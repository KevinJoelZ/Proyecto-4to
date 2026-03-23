<?php
/**
 * Modelo Rutina - DeporteFit POO
 * 
 * Maneja las operaciones CRUD para rutinas de entrenamiento
 */

require_once __DIR__ . '/ModeloBase.php';

class Rutina extends ModeloBase {
    protected $tableName = 'rutinas';
    
    /**
     * Obtener rutinas con sus ejercicios
     */
    public function getWithEjercicios($usuarioId = null) {
        $rutinas = $this->getByUsuario($usuarioId);
        
        foreach ($rutinas as &$rutina) {
            $rutina['ejercicios'] = $this->getEjercicios($rutina['id']);
        }
        
        return $rutinas;
    }
    
    /**
     * Obtener ejercicios de una rutina
     */
    public function getEjercicios($rutinaId) {
        $sql = "SELECT * FROM ejercicios WHERE rutina_id = ? ORDER BY orden";
        $result = $this->db->query($sql, [$rutinaId]);
        
        $ejercicios = [];
        while ($row = $result->fetch_assoc()) {
            $ejercicios[] = $row;
        }
        
        return $ejercicios;
    }
    
    /**
     * Crear rutina con ejercicios
     */
    public function createWithEjercicios($data, $ejercicios = []) {
        // Iniciar transacción
        $this->db->beginTransaction();
        
        try {
            // Crear rutina
            $result = $this->create($data);
            
            if (!$result['success']) {
                throw new Exception($result['error']);
            }
            
            $rutinaId = $result['id'];
            
            // Agregar ejercicios
            if (!empty($ejercicios)) {
                foreach ($ejercicios as $index => $ejercicio) {
                    $ejercicio['rutina_id'] = $rutinaId;
                    $ejercicio['orden'] = $index;
                    
                    $this->createEjercicio($ejercicio);
                }
            }
            
            // Confirmar transacción
            $this->db->commit();
            
            return [
                'success' => true,
                'id' => $rutinaId,
                'message' => 'Rutina creada exitosamente'
            ];
            
        } catch (Exception $e) {
            // Revertir transacción
            $this->db->rollback();
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Crear un ejercicio
     */
    public function createEjercicio($data) {
        $sql = "INSERT INTO ejercicios (rutina_id, nombre, series, repeticiones, peso, descanso, orden) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['rutina_id'],
            $data['nombre'],
            $data['series'],
            $data['repeticiones'],
            $data['peso'] ?? null,
            $data['descanso'] ?? 60,
            $data['orden'] ?? 0
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    /**
     * Eliminar rutina con sus ejercicios
     */
    public function deleteWithEjercicios($id) {
        $this->db->beginTransaction();
        
        try {
            // Eliminar ejercicios primero
            $sql = "DELETE FROM ejercicios WHERE rutina_id = ?";
            $this->db->execute($sql, [$id]);
            
            // Eliminar rutina
            $result = $this->delete($id);
            
            $this->db->commit();
            
            return [
                'success' => true,
                'message' => 'Rutina eliminada'
            ];
            
        } catch (Exception $e) {
            $this->db->rollback();
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Eliminar ejercicios de una rutina
     */
    public function deleteEjercicios($rutinaId) {
        $sql = "DELETE FROM ejercicios WHERE rutina_id = ?";
        return $this->db->execute($sql, [$rutinaId]);
    }
    
    /**
     * Agregar un ejercicio a una rutina
     */
    public function addEjercicio($rutinaId, $data) {
        $data['rutina_id'] = $rutinaId;
        return $this->createEjercicio($data);
    }
    
    /**
     * Obtener tipos de rutinas disponibles
     */
    public function getTipos() {
        return ['fuerza', 'cardio', 'flexibilidad', 'tecnica', 'resistencia'];
    }
    
    /**
     * Obtener niveles de dificultad
     */
    public function getDificultades() {
        return ['principiante', 'intermedio', 'avanzado'];
    }
}
