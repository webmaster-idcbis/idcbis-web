/**
 * Envía el guardado de página vía FormData (fiable en Laragon/Windows).
 * El JSON completo va en el campo "payload"; PHP lo lee desde $_POST.
 */
export function postPageSave(url, apiData, token) {
  const formData = new FormData()
  formData.append('payload', JSON.stringify(apiData))

  return fetch(url, {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      Authorization: `Bearer ${token}`,
    },
    body: formData,
  })
}
