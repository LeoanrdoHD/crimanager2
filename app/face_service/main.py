from fastapi import FastAPI, File, UploadFile
from fastapi.responses import JSONResponse
import tempfile
import os
import logging
import asyncio
from concurrent.futures import ThreadPoolExecutor
import time

# Configurar logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = FastAPI()

# Executor para procesamiento paralelo
executor = ThreadPoolExecutor(max_workers=4)

def quick_image_similarity(image1_path, image2_path):
    """
    Comparación rápida de imágenes basada en características básicas
    """
    try:
        from PIL import Image
        import hashlib
        
        # Método 1: Comparación por hash perceptual (muy rápido)
        def get_image_hash(img_path):
            with Image.open(img_path) as img:
                # Redimensionar a 8x8 para hash rápido
                img = img.convert('L').resize((8, 8), Image.Resampling.LANCZOS)
                pixels = list(img.getdata())
                # Calcular promedio
                avg = sum(pixels) / len(pixels)
                # Crear hash binario
                hash_bits = ''.join('1' if pixel > avg else '0' for pixel in pixels)
                return hash_bits
        
        hash1 = get_image_hash(image1_path)
        hash2 = get_image_hash(image2_path)
        
        # Calcular diferencia de Hamming
        differences = sum(c1 != c2 for c1, c2 in zip(hash1, hash2))
        similarity = 1 - (differences / len(hash1))
        
        # Umbral de similitud (ajustable)
        is_match = similarity > 0.85
        
        logger.info(f"Similitud rápida: {similarity:.3f}, Match: {is_match}")
        return {
            "match": is_match,
            "confidence": similarity,
            "method": "perceptual_hash"
        }
        
    except Exception as e:
        logger.error(f"Error en comparación rápida: {e}")
        return {
            "match": False,
            "confidence": 0.0,
            "method": "error",
            "error": str(e)
        }

def process_single_photo(uploaded_path, stored_photo_data, index):
    """
    Procesa una sola foto almacenada (para paralelización)
    """
    stored_content, stored_filename = stored_photo_data
    
    try:
        # Crear archivo temporal para esta foto
        with tempfile.NamedTemporaryFile(delete=False, suffix='.jpg') as tmp_stored:
            tmp_stored.write(stored_content)
            tmp_stored_path = tmp_stored.name
        
        # Comparación rápida
        result = quick_image_similarity(uploaded_path, tmp_stored_path)
        
        # Limpiar archivo temporal
        if os.path.exists(tmp_stored_path):
            os.unlink(tmp_stored_path)
        
        if result["match"]:
            logger.info(f"🎯 Coincidencia encontrada en foto {index}: {stored_filename}")
            return {
                "match": True,
                "filename": stored_filename,
                "confidence": result["confidence"],
                "method": result["method"],
                "index": index
            }
        
        return {"match": False, "index": index}
        
    except Exception as e:
        logger.error(f"Error procesando foto {index} ({stored_filename}): {e}")
        return {"match": False, "index": index, "error": str(e)}

@app.get("/")
async def root():
    return {"message": "Face Recognition API (Optimizada)", "status": "OK"}

@app.post("/compare-faces/")
async def compare_faces(
    uploaded_photo: UploadFile = File(...),
    stored_photos: list[UploadFile] = File(...)
):
    start_time = time.time()
    logger.info(f"=== INICIO COMPARACIÓN RÁPIDA - Foto: {uploaded_photo.filename} ===")
    logger.info(f"Fotos almacenadas: {len(stored_photos)}")
    
    tmp_uploaded_path = None
    
    try:
        # Validaciones básicas
        if not uploaded_photo.content_type.startswith('image/'):
            return JSONResponse({
                "match": False, 
                "error": f"Archivo no es imagen: {uploaded_photo.content_type}"
            })
        
        # Crear archivo temporal para imagen subida
        with tempfile.NamedTemporaryFile(delete=False, suffix='.jpg') as tmp_uploaded:
            content = await uploaded_photo.read()
            logger.info(f"Tamaño imagen subida: {len(content)} bytes")
            
            if len(content) < 1000:
                return JSONResponse({
                    "match": False, 
                    "error": "Archivo de imagen demasiado pequeño"
                })
            
            tmp_uploaded.write(content)
            tmp_uploaded_path = tmp_uploaded.name
        
        # Preparar datos de fotos almacenadas
        logger.info("Preparando fotos almacenadas...")
        stored_photos_data = []
        
        for i, stored_photo in enumerate(stored_photos):
            if stored_photo.content_type.startswith('image/'):
                try:
                    stored_content = await stored_photo.read()
                    if len(stored_content) >= 1000:  # Solo fotos válidas
                        stored_photos_data.append((stored_content, stored_photo.filename))
                except Exception as e:
                    logger.warning(f"Error leyendo foto {i}: {e}")
                    continue
        
        logger.info(f"Fotos válidas para procesar: {len(stored_photos_data)}")
        
        if not stored_photos_data:
            return JSONResponse({
                "match": False,
                "error": "No hay fotos válidas para comparar"
            })
        
        # Estrategia de procesamiento según cantidad de fotos
        if len(stored_photos_data) <= 20:
            # Pocas fotos: procesar secuencialmente (más rápido para pocos archivos)
            logger.info("Procesamiento secuencial...")
            
            for i, (stored_content, stored_filename) in enumerate(stored_photos_data):
                result = process_single_photo(tmp_uploaded_path, (stored_content, stored_filename), i)
                
                if result.get("match"):
                    elapsed = time.time() - start_time
                    logger.info(f"✅ Coincidencia encontrada en {elapsed:.2f}s")
                    return JSONResponse({
                        "match": True,
                        "filename": result["filename"],
                        "confidence": result["confidence"],
                        "method": result["method"],
                        "processing_time": elapsed,
                        "photos_processed": i + 1,
                        "total_photos": len(stored_photos_data)
                    })
        
        else:
            # Muchas fotos: procesar en paralelo
            logger.info("Procesamiento paralelo...")
            
            # Dividir en lotes para evitar sobrecarga
            batch_size = 10
            for batch_start in range(0, len(stored_photos_data), batch_size):
                batch_end = min(batch_start + batch_size, len(stored_photos_data))
                batch = stored_photos_data[batch_start:batch_end]
                
                logger.info(f"Procesando lote {batch_start//batch_size + 1}: fotos {batch_start+1}-{batch_end}")
                
                # Procesar lote en paralelo
                loop = asyncio.get_event_loop()
                tasks = [
                    loop.run_in_executor(
                        executor, 
                        process_single_photo, 
                        tmp_uploaded_path, 
                        photo_data, 
                        batch_start + i
                    )
                    for i, photo_data in enumerate(batch)
                ]
                
                # Esperar resultados del lote
                batch_results = await asyncio.gather(*tasks)
                
                # Verificar si hay coincidencias en este lote
                for result in batch_results:
                    if result.get("match"):
                        elapsed = time.time() - start_time
                        logger.info(f"✅ Coincidencia encontrada en {elapsed:.2f}s")
                        return JSONResponse({
                            "match": True,
                            "filename": result["filename"],
                            "confidence": result["confidence"],
                            "method": result["method"],
                            "processing_time": elapsed,
                            "photos_processed": result["index"] + 1,
                            "total_photos": len(stored_photos_data)
                        })
                
                # Pequeña pausa entre lotes para no saturar
                await asyncio.sleep(0.1)
        
        # No se encontraron coincidencias
        elapsed = time.time() - start_time
        logger.info(f"❌ Sin coincidencias. Tiempo total: {elapsed:.2f}s")
        
        return JSONResponse({
            "match": False,
            "message": f"Sin coincidencias encontradas.",
            "processing_time": elapsed,
            "photos_processed": len(stored_photos_data),
            "total_photos": len(stored_photos_data),
            "method": "perceptual_hash"
        })
        
    except Exception as e:
        elapsed = time.time() - start_time
        logger.error(f"Error general tras {elapsed:.2f}s: {str(e)}")
        return JSONResponse({
            "match": False, 
            "error": f"Error interno: {str(e)}",
            "processing_time": elapsed
        }, status_code=500)
        
    finally:
        # Limpiar archivo temporal
        if tmp_uploaded_path and os.path.exists(tmp_uploaded_path):
            try:
                os.unlink(tmp_uploaded_path)
            except:
                pass
        
        elapsed = time.time() - start_time
        logger.info(f"=== FIN COMPARACIÓN - Tiempo total: {elapsed:.2f}s ===\n")