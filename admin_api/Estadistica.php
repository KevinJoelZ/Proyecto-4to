<?php
/**
 * Modelo Estadistica - DeporteFit POO
 * 
 * Maneja las operaciones para obtener estadísticas y logros
 */

require_once __DIR__ . '/Progreso.php';

class Estadistica extends Progreso {
    
    /**
     * Obtener estadísticas completas del usuario
     */
    public function getEstadisticasCompletas($usuarioId) {
        return [
            'total_entrenamientos' => $this->getTotalEntrenamientos($usuarioId),
            'semanas_activo' => $this->getSemanasActivo($usuarioId),
            'kg_perdidos' => $this->getKgPerdidos($usuarioId),
            'cumplimiento' => $this->getCumplimiento($usuarioId),
            'entrenamientos_semana' => $this->getEntrenamientosSemana($usuarioId),
            'peso_actual' => $this->getUltimoPeso($usuarioId),
            'peso_inicial' => $this->getPesoInicial($usuarioId),
            'objetivos' => $this->getProgresoObjetivos($usuarioId),
            'progreso_semanal' => $this->getProgresoSemanal($usuarioId),
            'logros' => $this->getLogros($usuarioId)
        ];
    }
    
    /**
     * Calcular semanas activo
     */
    public function getSemanasActivo($usuarioId) {
        $sql = "SELECT MIN(fecha_entrenamiento) as primera, MAX(fecha_entrenamiento) as ultima 
                FROM entrenamientos_realizados 
                WHERE usuario_id = ?";
        
        $result = $this->db->query($sql, [$usuarioId]);
        $row = $result->fetch_assoc();
        
        if ($row['primera'] && $row['ultima']) {
            $primera = new DateTime($row['primera']);
            $ultima = new DateTime($row['ultima']);
            $diff = $primera->diff($ultima);
            return max(1, floor($diff->days / 7));
        }
        
        return 0;
    }
    
    /**
     * Obtener porcentaje de cumplimiento
     */
    public function getCumplimiento($usuarioId) {
        $entrenamientosSemana = $this->getEntrenamientosSemana($usuarioId);
        $objetivoSemanal = 4; // Objetivo de 4 entrenamientos por semana
        
        return min(100, round(($entrenamientosSemana / $objetivoSemanal) * 100));
    }
    
    /**
     * Obtener progreso de objetivos
     */
    public function getProgresoObjetivos($usuarioId) {
        $objetivos = $this->getObjetivos($usuarioId);
        $pesoInicial = $this->getPesoInicial($usuarioId);
        $pesoActual = $this->getUltimoPeso($usuarioId);
        
        foreach ($objetivos as &$objetivo) {
            $objetivo['porcentaje'] = $this->calcularPorcentajeObjetivo(
                $objetivo, 
                $pesoInicial['peso'] ?? 0, 
                $pesoActual['peso'] ?? 0
            );
        }
        
        return $objetivos;
    }
    
    /**
     * Obtener progreso de los últimos 7 días
     */
    public function getProgresoSemanal($usuarioId) {
        $diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];
        $progreso = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $fecha = date('Y-m-d', strtotime("-$i days"));
            $dia = $diasSemana[date('N', strtotime($fecha)) - 1];
            
            $sql = "SELECT COUNT(*) as total, SUM(intensidad) as intensidad 
                    FROM entrenamientos_realizados 
                    WHERE usuario_id = ? AND DATE(fecha_entrenamiento) = ?";
            
            $result = $this->db->query($sql, [$usuarioId, $fecha]);
            $row = $result->fetch_assoc();
            
            $valor = 0;
            if ($row['total'] > 0) {
                $valor = $row['intensidad'] ? ($row['intensidad'] / 10) * 10 : 50;
            }
            
            $progreso[] = [
                'dia' => $dia,
                'valor' => $valor,
                'tiene_entreno' => $valor > 0
            ];
        }
        
        return $progreso;
    }
    
    /**
     * Obtener logros del usuario
     */
    public function getLogros($usuarioId) {
        $logros = [];
        
        // Racha de 7 días
        $sql = "SELECT COUNT(DISTINCT DATE(fecha_entrenamiento)) as dias 
                FROM entrenamientos_realizados 
                WHERE usuario_id = ? 
                AND fecha_entrenamiento >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        
        $result = $this->db->query($sql, [$usuarioId]);
        $row = $result->fetch_assoc();
        
        if ($row['dias'] >= 7) {
            $logros[] = [
                'icono' => 'fa-fire',
                'titulo' => 'Racha de 7 días',
                'descripcion' => '¡Sigue así!',
                'color' => '#ff9800'
            ];
        }
        
        // 20 entrenamientos
        $total = $this->getTotalEntrenamientos($usuarioId);
        if ($total >= 20) {
            $logros[] = [
                'icono' => 'fa-dumbbell',
                'titulo' => '20 Entrenamientos',
                'descripcion' => 'Meta alcanzada',
                'color' => '#43a047'
            ];
        }
        
        // Primer 5K
        if ($total >= 3) {
            $logros[] = [
                'icono' => 'fa-running',
                'titulo' => 'Primer 5K',
                'descripcion' => 'Completado',
                'color' => '#1976d2'
            ];
        }
        
        return $logros;
    }
    
    /**
     * Obtener métricas diarias
     */
    public function getMetricasDiarias($usuarioId) {
        $sql = "SELECT 
                    SUM(calorias) as calorias,
                    SUM(duracion_real) as duracion
                FROM entrenamientos_realizados 
                WHERE usuario_id = ? 
                AND DATE(fecha_entrenamiento) = CURDATE()";
        
        $result = $this->db->query($sql, [$usuarioId]);
        $row = $result->fetch_assoc();
        
        return [
            'calorias' => $row['calorias'] ?? 0,
            'duracion' => $row['duracion'] ?? 0
        ];
    }
}
