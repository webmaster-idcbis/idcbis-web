/**
 * Envía datos JSON vía FormData (fiable en Laragon/Windows).
 * El JSON completo va en el campo "payload"; PHP lo lee desde $_POST.
 */
export function postJsonAsFormData(data) {
  const formData = new FormData();
  formData.append('payload', JSON.stringify(data));

  return formData;
}

export async function postFormDataRequest(url, data) {
  const token = localStorage.getItem('token');
  const headers = { Accept: 'application/json' };

  if (token) {
    headers.Authorization = `Bearer ${token}`;
  }

  const response = await fetch(url, {
    method: 'POST',
    headers,
    body: postJsonAsFormData(data),
  });

  const body = await response.json().catch(() => ({}));

  if (!response.ok) {
    const error = new Error(body.message || 'Error al guardar la noticia');
    error.response = { status: response.status, data: body };
    throw error;
  }

  return body;
}
