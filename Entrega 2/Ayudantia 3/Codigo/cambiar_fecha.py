import pandas as pd

# Leer el archivo CSV
df = pd.read_csv('"C:\Users\56987\OneDrive - uc.cl\2023-1\bases de datos\grupo70\Sin_duplicar\compras_sin_duplicados.csv"')

# Convertir la columna 'fecha' al formato de fecha de SQL
df['fecha'] = pd.to_datetime(df['fecha']).dt.strftime('%Y-%m-%d')

# Guardar el DataFrame actualizado en un nuevo archivo CSV
df.to_csv('C:\Users\56987\OneDrive - uc.cl\2023-1\bases de datos\grupo70\fechas cambiadas', index=False)
