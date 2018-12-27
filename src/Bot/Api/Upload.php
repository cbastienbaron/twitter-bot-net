<?php

namespace App\Bot\Api;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use App\Bot\Api\Giphy\Random;

/**
 * Class Upload
 * @package App\Bot\Api
 */
class Upload extends Consumer
{

    /** @var Random  */
    private $random;

    /** @var Client  */
    private $upload;

    /**
     * Consumer constructor.
     * @param LoggerInterface $logger
     * @param Client $client
     */
    public function __construct(LoggerInterface $logger, Client $client, Random $random, Client $upload)
    {
        parent::__construct($logger, $client);

        $this->random = $random;
        $this->upload = $upload;
    }

    /**
     * Send request to endpoint
     *
     * [tag => 'win']
     *
     * @param array $params
     * @return mixed
     */
    public function request(array $params = array())
    {
        $mediaId = false;

        try {
            if (preg_match_all("/#(\\w+)/", $params['contest']->getText(), $matches)) {

                $isGifFound = false;
                $tag  = false;
                $data = new \stdClass();
                foreach ($matches[1] as $tag) {
                    // grab gif
                    $data = $this->random->request(['tag' => $tag]);
                    if (is_object($data->data)) {
                        $isGifFound = true;
                        break;
                    }
                }

                // gif find
                if ($isGifFound) {

                    $this->logger->info(sprintf('%s : Media For Hashtag #%s : %s', $params['contest']->getId(), $tag, $data->data->images->downsized_medium->url));

                    if ($media = file_get_contents($data->data->images->downsized_medium->url)) {

                        $response = $this->upload->post(
                            'media/upload.json',
                            [
                                'query' => [
                                    'command'     => 'INIT',
                                    'total_bytes' => $data->data->images->downsized_medium->size,
                                    'media_type'  => 'image/gif'
                                ]
                            ]
                        );

                        $response = json_decode((string) $response->getBody());

                        if ($response->media_id_string) {
                            $this->logger->info(sprintf('%s : Upload Media INIT : %s', $params['contest']->getId(), $response->media_id_string));

                            $this->upload->post(
                                'media/upload.json',
                                [
                                    'multipart' => [
                                        [
                                            'name'     => 'command',
                                            'contents' => 'APPEND'
                                        ],
                                        [
                                            'name'     => 'media_id',
                                            'contents' => $response->media_id_string
                                        ],
                                        [
                                            'name'     => 'media',
                                            'contents' => $media
                                        ],

                                        [
                                            'name'     => 'segment_index',
                                            'contents' => 0
                                        ],
                                    ]
                                ]
                            );

                            $this->logger->info(sprintf('%s : Upload Media APPEND : %s', $params['contest']->getId(), $response->media_id_string));

                            $end = $this->upload->post(
                                'media/upload.json',
                                [
                                    'query' => [
                                        'command'  => 'FINALIZE',
                                        'media_id' => $response->media_id_string
                                    ]
                                ]
                            );

                            $this->logger->info(sprintf('%s : Upload Media FINALIZE : %s', $params['contest']->getId(), $response->media_id_string));

                            $upload = json_decode((string) $end->getBody());

                            $mediaId = $upload->media_id_string;
                        }
                    }

                }

                unset($data); // free memory

            }
        } catch (\Exception $e) {

            $mediaId = false;
            $this->logger->info(sprintf('Upload media has failed : %s', $e->getMessage()));
        }

        return $mediaId;

    }
}
