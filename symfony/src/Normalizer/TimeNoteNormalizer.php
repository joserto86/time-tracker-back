<?php

namespace App\Normalizer;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Entity\Glquery\GlTimeNote;
use App\Repository\Glquery\GlIssueRepository;
use App\Repository\Glquery\GlProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TimeNoteNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    private GlIssueRepository $issueRepository;

    private GlProjectRepository $projectRepository;

    public function __construct(
        EntityManagerInterface $em,
        GlProjectRepository $projectRepository,
        GlIssueRepository $issueRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->issueRepository = $issueRepository;
        parent::__construct($em);
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        /** @var GlTimeNote $object */

        /** @var GlIssue $issue */
        $issue = $this->issueRepository->findOneBy(['glId' => $object->getGlIssueId()]);

        /** @var GlProject $project */
        $project = $this->projectRepository->findOneBy(['glId' => $object->getGlProjectId()]);

        return [
            'id'                   => $object->getId(),
            'glInstance'           => $object->getGlInstance(),
            'glId'                 => $object->getGlId(),
            'glProjectId'          => $object->getGlProjectId(),
            'glProject'            => !is_null($project) ? $project->getName() : null,
            'glNamespace'          => !is_null($project) ? $project->getNamespace() : null,
            'glIssueId'            => $object->getGlIssueId(),
            'glIssue'              => $issue->getTitle(),
            'milestone'            => $this->getMilestone($issue),
            'body'                 => $object->getBody(),
            'author'               => $object->getAuthor(),
            'secondsAdded'         => $object->getSecondsAdded(),
            'secondsSubtracted'   => $object->getSecondsSubtracted(),
            'secondsRemoved'       => $object->isSecondsRemoved(),
            'createdAt'            => $object->getCreatedAt()->format(self::DEFAULT_FORMAT_DATE),
            'updatedAt'            => $object->getUpdatedAt()->format(self::DEFAULT_FORMAT_DATE),
            'spentAt'              => $object->getSpentAt()->format(self::DEFAULT_FORMAT_DATE),
            'glIssueIid'           => $object->getGlIssueIid(),
            'computed'             => $object->getComputed()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return  $data instanceof GlTimeNote;
    }

    private function getMilestone(GlIssue $issue): ?string
    {
        $data = json_decode($issue->getData(), true);
        if (array_key_exists('milestone', $data)) {
            $milestone = $data['milestone'];

            if (!is_null($milestone) && array_key_exists('title', $milestone)) {
                return $milestone['title'];
            }
        }

        return null;
    }
}
