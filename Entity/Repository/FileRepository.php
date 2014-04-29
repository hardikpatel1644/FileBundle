<?php

namespace Oxind\FileBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of FileRepository
 *
 * @author Hardik Patel <hpatel@oxind.com>
 */
class FileRepository extends EntityRepository
{

    /**
     * 
     * @return type
     */
    public function getAllFiles()
    {
        $queryBuilder = $this->createQueryBuilder('f')
                ->select('f');
        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function deleteFile($snId)
    {
        if ($snId != '' && is_numeric($snId))
        {
            $queryBuilder = $this->createQueryBuilder('f');
                    $queryBuilder->delete('file', 'f')                                                            
                    ->where($queryBuilder->expr()->eq('f.id', ':id'))            
                    ->setParameter('id', $snId);

          //  var_dump($queryBuilder->getDQL());exit;
            $queryBuilder->getQuery()->execute();
        }
    }

}

