<?php

namespace App\Normalizer;

use App\Entity\Glquery\GlIssue;
use App\Entity\Glquery\GlProject;
use App\Model\Issue as IssueModel;
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
            'glProject'            => $project ?? $project->getName(),
            'glNamespace'          => $project ?? $project->getNamespace(),
            'milestone'                 => $object->getYear(),
            'title'                => $object->getTitle(),
            'description'          => $object->getDescription(),
            'state'       => $object->getSummaryStatus(),
            'createdAt' => $object->getSummaryObservations(),
            'summary_date'         => !empty($object->getSummaryDate()) ? $object->getSummaryDate()->format($formatDate) : null,
            'summary_point_a'      => $object->getSummaryPointA(),
            'summary_point_b'      => $object->getSummaryPointB(),
            'summary_point_c'      => $object->getSummaryPointC(),
            'summary_point_d'      => $object->getSummaryPointD(),
            'summary_point_e'      => $object->getSummaryPointE(),
            'summary_point_f'      => $object->getSummaryPointF(),
            'summary_total_points' => $object->getSummaryTotalPoints(),
            'interviewer'          => $interviewer,
            'feedback'             => $object->getFeedback(),
            'company'              => $company,
            'poll'                 => $poll,
            'intermediateAgent'    => $intermediateAgent,
            'instance_graphic'     => $instanceGraphic,
            'reportDate'           => $object->getReportDate(),
            'contact'              => $contact
        ];



        /** @var IssueModel $result */
        $result = $this->basicNormalize($object, IssueModel::class);

        /** @var GlProject $project */
        $project = $this->repository->findOneBy(['glId' => $result->getGlProjectId()]);

        if ($project) {
            $result->setGlProject($project->getName());
            $result->setGlNamespace($project->getNamespace());
        }

        return $this->dismount($result);
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return  $data instanceof GlIssue;
    }
}
