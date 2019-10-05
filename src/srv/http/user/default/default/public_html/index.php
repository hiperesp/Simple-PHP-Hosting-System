<?php
$dir = ".";
$files = scandir($dir);
$parsed_files = [];
foreach($files as $key=>$value){
    $parsed_files[$key] = [
        "type" => is_dir($value)?"dir":"file",
        "name" => $value,
        "date" => @date("d/m/Y H:i:s", filemtime($value)),
    ];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1">
    <title></title>
    <style>
* {
    margin: 0px;
    padding: 0px;
}
a {
    text-decoration: none;
}
body {
    background-image: linear-gradient(to bottom, #200e35, #4d1d85);
    font-family: 'Raleway', sans-serif;
    color: #ffffffff;
    min-height: 100vh;
}
header, main, footer {
    text-align: center;
    padding: 40px;
}
.logo {
    color: #ffffffff;
}
.logo span {
    color: #1befc5ff;
}
main .container {
    max-width: 700px;
    margin: 0 auto;
    background-color: #ffffff20;
    border-radius: 5px;
    padding: 20px 5px;
}
main a {
    color: #ffffffff;
}
main table {
    background-color: #00000020;
    text-align: center;
    width: calc(100% - 40px);
}
table th:nth-child(1) {
    width: 100px;
    text-align: center;
}
table th:nth-child(2), table td:nth-child(2) {
    text-align: left;
}
table td:nth-child(2) {
    text-decoration: underline;
}
table th:nth-child(3) {
    width: 180px;
    text-align: center;
}
table {
    margin: 20px;
    border-radius: 5px;
}
    </style>
</head>

<body>
    <header>
        <a href="http://simplephphosting.development" class="logo"><h1>Simple<span>PHP</span>Hosting</h1></a>
    </header>
    <main>
        <div class="container">
            <h1><?php echo $_SERVER["HTTP_HOST"]; ?></h1>
            <h3>Se você vê essa página, seu site está configurado. Você pode alterar o conteúdo dele através do painel de controle.</h3>
            <table class="files">
                <thead>
                    <tr>
                        <th></th>
                        <th style="text-align: center;">Pasta: public_html</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Data de modificação</th>
                    </tr>
                </thead>
                <tbody>
<?php
foreach($parsed_files as $key=>$value){
    echo "  <tr>\n";
    echo "      <td>".($value["type"]=="dir"?"Pasta":($value["type"]=="file"?"Arquivo":"Indefinido"))."</td>\n";
    echo "      <td><a href=\"".urlencode(utf8_encode($value["name"]))."\">".$value["name"]."</a></td>\n";
    echo "      <td>".$value["date"]."</td>\n";
    echo "  </tr>\n";
}
?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
    
    </footer>
    <script></script>
</body>

</html>
