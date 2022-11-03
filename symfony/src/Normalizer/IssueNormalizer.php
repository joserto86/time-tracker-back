<?php

namespace App\Normalizer;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Repository\Glquery\GlProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class IssueNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    private GlProjectRepository $repository;

    public function __construct(EntityManagerInterface $em, GlProjectRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($em);
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        /** @var GlIssue $object */

        /** @var GlProject $project */
        $project = $this->repository->findOneBy(['glId' => $object->getGlProjectId()]);

        return [
            'id'                   => $object->getId(),
            'glInstance'           => $object->getGlInstance(),
            'glInstanceGroup'      => $object->getGlInstanceGroup(),
            'glId'                 => $object->getGlId(),
            'glProjectId'          => $object->getGlProjectId(),
            'glProject'            => !is_null($project) ? $project->getName() : null,
            'glNamespace'          => !is_null($project) ? $project->getNamespace() : null,
            'milestone'            => $this->getMilestone($object),
            'title'                => $object->getTitle(),
            'description'          => $object->getDescription(),
            'state'                => $object->getState(),
            'createdAt'            => $object->getCreatedAt()->format(self::DEFAULT_FORMAT_DATE),
            'updatedAt'            => $object->getUpdatedAt()->format(self::DEFAULT_FORMAT_DATE),
            'assignee'             => $object->getAssignee(),
            'author'               => $object->getAuthor(),
            'glIid'                => $object->getGlIid(),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return  $data instanceof GlIssue;
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
