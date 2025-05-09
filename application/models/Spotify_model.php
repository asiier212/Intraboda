<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spotify_model extends CI_Model
{

    private $client_id = '302d6d43dfb94ee6b305be0049e8e33a';
    private $client_secret = '18c0a19582dd40e08491e0a37f502c13';

    // Obtener token de acceso
    function getSpotifyToken()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode("{$this->client_id}:{$this->client_secret}"),
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ❗Solo en desarrollo

        $response = curl_exec($ch);

        if ($response === false) {
            log_message('error', 'Error en cURL (token): ' . curl_error($ch));
            return null;
        }

        curl_close($ch);
        $data = json_decode($response, true);

        return isset($data['access_token']) ? $data['access_token'] : null;
    }

    public function obtener_canciones_playlist($playlist_id)
    {
        // Obtener token de acceso
        $token = $this->getSpotifyToken();
        if (!$token) {
            log_message('error', 'Token de Spotify no obtenido');
            return [];
        }

        // URL de la playlist de Spotify
        $url_playlist = "https://api.spotify.com/v1/playlists/{$playlist_id}";
        $headers = ['Authorization: Bearer ' . $token];

        // Inicializar cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_playlist);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Ejecutar cURL y obtener respuesta
        $response_playlist = curl_exec($ch);
        if ($response_playlist === false) {
            log_message('error', 'Error en cURL (playlist info): ' . curl_error($ch));
            return [];
        }

        // Decodificar la respuesta JSON
        $data_playlist = json_decode($response_playlist, true);

        // Verificar si la respuesta es válida
        if (empty($data_playlist)) {
            log_message('error', 'Respuesta vacía de Spotify para playlist_id: ' . $playlist_id);
            return [];
        }

        // Verificar si los datos de la playlist están disponibles
        $playlist_title = isset($data_playlist['name']) ? $data_playlist['name'] : 'Sin título';
        $playlist_cover = isset($data_playlist['images'][0]['url']) ? $data_playlist['images'][0]['url'] : '';

        // Comprobación adicional si los datos están vacíos o no se encuentran correctamente
        if (!$playlist_title || !$playlist_cover) {
            log_message('error', 'No se pudo obtener el título o la portada de la playlist: ' . $playlist_id);
        }

        // Obtener canciones de la playlist
        $tracks = isset($data_playlist['tracks']['items']) ? $data_playlist['tracks']['items'] : [];
        $canciones = [];

        // Procesar las canciones
        foreach ($tracks as $item) {
            if (isset($item['track']['name']) && isset($item['track']['artists'][0]['name'])) {
                $canciones[] = [
                    'nombre' => $item['track']['name'],
                    'artista' => $item['track']['artists'][0]['name'],
                    'album' => isset($item['track']['album']['name']) ? $item['track']['album']['name'] : 'Desconocido',
                    'duracion' => gmdate("i:s", $item['track']['duration_ms'] / 1000),
                    'enlace_spotify' => isset($item['track']['external_urls']['spotify']) ? $item['track']['external_urls']['spotify'] : '#',
                    'portada' => isset($item['track']['album']['images'][0]['url']) ? $item['track']['album']['images'][0]['url'] : ''
                ];
            }
        }

        // Retornar la información de la playlist y las canciones
        return [
            'playlist_title' => $playlist_title,
            'playlist_cover' => $playlist_cover,
            'canciones' => $canciones
        ];
    }



    function sumar_playList($titulo, $enlace, $portada, $cliente_id)
    {
        $this->load->database();
        $this->db->query("INSERT INTO playlistspotify (titulo, enlace, portada, cliente_id) VALUES (?, ?, ?, ?)", array($titulo, $enlace, $portada, $cliente_id));
        return $this->db->insert_id();
    }

    function getPlayLists($cliente_id)
    {
        $this->load->database();
        $query = $this->db->query("SELECT * FROM playlistspotify WHERE cliente_id = {$cliente_id}");

        return $query->result(); // Devuelve directamente los objetos con todas las columnas
    }
}
