<script type="text/javascript">
    /**
    * Función que se encarga de asignar al menú superior la página actual en la que se encuentra el usuario
    * @param page Página en la que se encuentra el usuario
    */
    function setCurrentPage(page){
        var button=document.getElementById(page);
        button.id="current-item";
        var image=button.getElementsByTagName("img")[0];
        image.src=image.src.replace("black","white");
    }

    function switchMenu(){
        var menu=document.getElementsByClassName('app-area')[0];
        if(menu.style.display=='')
            menu.style.display='block';
        else
            menu.style.display='';
    }
</script>

    <link rel="stylesheet" type="text/css" href="../../css/menu.css">
    <?php include "loader.php";?>
    <header class="col-12">
        <a href="../../inicio">
            <img id="logo-hotel" src="../../res/img/logo.png">
        </a>
        <button id="menu-button" onclick="switchMenu();" class="main-menu-item menu-item" >
            <img src="../res/img/home-icon-black.png">
        </button>

        <div class="app-area">
            <button id="inicio" onclick="window.location.href = '../../inicio';" class="main-menu-item menu-item" >
                <img src="../../res/img/home-icon-black.png">
                <p>Inicio</p>
            </button>
            <?php if($user->getRole()!=4):?>
            <div class="dropdown menu-item">
                <button id="registrar" class="main-menu-item">
                    <img src="../../res/img/register-icon-black.png">
                    <p>Registrar</p>
                </button>
                <br>
                <div class="dropdown-content">
                    <a href="../../reservas/registrar">Registar reserva</a>
                    <a href="../../empresas/registrar">Registrar empresas</a>
                    <?php if($user->getRole()==5||$user->getRole()==1):?>
                    <a href="../../usuarios/registrar">Registrar usuarios</a>
                    <?php endif;?>
                </div>
            </div>
            
            <div class="dropdown menu-item">
                <button id="consultar" class="main-menu-item">
                    <img src="../../res/img/book-icon-black.png">
                    <p>Consultar</p>
                </button>
                <br>
                <div class="dropdown-content">
                    <a href="../../reservas">Consultar reservas</a>
                    <a href="../../empresas">Consultar empresas</a>
                    <a href="../../clientes">Consultar clientes</a>
                    <?php if($user->getRole()==5||$user->getRole()==1):?>
                    <a href="../../usuarios">Consultar usuarios</a>
                    <?php endif;?>
                </div>
            </div>
            <?php endif;?>
            <button id="control-diario" onclick="window.location.href = '../../control_diario?date='+getDate(0);" class="main-menu-item menu-item">
                <img src="../../res/img/control-icon-black.png">
                <p>Control diario</p>
            </button>
            <?php if($user->getRole()!=4):?>
            <button id="facturas" onclick="window.location.href = '../../facturas';" class="main-menu-item menu-item">
                <img src="../../res/img/bill-icon-black.png">
                <p>Facturación</p>
            </button>
            <?php endif;?>
        </div>

        <div class="user-area">
            <div class="dropdown menu-item">
                <button class="main-menu-item">
                    <img src="../../res/img/user-icon-black.png">
                </button>
                <br>
                <div class="dropdown-content-right">
                    <a><?php echo $user->getFullName();?></a>
                    <a href="../../includes/logout.php"><i class="fa fa-power-off"></i> Cerrar sesión</a>
                </div>
            </div>
        </div>
    </header>
