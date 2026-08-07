const MAX_BYTES = 2 * 1024 * 1024;

export async function fileToDataUrl(file, { maxWidth = 1200, quality = 0.78 } = {}) {
  if (!file?.type?.startsWith('image/')) {
    throw new Error('El archivo seleccionado no es una imagen.');
  }

  if (file.size > MAX_BYTES) {
    throw new Error('La imagen no puede superar 2 MB.');
  }

  const objectUrl = URL.createObjectURL(file);

  try {
    const image = await loadImage(objectUrl);
    const { width, height } = fitDimensions(image.width, image.height, maxWidth);
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;

    const context = canvas.getContext('2d');
    if (!context) {
      throw new Error('No se pudo preparar la imagen.');
    }

    context.drawImage(image, 0, 0, width, height);

    const mime = file.type === 'image/png' ? 'image/png' : 'image/jpeg';
    const dataUrl = canvas.toDataURL(mime, quality);

    if (estimateDataUrlBytes(dataUrl) > MAX_BYTES) {
      throw new Error('La imagen sigue siendo demasiado grande. Prueba con otra más pequeña.');
    }

    return dataUrl;
  } finally {
    URL.revokeObjectURL(objectUrl);
  }
}

function loadImage(src) {
  return new Promise((resolve, reject) => {
    const image = new Image();
    image.onload = () => resolve(image);
    image.onerror = () => reject(new Error('No se pudo leer la imagen.'));
    image.src = src;
  });
}

function fitDimensions(width, height, maxWidth) {
  if (width <= maxWidth) {
    return { width, height };
  }

  const ratio = maxWidth / width;

  return {
    width: maxWidth,
    height: Math.round(height * ratio),
  };
}

function estimateDataUrlBytes(dataUrl) {
  const base64 = dataUrl.split(',')[1] || '';
  return Math.ceil((base64.length * 3) / 4);
}
