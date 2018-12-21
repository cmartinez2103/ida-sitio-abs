<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?php echo $data["mail_titulo"];?></title>
</head>
<body bgcolor="#FFFFFF">
  <div style="background: #F2F4F5; margin: 0 auto; padding: 16px; border:1px solid #cccccc;">
    <div class="content" style="width: 100%; margin: 0 auto; padding: 32px 0; overflow:hidden; height: auto; display: block; position: relative; border-bottom: 1px solid #cccccc;">
      <img style="width:150px; margin: 0 auto 0 0; display: block;" src="<?php echo $data["imagen_encabezado"];?>">
    </div>
    <div class="content" style="max-width: 100%; margin: 0 auto;  padding:  2% 1%;">
        <h1>Hola.</h1>
        <p>
          <?php echo $data["nombre"]?> te quiere compartir una página American British School.
        </p>

        <b>Link :</b> <a href="<?php echo $data["url"];?>"><?php echo $data["title"];?></a>

        <br />

        <p>
          <b>Nota de <?php echo $data["nombre"];?> :</b> <?php echo $data["nota"];?>
        </p>
    </div>
  </div>
</body>
</html>
