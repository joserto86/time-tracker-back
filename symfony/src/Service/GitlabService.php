<?php

namespace App\Service;

use App\Entity\Glquery\GlIssue;
use App\Entity\Main\AppUser;
use App\Entity\Main\AppUserInstance;
use App\Entity\Main\Instance;
use App\Model\GlUser;
use App\Model\TimeNote;
use App\Serializer\TimeTrackerModelNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitlabService
{
    protected HttpClientInterface $client;

    protected InstanceService $service;

    private const VALID_RESPONSE_CODES = [
        Response::HTTP_CREATED,
        Response::HTTP_ACCEPTED
    ];

    public function __construct(HttpClientInterface $client, InstanceService $service)
    {
        $this->client = $client;
        $this->service = $service;
    }

    public function status(Instance $instance, AppUser $user): bool
    {

        if ($appInstance = $this->service->getAppUserInstance($instance, $user)) {
            try {
                $response = $this->client->request(
                    'GET',
                    "{$instance->getUrl()}/api/v4/version",
                    ['headers' => ['Authorization' => "Bearer {$appInstance->getToken()}"]]
                );

                if ($response->getStatusCode() === Response::HTTP_OK) {
                    return true;
                }
            } catch (\Exception $e) {
                throw new \LogicException('Invalid Request', Response::HTTP_BAD_REQUEST);
            }
        }
        throw new \LogicException('Invalid Token', Response::HTTP_UNAUTHORIZED);
    }

    public function getUserData(Instance $instance, AppUser $user)
    {

        if ($appInstance = $this->service->getAppUserInstance($instance, $user)) {

            try {
                $response = $this->client->request(
                    'GET',
                    "{$instance->getUrl()}/api/v4/user",
                    ['headers' => ['Authorization' => "Bearer {$appInstance->getToken()}"]]
                );

                if ($response->getStatusCode() === Response::HTTP_OK) {
                    $encoders = [new JsonEncoder()];
                    $normalizers = [new TimeTrackerModelNormalizer()];
                    $serializer = new Serializer($normalizers, $encoders);

                    return $serializer->deserialize($response->getContent(), GlUser::class, JsonEncoder::FORMAT);
                    //return json_decode($response->getContent());

                }
            } catch (\Exception $e) {
                throw new \LogicException('Invalid Request', Response::HTTP_BAD_REQUEST);
            }
        }
        throw new \LogicException('Invalid Token', Response::HTTP_UNAUTHORIZED);
    }

    public function postTimeNote(GlIssue $issue, AppUser $user, TimeNote $timeNote)
    {
        if ($appInstance = $this->service->getAppUserInstanceByIssue($issue, $user)) {
            try {
                $result = $this->postNote($issue, $appInstance, $this->timeNoteToGitlabNote($timeNote));
                if ($timeNote->getBody()) {
                    $this->postNote($issue, $appInstance, $timeNote->getBody());
                }

                return $result;

            } catch (\Exception $e) {
                throw new \LogicException('Invalid Request', Response::HTTP_BAD_REQUEST);
            }
        }

        throw new \LogicException('Invalid Token', Response::HTTP_UNAUTHORIZED);
    }

    private function postNote(GlIssue $issue, AppUserInstance $appInstance, string $body)
    {
        $response = $this->client->request(
            'POST',
            "{$issue->getGlInstance()}/api/v4/projects/{$issue->getGlProjectId()}/issues/{$issue->getGlIid()}/notes",
            [
                'headers' => ['Authorization' => "Bearer {$appInstance->getToken()}"],
                'query' => ['body' => $body]
            ]
        );

        if (in_array($response->getStatusCode(), self::VALID_RESPONSE_CODES)) {
            return json_decode($response->getContent());
        } else {
            throw new \Exception();
        }
    }

    private function timeNoteToGitlabNote(TimeNote $timeNote) :string
    {
        $time = $timeNote->getTimeSeconds() / 3600;
        $date = '';
        if ($timeNote->getDate()) {
            $date = $timeNote->getDate()->format('Y-m-d');
        }

        return "/spend {$time}h {$date}";
    }
}
