<?php
// Verificar si el formulario ha sido enviado
if (isset($_POST["aggoferta"])) {
    // Conectar a la base de datos (debes incluir tu propia lógica de conexión)
    include_once "db_proyecto.php";
    $conn=mysqli_connect($host,$user,$password,$db);

    $id_producto= $_POST['id_producto'];
    $nombre_producto = $_POST['nombre'];
    $precio_producto = $_POST['precio'];
    $descuento = $_POST['descuento'] / 100;    
    $fecha_inicio = $_POST['f_inicio'];
    $Fecha_fin= $_POST['f_fin'];
    $precio_descuento = $precio_producto - ($precio_producto * $descuento);

    $sql_verificar_oferta = "SELECT id_oferta FROM tofertas WHERE id_producto = '$id_producto' AND fin_oferta >= CURDATE()";
    $resultado_verificar_oferta = $conn->query($sql_verificar_oferta);

if ($resultado_verificar_oferta->num_rows > 0) {
    // Si se encuentra una oferta activa, mostrar un mensaje de error
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo 'El producto ya tiene una oferta activa.';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
} else {
    // Si no se encuentra una oferta activa, proceder con la inserción de la nueva oferta
    $sql = "INSERT INTO tofertas (id_producto, inicio_oferta, fin_oferta, descuento, precio_descuento) 
            VALUES ('$id_producto', '$fecha_inicio', '$Fecha_fin', '$descuento', $precio_descuento)";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo 'Se ha creado la oferta correctamente.';
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
        echo '<script>';
        echo 'setTimeout(function() { window.location.href = "CrudProductos.php"; }, 2500);'; // Redirecciona después de 3 segundos
        echo '</script>';
    } else {
        echo "Error al crear la oferta: " . $conn->error;
    }
}
    

    
     ?>
    
     
    
    <script>history.replaceState(null,null,location.pathname)</script>
    
<?php  $conn->close()  ;
}?>
