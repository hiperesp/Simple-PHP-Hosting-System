<?php
header("HTTP/1.1 403 Forbidden");
$iframePage = true;
function errorSlide(){
    global $requestPage;
?>
<div class="slide" data-timeout="0">
    <div class="slide-background">
        <img src="images/datacenter4.jpg">
    </div>
    <div class="slide-content" style="padding-top: 80px;">
        <div class="slide-content-container">
            <div class="slide-title">
                <h1>403. <span style="font-weight: normal">Isso é um erro.</span></h1>
            </div>
            <div class="slide-text">
                <p><span style="font-weight: bold;">Você não possui permissão para acessar a página solicitada<?php echo @$requestPage; ?>.</span><br>Isso é tudo que sabemos.</p>
            </div>
            <div class="slide-options">
                <a href="javascript:void(0)" onclick="history.back()" class="button-2 button-large">Voltar</a>
                <a href="http://simplephphosting.development/" class="button-1 button-large">NoisyCloud</a>
            </div>
        </div>
    </div>
</div>
<?php
}
