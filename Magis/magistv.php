<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra completa MagisTv</title>
    <link rel="stylesheet" href="magis-styles.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://palmaafricana.excancrigru.es/Archivos//css/loaderAros.css">
</head>
<div class="myLoader2" id="cargasgeneral" style="display: none;">
    <div class="loader2">
        <div id="ring"></div>
        <div id="ring"></div>
        <div id="ring"></div>
        <div id="ring"></div>
        <div id="h3">Verificando</div>
    </div>
</div>
<body>
    <div class="container">
        <img src="/wp-content/themes/ComunicaWeb/img/Mesa_de_trabajo_1.png" alt="Logo" class="logo">
        <form id="codigoForm">
            <div class="form-group">
                <label for="codigo">Ingrese código de descarga</label>
                <input type="text" id="codigo" name="codigo" >
            </div>
            <button type="submit" id="enviarBtn2">Enviar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
       
       
        
        function verificarCodigo() {
            var codigoIngresado = $('#codigo').val();
            
            
            if (codigoIngresado.trim() === '') {
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Por favor, ingresa un código',
                });
                return; 
            }
            
            
            document.getElementById("cargasgeneral").style.display = "block";
        
            setTimeout(function() {
                $.ajax({
                    url: 'verificar_codigo.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { codigo: codigoIngresado }, 
                    success: function(data) {
                        
                        if (data.error) {
                           
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error
                            });
                        } else {
                            
                            if (data.Codigo && data.Codigo === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Código Correcto, su descarga iniciará en breve ...',
                                    timer: 2000, // Cierra el mensaje después de 2 segundos
                                    timerProgressBar: true,
                                    onClose: () => {
                                        window.location.href = 'https://comunicadigitalec.com/wp-content/themes/ComunicaWeb/apk/magistv.apk';
                                    }
                                });
                            }
                        }
                    },
                    error: function() {
                        console.error('Error: Hubo un problema con la verificación del código.');
                       
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema con la verificación del código. Inténtelo de nuevo más tarde.'
                        });
                    },
                    complete: function() {
                        
                        document.getElementById("cargasgeneral").style.display = "none";
                    }
                });
            }, 3000); 
        }
        
       
       
        </script>
</body>
</html>