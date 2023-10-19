import os
import pandas as pd
import glob

# Obtener la lista de archivos CSV en la carpeta "Datos Oficiales"
archivos_csv = glob.glob('Entrega 2\Datos Oficiales\*.csv')

# Iterar sobre cada archivo CSV y eliminar duplicados
for archivo in archivos_csv:
    nombre_archivo = archivo.split('/')[-1]  # Obtener solo el nombre del archivo sin la ruta
    df = pd.read_csv(archivo)
    df = df.drop_duplicates()

    # Verificar si el directorio de destino existe y crearlo si no
    directorio_destino = 'Entrega 2\Datos Oficiales'
    if not os.path.exists(directorio_destino):
        os.makedirs(directorio_destino)

    # Guardar el archivo CSV sin duplicados
    df.to_csv(f'{directorio_destino}/{nombre_archivo[:-4]}_sin_duplicados.csv', index=False)
