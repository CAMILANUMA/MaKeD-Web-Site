<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quienes Somos?</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .contenedor {
      height: 20%;
      margin: 0% 11%;
    }

    html,
    body {
      height: 100%;
    }

    .contenedorR {
      height: 20%;
      margin: 0% 20%;
    }

    html,
    body {
      height: 100%;
    }

    .contenedorL {
      height: 20%;
      margin: 0% 16%;
    }

    html,
    body {
      height: 100%;
    }

    input {
      border-radius: 10px;
    }

    .contenedorM {
      height: 100%;
      margin: -9% 60%;
    }

    #nombre {
      width: 400px;
      /* Ajusta el ancho */
      height: 50px;
      /* Ajusta la altura */
    }

    #correo {
      width: 400px;
      /* Ajusta el ancho */
      height: 50px;
      /* Ajusta la altura */
    }

    #telefono {
      width: 400px;
      /* Ajusta el ancho */
      height: 50px;
      /* Ajusta la altura */
    }

    #mensaje {
      width: 400px;
      /* Ajusta el ancho */
      height: 100px;
      /* Ajusta la altura */

    }

    #enviar {
      width: 200px;
      margin: -20% 71%;
    }

    .nav-link {
      position: relative;
      display: inline-block;
      text-decoration: none;
      color: black;
      transition: transform 0.3s ease, background-color 0.3s ease;
      border-radius: 15px;
      /* Mantener el border-radius */
      overflow: hidden;
      /* Asegura que el border-radius se mantenga */
      padding: 10px 20px;
      /* Ajustar el padding para el efecto de tamaño */
      height: 60px;
    }

    .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #5df1f67d;
      ;
      /* Color de iluminación */
      transform: scale(0);
      transition: transform 0.3s ease;
      border-radius: 10px;
      /* Asegura el border-radius en el pseudo-elemento */
      z-index: -1;
      /* Pone el pseudo-elemento detrás del texto */
    }

    .nav-link:hover::before {
      transform: scale(1);
    }

    .nav-link:hover {
      transform: scale(1.1);
      /* Aumento del tamaño */
    }

    .btn {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 10px;
      /* Opcional: agregar border-radius a los botones */
    }

    .btn:hover {
      transform: scale(1.1);
      /* Aumento del tamaño */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      /* Sombra para iluminación */
    }
  </style>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <br>
  <div class="container text-center">
    <div class="row">
      <div class="col" align="left">
        <img src="makedlogo.png" width="120" height="30">
      </div>
      <div class="col">
        <a class="nav-link py-2 px-0 px-lg-2" href="index.html" color="black" onclick="href='index.html'">
          <p>INICIO</p>
        </a>
      </div>
      <div class="col">
        <a class="nav-link py-2 px-0 px-lg-3" href="quienesSomos.php" onclick="href='quienesSomos.php'">
          <p>¿QUIÉNES SOMOS?</p>
        </a>
      </div>
      <div class="col">
        <a class="nav-link py-2 px-0 px-lg-2" href="empresas.html" onclick="href='empresas.html'">
          <p>EMPRESA</p>
        </a>
      </div>
      <div class="col">
        <a class="nav-link py-2 px-0 px-lg-2" href="programador.html" onclick="href='programador.html'">
          <p>PROGRAMADOR</p>
        </a>
      </div>
      <div class="col" align="right">
        <button type="button" class="btn btn-light" onclick="window.location.href='iniciarSesion.php'">Iniciar sesión</button>
      </div>
      <div class="col" align="left">
        <button type="button" class="btn btn-info" onclick="window.location.href='registro.php'">Registro</button>
      </div>
    </div>
  </div>

  <div>
    <br>
    <h1 class="text-center">¿QUIENES SOMOS?</h1>
    <br>

    <center>
      <table width="1000" height="10">
        <tr>
          <td>
            <p class="fs-4" style="text-align: center;">Somos una empresa dedicada a conectar de manera eficiente a programadores y empresas, facilitando el proceso de contratación mediante nuestra plataforma. Ofrecemos a las empresas la oportunidad de encontrar el talento ideal para proyectos, por medio de vinculaciones rápidas y sencillas, mientras brindamos a los programadores un acceso directo a oportunidades laborales que se ajustan a sus habilidades y aspiraciones.</p>
          </td>
        </tr>
      </table>
    </center>

  </div>

  <br><br>

  <div class="contenedorL">
    <table width="380px" height="-1000px">
      <tr>
        <td>
          <b class="fs-5">Utiliza las siguientes vías de contacto,<br> o rellena el formulario. </b>
          <br><br><br>
          <p class="fs-5">Vía E-mail</p>
          <a href="mailto:makedjobs@gmail.com" class="fs-6" style="color:#0cc0df;">makedjobs@hotmail.com</a>
          <br><br><br>
          <p class="fs-5">En nuestras redes sociales</p>
          <a href="mailto:@unsitiogenial" class="fs-6" style="color:#0cc0df;">@makedjobscol</a>
          <br><br><br>
          <p class="fs-5">Por teléfono</p>
          <a href="mailto:91-1234-567" class="fs-6" style="color:#0cc0df;">01 800 900 900</a>
          <br><br>

    </table>
    </td>
    </tr>
    </table>
  </div>
  <form method="post" action="correoQuienes.php">
    <div class="contenedorM">
      <input type="text" name="nombre" placeholder="Escribe tu nombre" required>
      <br><br>
      <input type="email" name="correo" placeholder="Escribe tu correo" required>
      <br><br>
      <input type="text" name="telefono" placeholder="Escribe tu telefono (Opcional)">
      <br><br>
      <input type="text" name="mensaje" placeholder="escribe tu mensaje" required>
      <br><br>
      <input type="submit" class="btn btn-info" value="Enviar Mensaje" name="enviar" background-color:#0cc0df;>
  </form>
  </div>
</body>

</html>


  