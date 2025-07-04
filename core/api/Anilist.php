<?php

namespace Core\Api;

class Anilist
{
    protected static function sendRequest($query, $variables = [])
    {
        $url = 'https://graphql.anilist.co';

        $postData = json_encode([
            'query' => $query,
            'variables' => $variables
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['errors'])) {
            return null;
        }

        return $result['data'];
    }

    public static function search($title)
    {
        $query = '
        query ($search: String) {
            Page(perPage: 10) {
                media(search: $search, type: ANIME) {
                    id
                    title {
                        romaji
                        english
                    }
                    coverImage {
                        large
                    }
                    description(asHtml: false)
                    episodes
                    genres
                    status
                }
            }
        }
    ';

        $variables = ['search' => $title];
        $data = self::sendRequest($query, $variables);

        return $data['Page']['media'] ?? [];
    }


    public static function fetchAnimeByIds(array $ids): array
    {
        if (empty($ids)) return [];

        $idsString = implode(', ', $ids);

        $query = '
            query {
                Page(perPage: 50) {
                    media(id_in: [' . $idsString . '], type: ANIME) {
                        id
                        title {
                            romaji
                        }
                        description(asHtml: false)
                        coverImage {
                            large
                        }
                    }
                }
            }
        ';

        $data = self::sendRequest($query);

        return $data['Page']['media'] ?? [];
    }
}
