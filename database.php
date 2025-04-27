<?php
// Configurando onde a integração do DB será feita definindo o seguinte;
$host = 'localhost';
$db = 'curso_ferias';
$user = 'root';
$password = '';
$charset = 'utf8mb4';
$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

// Informando as opções de como será o formato dos dados recebidos e como serão tratados;
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
]; 