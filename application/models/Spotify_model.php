<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spotify_model extends CI_Model {

    private $client_id = '302d6d43dfb94ee6b305be0049e8e33a';
    private $client_secret = '18c0a19582dd40e08491e0a37f502c13';

    // Obtener token de acceso
    function getSpotifyToken() {
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

    // Obtener canciones de la playlist
    public function obtener_canciones_playlist($playlist_id) {
        $token = $this->getSpotifyToken();
        if (!$token) {
            log_message('error', 'Token de Spotify no obtenido');
            return [];
        }

        $url = "https://api.spotify.com/v1/playlists/{$playlist_id}/tracks";
        $headers = ['Authorization: Bearer ' . $token];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ❗Solo en desarrollo

        $response = curl_exec($ch);

        if ($response === false) {
            log_message('error', 'Error en cURL (playlist): ' . curl_error($ch));
            return [];
        }

        curl_close($ch);

        $data = json_decode($response, true);
        $canciones = [];

        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                // Verificamos que existen los elementos que necesitamos
                if (isset($item['track']['name']) && isset($item['track']['artists'][0]['name'])) {
                    $canciones[] = [
                        'nombre' => $item['track']['name'], // Nombre de la canción
                        'artista' => $item['track']['artists'][0]['name'], // Nombre del artista
                        'album' => isset($item['track']['album']['name']) ? $item['track']['album']['name'] : 'Desconocido', // Álbum
                        'duracion' => gmdate("i:s", $item['track']['duration_ms'] / 1000), // Duración convertida a minutos:segundos
                        'enlace_spotify' => isset($item['track']['external_urls']['spotify']) ? $item['track']['external_urls']['spotify'] : '#', // Enlace a Spotify
                        'portada' => isset($item['track']['album']['images'][0]['url']) ? $item['track']['album']['images'][0]['url'] : 'https://via.placeholder.com/50' // Portada de la canción
                    ];
                }
            }
        }
        

        return $canciones;
    }
}
