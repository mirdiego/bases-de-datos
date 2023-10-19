CREATE OR REPLACE PROCEDURE actualizar_oferta(IN producto_id INT, IN nuevo_descuento INT, OUT mensaje VARCHAR) AS $$
BEGIN
  UPDATE stock SET descuento = nuevo_descuento WHERE id_producto = producto_id;
  mensaje := 'La oferta del producto ha sido actualizada exitosamente.';
END;
$$ LANGUAGE plpgsql;
