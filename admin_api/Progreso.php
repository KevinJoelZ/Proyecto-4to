<?php
/**
 * Modelo Progreso - DeporteFit POO
 * 
 * Maneja las operaciones CRUD para progresos (peso, medidas, entrenamientos)
 */

require_once __DIR__ . '/ModeloBase.php';

class Progreso extends ModeloBase {
    protected $tableName = 'progresos_peso';
    
    /**
     * Obtener historial de peso
     */
    public function getHistorialPeso($usuarioId) {
        return $this->getByUsuario($usuarioId, 'fecha_medicion', 'DESC');
    }
    
    /**
     * Obtener último peso registrado
     */
    public function getUltimoPeso($usuarioId) {
        return $this->first('usuario_id = ? ORDER BY fecha_medicion DESC', [$usuarioId]);
    }
    
    /**
     * Obtener peso inicial
     */
    public function getPesoInicial($usuarioId) {
        return $this->first('usuario_id = ? ORDER BY fecha_medicion ASC', [$usuarioId]);
    }
    
    /**
     * Calcular kg perdidos
     */
    public function getKgPerdidos($usuarioId) {
        $inicial = $this->getPesoInicial($usuarioId);
        $actual = $this->getUltimoPeso($usuarioId);
        
        if (!$inicial || !$actual) {
            return 0;
        }
        
        return $inicial['peso'] - $actual['peso'];
    }
    
    // ===== MEDIDAS CORPORALES =====
    
    /**
     * Modelo de medidas corporales
     */
    public function getMedidas($usuarioId) {
        $sql = "SELECT * FROM medidas_corporales WHERE usuario_id = ? OR usuario_id IS NULL ORDER BY fecha_medicion DESC";
        $result = $this->db->query($sql, [$usuarioId]);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    /**
     * Guardar medidas corporales
     */
    public function saveMedidas($data) {
        $sql = "INSERT INTO medidas_corporales (usuario_id, fecha_medicion, pecho, cintura, cadera, biceps, pierna, notas) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['usuario_id'],
            $data['fecha'],
            $data['pecho'] ?? null,
            $data['cintura'] ?? null,
            $data['cadera'] ?? null,
            $data['biceps'] ?? null,
            $data['pierna'] ?? null,
            $data['notas'] ?? ''
        ];
        
        $result = $this->db->execute($sql, $params);
        
        if ($result['affected_rows'] > 0) {
            return [
                'success' => true,
                'message' => 'Medidas corporales guardadas exitosamente',
                'id' => $result['insert_id']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al guardar medidas: ' . ($result['error'] ?? 'Error desconocido')
            ];
        }
    }
    
    // ===== ENTRENAMIENTOS =====
    
    /**
     * Obtener entrenamientos realizados
     */
    public function getEntrenamientos($usuarioId, $limit = 30) {
        $sql = "SELECT * FROM entrenamientos_realizados 
                WHERE usuario_id = ? OR usuario_id IS NULL 
                ORDER BY fecha_entrenamiento DESC 
                LIMIT ?";
        
        $result = $this->db->query($sql, [$usuarioId, $limit]);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    /**
     * Obtener entrenamientos de la semana actual
     */
    public function getEntrenamientosSemana($usuarioId) {
        $sql = "SELECT COUNT(*) as total FROM entrenamientos_realizados 
                WHERE usuario_id = ? 
                AND YEARWEEK(fecha_entrenamiento) = YEARWEEK(NOW())";
        
        $result = $this->db->query($sql, [$usuarioId]);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }
    
    /**
     * Registrar entrenamiento realizado
     */
    public function registrarEntrenamiento($data) {
        $sql = "INSERT INTO entrenamientos_realizados 
                (usuario_id, rutina_id, nombre_rutina, intensidad, sensacion, duracion_real, calorias) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['usuario_id'],
            $data['rutina_id'] ?? null,
            $data['nombre_rutina'] ?? 'Entrenamiento Libre',
            $data['intensidad'] ?? 5,
            $data['sensacion'] ?? 'bien',
            $data['duracion'] ?? null,
            $data['calorias'] ?? null
        ];
        
        $result = $this->db->execute($sql, $params);
        
        // Actualizar objetivo de entrenamientos semanales (ignorar errores si no existe objetivo)
        try {
            $this->actualizarObjetivoEntrenamientos($data['usuario_id']);
        } catch (Exception $e) {
            // Ignorar errores al actualizar objetivos - no es crítico
        }
        
        if ($result['affected_rows'] > 0) {
            return [
                'success' => true,
                'message' => 'Entrenamiento registrado exitosamente',
                'id' => $result['insert_id']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al registrar entrenamiento: ' . ($result['error'] ?? 'Error desconocido')
            ];
        }
    }
    
    /**
     * Total de entrenamientos
     */
    public function getTotalEntrenamientos($usuarioId) {
        return $this->count('usuario_id = ?', [$usuarioId]);
    }
    
    /**
     * Actualizar contador de entrenamientos semanales
     */
    private function actualizarObjetivoEntrenamientos($usuarioId) {
        $total = $this->getEntrenamientosSemana($usuarioId);
        
        $sql = "UPDATE objetivos SET valor_actual = ? 
                WHERE usuario_id = ? AND tipo = 'entrenamientos_semana' AND estado = 'activo'";
        
        $this->db->execute($sql, [$total, $usuarioId]);
    }
    
    // ===== OBJETIVOS =====
    
    /**
     * Obtener objetivos activos
     */
    public function getObjetivos($usuarioId) {
        $sql = "SELECT * FROM objetivos 
                WHERE (usuario_id = ? OR usuario_id IS NULL) AND estado = 'activo'";
        
        $result = $this->db->query($sql, [$usuarioId]);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }
    
    /**
     * Calcular porcentaje de objetivo
     */
    public function calcularPorcentajeObjetivo($objetivo, $pesoInicial, $pesoActual) {
        if ($objetivo['tipo'] === 'peso' && $pesoInicial && $pesoActual) {
            $porcentaje = (($pesoInicial - $pesoActual) / ($pesoInicial - $objetivo['valor_objetivo'])) * 100;
        } elseif ($objetivo['tipo'] === 'entrenamientos_semana') {
            $porcentaje = ($objetivo['valor_actual'] / $objetivo['valor_objetivo']) * 100;
        } else {
            $porcentaje = 0;
        }
        
        return min(100, max(0, round($porcentaje)));
    }
}
