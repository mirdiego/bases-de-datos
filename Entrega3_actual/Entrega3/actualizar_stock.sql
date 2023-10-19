CREATE OR REPLACE PROCEDURE actualizar_stock(IN producto_id INT, IN nuevo_stock INT, IN tienda_id INT, OUT mensaje VARCHAR) AS $$
BEGIN
  UPDATE stock SET cantidad = nuevo_stock WHERE id_producto = producto_id AND id_tienda = tienda_id;
  mensaje := 'El stock del producto ha sido actualizado exitosamente.';
END;
$$ LANGUAGE plpgsql;
