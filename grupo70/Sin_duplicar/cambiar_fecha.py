
import pandas as pd
import os

# Ruta del archivo CSV
file_path = r'C:\Users\56987\OneDrive - uc.cl\2023-1\bases de datos\grupo70\Sin_duplicar\despachos_sin_duplicados.csv'  # Reemplaza con la ruta correcta de tu archivo CSV

# Leer el archivo CSV
df = pd.read_csv(file_path)
df['fecha_entrega'] = df['fecha_entrega'].str.replace('20202', '2020')

# Convertir columnas de fecha al formato deseado (YYYY-MM-DD)
df['fecha_entrega'] = pd.to_datetime(df['fecha_entrega']).dt.strftime('%Y-%m-%d')

# Guardar los datos con el nuevo formato en un nuevo archivo CSV
nuevo_nombre_archivo = 'despachos_final.csv'
nuevo_archivo_path = os.path.join(os.getcwd(), nuevo_nombre_archivo)
df.to_csv(nuevo_archivo_path, index=False)

print('Archivo procesado y guardado exitosamente.')


