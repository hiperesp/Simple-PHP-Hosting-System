<?php
header("HTTP/1.1 503 Service Unavailable");
$iframePage = true;
function errorSlide(){
    $domainToFill = (isset($_SERVER['HTTP_REFERER']))?"\"".parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)."\"":"este domínio";
?>
<div class="slide" data-timeout="0">
    <div class="slide-background">
        <img src="images/datacenter4.jpg">
    </div>
    <div class="slide-content" style="padding-top: 80px;">
        <div class="slide-content-container">
            <div class="slide-title">
                <h1>Parece que este domínio não está conectado a um website ainda!</h1>
            </div>
            <div class="slide-text">
                <h3>Caso seja o responsável pelo website, siga os procedimentos abaixo.</h3>
                <ol>
                    <li>Acesse <a href="http://simplephphosting.development">noisy.cloud</a> e entre com sua conta.</li>
                    <li>Vá para Hospedagem, selecione sua conta de hospedagem e clique em domínios</li>
                    <li>Clique para adicionar um domínio, preencha o domínio com <?php echo $domainToFill; ?> e salve as configurações.</li>
                </ol>
                <br>
                <p>OBS: Caso já tenha feito isso, aguarde até 5 minutos para que o domínio comece a funcionar. Caso isso não ocorra, entre em contato com o suporte.</p>
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
