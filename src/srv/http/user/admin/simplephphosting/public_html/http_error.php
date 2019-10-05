<?php
$errorCode = (int)@$_GET["code"];
switch($errorCode){
    case 401: case 402: case 403: case 404:
    case 500: case 503:
        break;
    default:
        $errorCode = 404;
        break;
}
$requestPage = isset($_SERVER["HTTP_REFERER"])?" \"".$_SERVER["HTTP_REFERER"]."\"":"";
include("static/http_error/".$errorCode.".php");
$iframePage = true;
include "static/header.php";
?>
    <main>
        <section class="slider">
            <div class="section-title"></div>
            <div class="section-content">
<?php echo errorSlide(); ?>
                <div class="slide" data-timeout="2000">
                    <div class="slide-background">
                        <img src="images/datacenter.jpg">
                    </div>
                    <div class="slide-content" style="padding-top: 80px;">
                        <div class="slide-content-container">
                            <div class="slide-title">
                                <h1>Hospedagem de Sites</h1>
                            </div>
                            <div class="slide-text">
                                <p>Escolha o melhor plano para você e desfrute da melhor hospedagem de sites em PHP!</p>
                            </div>
                            <div class="slide-options">
                                <a href="#" class="button-2 button-large">Ver planos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide" data-timeout="2000">
                    <div class="slide-background">
                        <img src="images/datacenter2.jpg">
                    </div>
                    <div class="slide-content" style="padding-top: 80px;">
                        <div class="slide-content-container">
                            <div class="slide-title">
                                <h1>Registro de domínios</h1>
                            </div>
                            <div class="slide-text">
                                <p>O nome do seu domínio diz muito sobre você e ajuda você a se destacar na Web.</p>
                            </div>
                            <div class="slide-options">
                                <a href="#" class="button-2 button-large">Pesquisar domínio</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-pos">
                <div class="change-slide"></div>
                <div class="slide-timer"></div>
            </div>
        </section>
    </main>
<?php
include "static/footer.php";
?>
