<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportConnect - Portal Deportivo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0d2c45 0%, #1a4b6d 100%);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        .container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1000px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .logo {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            font-size: 2.5rem;
            color: #4CAF50;
        }
        
        .logo-text {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .content {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            width: 100%;
            justify-content: center;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.8rem;
            color: #4CAF50;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus, 
        .form-group textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.4);
        }
        
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #4CAF50, #2E7D32);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .preview-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        
        .preview-title {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #4CAF50;
        }
        
        .preview-content {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 20px;
            color: #333;
            min-height: 300px;
        }
        
        .preview-image {
            width: 100%;
            height: 180px;
            background: #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #777;
            overflow: hidden;
        }
        
        .preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        
        .preview-item-title {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: #2E7D32;
        }
        
        .preview-item-desc {
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
                align-items: center;
            }
            
            .form-container, .preview-container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    
    <div class="container">
        <div class="logo">
            <i class="fas fa-running logo-icon"></i>
            <span class="logo-text">SportConnect</span>
        </div>
        
        <div class="content">
            <div class="form-container">
                <h2 class="form-title">Añadir Contenido Deportivo</h2>
                <form id="sportForm">
                    <div class="form-group">
                        <label for="image">Imagen (URL):</label>
                        <input type="text" id="image" placeholder="Pega la URL de una imagen deportiva">
                    </div>
                    
                    <div class="form-group">
                        <label for="title">Título:</label>
                        <input type="text" id="title" placeholder="Ej: Entrenamiento de alto rendimiento">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <textarea id="description" placeholder="Describe el contenido deportivo..."></textarea>
                    </div>
                    
                    <button type="button" class="submit-btn" onclick="updatePreview()">
                        <i class="fas fa-plus-circle"></i> Crear Contenido
                    </button>
                </form>
            </div>
            
            <div class="preview-container">
                <h2 class="preview-title">Vista Previa</h2>
                <div class="preview-content">
                    <div class="preview-image">
                        <img id="previewImg" src="" alt="Vista previa">
                        <span id="noImageText">Imagen de ejemplo</span>
                    </div>
                    <h3 class="preview-item-title" id="previewTitle">Título del contenido</h3>
                    <p class="preview-item-desc" id="previewDesc">La descripción de tu contenido deportivo aparecerá aquí.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Inicializar partículas
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": ["circle", "polygon"],
                        "polygon": {
                            "sides": 6
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true
                    },
                    "size": {
                        "value": 5,
                        "random": true
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#4CAF50",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 3,
                        "direction": "none",
                        "random": true,
                        "out_mode": "out"
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        }
                    }
                }
            });
        });
        
        // Función para actualizar la vista previa
        function updatePreview() {
            const imageUrl = document.getElementById('image').value;
            const title = document.getElementById('title').value || 'Título del contenido';
            const description = document.getElementById('description').value || 'La descripción de tu contenido deportivo aparecerá aquí.';
            
            const previewImg = document.getElementById('previewImg');
            const noImageText = document.getElementById('noImageText');
            const previewTitle = document.getElementById('previewTitle');
            const previewDesc = document.getElementById('previewDesc');
            
            if (imageUrl) {
                previewImg.src = imageUrl;
                previewImg.style.display = 'block';
                noImageText.style.display = 'none';
            } else {
                previewImg.style.display = 'none';
                noImageText.style.display = 'block';
            }
            
            previewTitle.textContent = title;
            previewDesc.textContent = description;
        }
        
        // Inicializar vista previa
        updatePreview();
    </script>
</body>
</html>