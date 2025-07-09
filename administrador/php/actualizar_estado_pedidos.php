<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido_id = $_POST['pedido_id'] ?? null;
    $nuevo_estado = $_POST['estado'] ?? null;

    $estados_validos = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];

    if ($pedido_id && in_array($nuevo_estado, $estados_validos)) {
        $stmt = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        if ($stmt->execute([$nuevo_estado, $pedido_id])) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar el estado']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Datos inválidos']);
    }
}
