<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegistroProductos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e3fc2f4517.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/styleRP.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/ModalRegistro.css">
    <script src="./js/menu.js"></script>
</head>
<body>
  <div class="table-wrapper">
    <div class="col-sm-6" id="AD">
      <h1 class="text-center p-3">Administrador de Productos</h1>
    </div>
    
  </div>

  <!-- Botón para mostrar/ocultar formulario -->
  <div class="text-center">
    <button class="btn btn-primary" id="mostrarFormulario">Registrar Producto</button>
  </div>

  <div class="modal" id="RegistModal" tabindex="-1" role="dialog" aria-labelledby="RegistModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="RegistModalLabel">Registrar Producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid row r">
            <form class="col-12 p-3 s" id="formRegistroProducto" method="POST">
              <h3 class="text-center text-secundary">Registro de productos</h3>
              <div class="mb-3">
                  <label for="exampleInputCodigo" class="form-label i">Código de Barras</label>
                  <input type="text" class="form-control" name="CodigoB" required>
              </div>
              <div class="mb-3">
                  <label for="exampleInputPrecio" class="form-label i">Precio</label>
                  <input type="number" class="form-control" name="Precio" required step="0.01">
              </div>
              <div class="mb-3">
                  <label for="exampleInputDescripcion" class="form-label i">Descripción</label>
                  <input type="text" class="form-control" name="Descripcion" required>
              </div>
              <div class="mb-3">
                  <label for="exampleInputStock" class="form-label i">Stock</label>
                  <input type="number" class="form-control" name="Stock" required min="0">
              </div>
              <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Los mensaje se cargarán aquí -->
  <div id="mensaje"></div>

  <div class="col-12 d-flex justify-content-center">
    <table class="table" id="tablaProductos">
      <thead class="containerth">
        <tr>
          <th scope="col">CodigoDeBarras</th>
          <th scope="col">Precio</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Stock</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Los productos se cargarán aquí dinámicamente -->
      </tbody>
    </table>
  </div>
  <div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="form-group">
              <label for="codigoB">Código de Barras:</label>
              <input type="number" id="codigoB" name="CodigoB" class="form-control" readonly required>
            </div>
            <div class="form-group">
              <label for="precio">Precio:</label>
              <input type="number" id="precio" name="Precio" class="form-control" required step="0.01">
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción:</label>
              <input type="text" id="descripcion" name="Descripcion" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="stock">Stock:</label>
              <input type="number" id="stock" name="Stock" class="form-control" required min="0">
            </div>
            <button type="submit" id="btnEditar" class="btn btn-success">Guardar cambios</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
