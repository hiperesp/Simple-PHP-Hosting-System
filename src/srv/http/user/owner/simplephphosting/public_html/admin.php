<?php
include __DIR__."/../classes/SimplePhpHostingUsers.php";

$action = @$_POST['action'];
$user_name = @$_POST['user_name'];
$user_email = @$_POST['user_email'];
$project_name = @$_POST['project_name'];
$project_domain = @$_POST['project_domain'];
$user_project_name = @$_POST['user_project_name'];
$response = "";
$error = true;

switch($action) {
	case "createUser":
		$response = SimplePhpHostingUsers::createUser($user_name);
		if($response===true){
			$response = "Sucesso ao criar usuário";
			$error = false;
		}
		break;
	case "removeUser":
		$response = SimplePhpHostingUsers::removeUser($user_name);
		if($response===true){
			$response = "Sucesso ao remover usuário";
			$error = false;
		}
		break;
	case "createProject":
		$response = SimplePhpHostingUsers::createProject($user_name, $project_name);
		if($response===true){
			SimplePhpHostingUsers::updateVirtualHosts($user_name, $project_name, $user_email, $project_domain);
			$response = "Sucesso ao criar o projeto";
			$error = false;
		}
		break;
	case "removeProject":
		list($user_name, $project_name) = explode(":", $user_project_name, 2);
		$response = SimplePhpHostingUsers::removeProject($user_name, $project_name);
		if($response===true){
			$response = "Sucesso ao remover projeto";
			$error = false;
		}
		break;
	case "updateProjectInfo":
		list($user_name, $project_name) = explode(":", $user_project_name, 2);
		$response = SimplePhpHostingUsers::updateVirtualHosts($user_name, $project_name, $user_email, $project_domain);
		if($response===true){
			$response = "Sucesso ao atualizar as informações do projeto";
			$error = false;
		}
		break;
}

$allUsers = SimplePhpHostingUsers::getAllUsers();
$allUsersWithProjects = [];
foreach($allUsers as $userName){
	$userProjects = SimplePhpHostingUsers::getUserProjects($userName);
	foreach($userProjects as $projectName) {
		array_push($allUsersWithProjects, [
			"user" => $userName,
			"project" => $projectName,
 		]);
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		<title>Simple PHP Hosting - Painel Administrativo ALPHA 1</title>
		<style>
header {
	line-height: 50vh;
	text-align: center;
}
header .container {
	text-align: initial;
	margin: 0 auto;
	max-width: 720px;
	padding: 20px;
	display: inline-block;
	line-height: normal;
	vertical-align: middle;
}
header .version {
	text-align: right;
	color: #aaaaaa;
}
main {
	max-width: 720px;
	padding: 20px;
	margin: 0 auto;
}
hr {
	height: 1px;
	border-style: none;
	background-color: #0080ff40;
}
label {
	display: block;
	width: 100%;
	color: #404040;
}
input {
	width: calc(100% - 20px);
	padding: 0 10px;
	height: 30px;
	border-width: 2px;
}
select {
	width: calc(100% + 4px);
	padding: 0 10px;
	height: 34px;
}
input[type=submit] {
	display: block;
	font-weight: bold;
	background-color: #0080ff;
	height: 40px;
	color: #ffffff;
	border-style: none;
	border-radius: 8px;
	width: fit-content;
	padding: 0 20px;
	margin: 0 auto;
}
input[type=submit]:hover {
	background-color: #0060c0;
}
input[type=submit]:active {
	background-color: #00a0ff;
}
.alert-container {
	position: fixed;
	left: 0;
	bottom: 0;
	padding: 10px 0 0 10px;
}
.alert {
	background-color: #ff0000;
	box-shadow: 0 0 2em #ff0000;
	cursor: pointer;
	border-radius: 8px;
	color: #ffffff;
	padding: 20px;
	width: fit-content;
	margin: 10px;
}
.alert.success {
	background-color: #00ff00;
	box-shadow: 0 0 2em #00ff00;
}
.alert h1, .alert h2, .alert h3, .alert p {
	margin: 0 5px;
}
.alert hr {
	background-color: #ffffff40;
}
.alert.removing {
	opacity: 0;
	transition: opacity 500ms;
}
		</style>
	</head>
	<body>
		<header>
			<div class="container">
				<h1>Simple PHP Hosting - Painel Administrativo</h1>
				<h3 class="version">Alpha 1</h3>
				<!--div class="alert">
					<h3>Atenção:</h3>
					<hr>
					<p>Aja com cuidado. Quaisquer ações realizadas aqui são irreversíveis e não possuem tela de confirmação.</p>
				</div-->
			</div>
		</header>
		<main>
			<hr>
			<form action="#" method="post">
				<h2>Cadastrar Usuário</h2>
				<input type="hidden" name="action" value="createUser">
				<label>
					Nome do usuário:<br>
					<input type="text" name="user_name" value=""><br>
				</label><br>
				<label>
					<input type="submit" value="Cadastrar Usuário"><br>
				</label><br>
				<hr>
			</form>
			<form action="#" method="post">
				<h2>Remover Usuário</h2>
				<input type="hidden" name="action" value="removeUser">
				<label>
					Selecione um usuário:<br>
					<select name="user_name">
<?php foreach($allUsers as $user_name) { ?><option value="<?php echo $user_name; ?>"><?php echo $user_name; ?></option><?php } ?>
					</select><br>
				</label><br>
				<label>
					<input type="submit" value="Remover Usuário"><br>
				</label><br>
				<hr>
			</form>
			<form action="#" method="post">
				<h2>Criar Projeto</h2>
				<input type="hidden" name="action" value="createProject">
				<label>
					Selecione um usuário:<br>
					<select name="user_name">
<?php foreach($allUsers as $user_name) { ?><option value="<?php echo $user_name; ?>"><?php echo $user_name; ?></option><?php } ?>
					</select><br>
				</label><br>
				<label>
					Nome do projeto:<br>
					<input type="text" name="project_name" value=""><br>
				</label><br>
				<label>
					Email do responsável pelo projeto:<br>
					<input type="text" name="user_email" value=""><br>
				</label><br>
				<label>
					Domínio do projeto:<br>
					<input type="text" name="project_domain" value=""><br>
				</label><br>
				<label>
					<input type="submit" value="Criar Projeto"><br>
				</label><br>
				<hr>
			</form>
			<form action="#" method="post">
				<h2>Atualizar Projeto</h2>
				<input type="hidden" name="action" value="updateProjectInfo">
				<label>
					Selecione um projeto:<br>
					<select name="user_project_name">
<?php foreach($allUsersWithProjects as $project) { ?><option value="<?php echo $project["user"].":".$project["project"]; ?>"><?php echo $project["user"].": ".$project["project"]; ?></option><?php } ?>
					</select><br>
				</label><br>
				<label>
					Email do responsável pelo projeto:<br>
					<input type="text" name="user_email" value=""><br>
				</label><br>
				<label>
					Domínio do projeto:<br>
					<input type="text" name="project_domain" value=""><br>
				</label><br>
				<label>
					<input type="submit" value="Atualizar Informações do Projeto"><br>
				</label><br>
				<hr>
			</form>
			<form action="#" method="post">
				<h2>Remover Projeto</h2>
				<input type="hidden" name="action" value="removeProject">
				<label>
					Selecione um projeto:<br>
					<select name="user_project_name">
<?php foreach($allUsersWithProjects as $project) { ?><option value="<?php echo $project["user"].":".$project["project"]; ?>"><?php echo $project["user"].": ".$project["project"]; ?></option><?php } ?>
					</select><br>
				</label><br>
				<label>
					<input type="submit" value="Remover Projeto"><br>
				</label><br>
				<hr>
			</form>
		</main>
		<div class="alert-container"></div>
		<script>
function addAlert(title, content, error = true){
	let alertElement = document.createElement("div");
	alertElement.classList.add("alert");
	if(!error) alertElement.classList.add("success");
	{
		{
			let titleElement = document.createElement("h3");
			titleElement.textContent = title;
			alertElement.appendChild(titleElement);
		}
		{
			let separator = document.createElement("hr");
			alertElement.appendChild(separator);
		}
		{
			let contentElement = document.createElement("p");
			contentElement.textContent = content;
			alertElement.appendChild(contentElement);
		}
	}
	alertElement.addEventListener("click", function(e){
		this.classList.add("removing");
		setTimeout(function(element) {
			element.remove();
		}, 500, this);
	});
	document.querySelector(".alert-container").appendChild(alertElement);
}
<?php if($action===null){ ?>addAlert("Atenção:", "Aja com cuidado. Quaisquer ações realizadas aqui são irreversíveis e não possuem tela de confirmação.");<?php } ?>
<?php if($response!="") { ?>addAlert("Atenção:", "<?php echo $response; ?>", <?php echo $error===true?"true":"false"; ?>);<?php } ?>
		</script>
	</body>
</html>

