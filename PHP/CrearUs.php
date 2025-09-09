USE bd_patitas;

DELIMITER $$

CREATE PROCEDURE crear_usuario (
    IN p_usuario VARCHAR(100),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    IF NOT EXISTS (SELECT 1 FROM usuarios WHERE Usuario = p_usuario) THEN
        INSERT INTO usuarios (Usuario, Contrasena)
        VALUES (p_usuario, p_contrasena);
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El usuario ya está registrado.';
    END IF;
END$$

DELIMITER ;
