<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{
    /**
     *
     * @return array
     */
    public function obtener_todos_tickets(){
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('t.id','t.fechaCreado','t.estado','u.nombre','t.usuarioId')
            ->from('AppBundle:Ticket','t')
            ->innerJoin('AppBundle:Usuario','u','WITH','t.usuarioId = u.id')
            ->orderBy('t.fecha','ASC')
            ->getQuery()->execute();

    }
}
