<?php
include __DIR__."/SimplePhpHostingShell.php";

class SimplePhpHostingUsers
{
    private static $web_directory = "/srv/http/";
    private static $user_path = "/srv/http/user/";
    private static $conf_path = "/srv/http/user_conf/";

    private static $untouchable_users_and_projects = [
        "default" => [
            "default",
        ],
        "owner" => [
            "simplephphosting",
        ],
    ];
    public static function createUser($name)
    {
        $name_validation = self::validateFolder($name);
        if ($name_validation !== true) {
            return "O nome " . $name_validation . ".";
        }
        if (self::issetUser($name)) {
            return "Já existe um usuário cadastrado com esse nome.";
        }
        if (!@mkdir(self::$user_path . $name)) {
            return "Ocorreu um erro ao criar a pasta do usuário. " . error_get_last()['message'];
        }
        if (!@mkdir(self::$conf_path . $name)) {
            return "Ocorreu um erro ao criar a pasta de configurações do usuário. " . error_get_last()['message'];
        }
        return true;
    }

    public static function issetUser($name)
    {
        if (self::validateFolder($name) !== true) {
            return false;
        }
        if (is_dir(self::$user_path . $name) && is_dir(self::$conf_path . $name)) {
            return true;
        } else if (is_dir(self::$user_path . $name) && !is_dir(self::$conf_path . $name)) {
            rmdir(self::$user_path . $name);
        } else if (!is_dir(self::$user_path . $name) && is_dir(self::$conf_path . $name)) {
            rmdir(self::$conf_path . $name);
        }
        return false;
    }
    public static function issetProject($user, $project)
    {
        if (self::validateFolder($user) !== true) {
            return false;
        }
        if (self::validateFolder($project) !== true) {
            return false;
        }
        if (is_dir(self::$user_path . $user . "/" . $project) && is_dir(self::$conf_path . $user . "/" . $project)) {
            return true;
        } else if (is_dir(self::$user_path . $user . "/" . $project) && !is_dir(self::$conf_path . $user . "/" . $project)) {
            rmdir(self::$user_path . $user . "/" . $project);
        } else if (!is_dir(self::$user_path . $user . "/" . $project) && is_dir(self::$conf_path . $user . "/" . $project)) {
            rmdir(self::$conf_path . $user . "/" . $project);
        }
        return false;
    }
    public static function createProject($user, $project)
    {
        if (!self::issetUser($user)) {
            return "Usuário não encontrado.";
        }
        $project_validation = self::validateFolder($project);
        if ($project_validation !== true) {
            return "O nome do projeto " . $project_validation . ".";
        }
        if (self::issetProject($user, $project)) {
            return "Já existe um projeto com este nome.";
        }
        if (!@SimplePhpHostingShell::copyFolder(self::$user_path . "default/default", self::$user_path . $user . "/" . $project)) {
            return "Ocorreu um erro ao criar o conteúdo do projeto: " . error_get_last()["message"];
        }
        if (!@mkdir(self::$conf_path . $user . "/" . $project)) {
            return "Ocorreu um erro ao criar a pasta de configurações do projeto do usuário. " . error_get_last()['message'];
        }
        return true;
    }

    public static function updateVirtualHosts($user, $project, $email, $domain)
    {
        if (!self::canModifyProject($user, $project)) {
            return "O projeto não pode ser modificado.";
        }
        if (!self::validateFolder($user)) {
            return "Usuário não encontrado";
        }
        if (!self::validateFolder($project)) {
            return "Projeto não encontrado";
        }
        $validate_email_value = self::validateEmail($email);
        if ($validate_email_value !== true) {
            return $validate_email_value;
        }
        $vhosts_data =  "<VirtualHost *>";
        $vhosts_data .= "\n    ServerName " . $domain;
        $vhosts_data .= "\n    DocumentRoot \"" . self::$user_path . $user . "/" . $project . "/public_html\"";
        $vhosts_data .= "\n    ServerAdmin \"" . $email . "\"";
        $vhosts_data .= "\n    AccessFileName .htaccess";
        $vhosts_data .= "\n    <Directory \"" . self::$user_path . $user . "/" . $project . "/public_html\">";
        $vhosts_data .= "\n        Include \"" . self::$web_directory . "conf/default.htaccess\"";
        $vhosts_data .= "\n    </Directory>";
        $vhosts_data .= "\n    php_admin_value open_basedir \"" . self::$user_path . $user . "/" . $project . "\"";
        $vhosts_data .= "\n    php_value upload_tmp_dir \"" . self::$user_path . $user . "/" . $project . "/tmp\"";
        $vhosts_data .= "\n    php_value sys_tmp_dir \"" . self::$user_path . $user . "/" . $project . "/tmp\"";
        $vhosts_data .= "\n    php_value session.save_path \"" . self::$user_path . $user . "/" . $project . "/tmp\"";
        $vhosts_data .= "\n</VirtualHost>";
        if (@file_put_contents(self::$conf_path . $user . "/" . $project . "/vhosts.conf", $vhosts_data) === false) {
            return "Ocorreu um erro ao configurar o DNS no servidor.: " . error_get_last()["message"];
        }
        return true;
    }

    public static function removeUser($user)
    {
        if (!self::canModifyUser($user)) {
            return "O usuário não pode ser modificado.";
        }
        SimplePhpHostingShell::deleteFolder(self::$user_path . $user);
        SimplePhpHostingShell::deleteFolder(self::$conf_path . $user);
        return true;
    }
    public static function removeProject($user, $project)
    {
        if (!self::canModifyProject($user, $project)) {
            return "O projeto não pode ser modificado.";
        }
        SimplePhpHostingShell::deleteFolder(self::$user_path . $user . "/" . $project);
        SimplePhpHostingShell::deleteFolder(self::$conf_path . $user . "/" . $project);
        return true;
    }

    public static function getAllUsers()
    {
        return SimplePhpHostingShell::getAllSubFolders(self::$user_path);
    }
    public static function getUserProjects($user)
    {
        if (!self::validateFolder($user)) {
            return "Usuário não encontrado";
        }
        return SimplePhpHostingShell::getAllSubFolders(self::$user_path . $user);
    }
    public static function getAllProjects()
    {
        $projects = [];
        $users = self::getAllUsers();
        foreach ($users as $user_key => $user_name) {
            $projects[$user_name] = [];
            $user_projects = self::getUserProjects($user_name);
            foreach ($user_projects as $project_key => $project_name) {
                array_push($projects[$user_name], $project_name);
            }
        }
        return $projects;
    }

    private static function canModifyUser($user)
    {
        foreach (self::$untouchable_users_and_projects as $user_name => $user_projects) {
            if ($user_name == $user) {
                return false;
            }
        }
        return true;
    }

    private static function canModifyProject($user, $project)
    {
        foreach (self::$untouchable_users_and_projects as $user_name => $user_projects) {
            if ($user_name == $user) {
                foreach ($user_projects as $project_key => $project_name){
                    if($project_name==$project){
                        return false;
                    }
                }
                return true;
            }
        }
        return true;
    }
    private static function validateFolder($str)
    {
        if (preg_match("/^([a-z]+)$/", $str) == 0) {
            return "deve conter somente letras minúsculas sem acentos";
        }
        return true;
    }
    private static function validateEmail($email)
    {
        if (strlen($email) > 254 || strlen($email) < 3 || (preg_match("/^[a-zA-Z0-9_.-]{1,64}@[a-zA-Z0-9-.]{1,255}$/", $email) == 0) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return "O endereço de email não é válido ou é muito complexo. Caso isso seja um erro, entre em contato com o suporte.";
        }
        return true;
    }
}
