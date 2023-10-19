CREATE OR REPLACE FUNCTION verificar_usuario(pname varchar(100), pcontraseña varchar(100))
  RETURNS TEXT AS $$
DECLARE
    user_name TEXT;
BEGIN
    SELECT username INTO user_name
    FROM usuarios
    WHERE username = pname AND password = pcontraseña;

    IF user_name IS NOT NULL THEN
        RAISE NOTICE 'El usuario ingresado es: %', user_name;
        INSERT INTO visitas (nombre) VALUES (user_name);
        RETURN user_name;
    ELSE
        RETURN 'FALSE';
        INSERT INTO visitas (nombre) VALUES (user_name);
    END IF;
END;
$$ LANGUAGE plpgsql;

