USE bd_patitas;
DELIMITER $$

CREATE PROCEDURE login_usuario (
    IN p_usuario VARCHAR(100)
)
BEGIN
    DECLARE v_contrasena VARCHAR(255);
    DECLARE v_usuario VARCHAR(100);
    DECLARE v_id INT;

    -- Buscar el ID, nombre y contraseña del usuario por su nombre de usuario
    SELECT Id_Usuario, Usuario, Contrasena
    INTO v_id, v_usuario, v_contrasena
    FROM usuarios
    WHERE Usuario = p_usuario;

    -- Devolver los datos necesarios para verificar en PHP
    SELECT 
        v_id AS Id_Usuario,
        v_usuario AS Usuario,
        v_contrasena AS Contrasena;
END$$

DELIMITER ;
